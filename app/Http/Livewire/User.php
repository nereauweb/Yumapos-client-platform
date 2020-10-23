<?php

namespace App\Http\Livewire;

use App\Mail\ConfirmationMail;
use App\Models\UserCompanyData;
use App\Models\UsersGroup;
use Illuminate\Support\Str;
use App\User as AppUser;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class User extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $parent_percent;
    public $groupId;
    public $user_id;

    public $sortField;
    public $sortAsc = true;

    public $sortRelations;

    public $totalBalance;
    public $negativeBalance;
    public $positiveBalance;

    public $positiveBalanceUsersCount;
    public $negativeBalanceUsersCount;
    public $zeroBalanceUsersCount;

    public $stateUserSelected;
    public $balanceUserSelected;
    public $roleSelected;

    public $unapprovedUsers;
    public $trashedUsers;
    public $approvedUsers;

    public $roleUserSelected;
    public $cityUserSelected;

    public $searchInput;

    private $users;

    public function render()
    {

        $users = AppUser::join('users_company_data as ucd', 'ucd.user_id', 'users.id')->when($this->sortField, function ($query) {
            $query->orderBy('users.'.$this->sortField, $this->sortAsc ? 'asc' : 'desc');
        })->when($this->sortRelations, function ($query) {
            $query->orderBy($this->sortRelations, $this->sortAsc ? 'asc' : 'desc');
        })->select('users.*');

        $this->approvedUsers = AppUser::where('state', 1)->count();
        $this->unapprovedUsers = AppUser::where('state', 0)->count();
        $this->positiveBalanceUsersCount = AppUser::where('state',1)->where('plafond', '>', 0)->count();
        $this->negativeBalanceUsersCount = AppUser::where('state',1)->where('plafond', '<', 0)->count();
        $this->zeroBalanceUsersCount = AppUser::where('state',1)->where('plafond', '-', 0)->count();
        $this->trashedUsers = AppUser::onlyTrashed()->count();
        $you = auth()->user();



        $cities = UserCompanyData::distinct()->get('legal_seat_city');

        $this->totalBalance = AppUser::where('state', 1)->sum('plafond');
        $this->negativeBalance = AppUser::where('plafond', '<', 0)->where('state', 1)->sum('plafond');
        $this->positiveBalance = AppUser::where('plafond', '>', 0)->where('state', 1)->sum('plafond');

        $users = !is_null($this->users) ? $this->users->paginate(10) : $users->paginate(10);

        $groups = UsersGroup::all();
        $roles = Role::all();

        return view('livewire.user', compact('users', 'you', 'groups', 'cities', 'roles'));
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }
        $this->sortRelations = '';
        $this->sortField = $field;
    }

    public function sortByRelations($field)
    {
        if ($this->sortRelations === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }
        $this->sortField = '';
        $this->sortRelations = $field;
    }

    public function approve($id) {
        $this->user_id = $id;
    }

    public function store() {
        $user = AppUser::findOrFail($this->user_id);
        if ($user) {
            $this->validate([
                'parent_percent' => 'required',
                'groupId' => 'required'
            ]);

            try {
                $notHashedPassword = Str::random(10);

                $user->update([
                    'state' => 1,
                    'group_id' => $this->groupId,
                    'parent_percent' => $this->parent_percent,
                    'password' => bcrypt($notHashedPassword),
                ]);


                Mail::to($user->email)->send(new ConfirmationMail($user, $notHashedPassword));

                session()->flash('success', 'User approved successfully!');
                $this->resetInputFields();
                $this->emit('userClose');


            } catch (\Throwable $th) {
                throw $th;
            }

        } else {
            session()->flash('error','User not found in database!');
            $this->resetInputFields();
            $this->emit('userClose');
        }
    }

    public function destroy($id) {
        $this->user_id = $id;
    }

    public function delete()
    {
        $user = AppUser::findOrFail($this->user_id);
        if ($user) {
            try {
                $user->delete();
                session()->flash('warning','User deleted successfully!');
                $this->resetInputFields();
                $this->emit('userClose');
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    }

    private function resetInputFields(){
        $this->parent_percent = '';
        $this->group = '';
        $this->user_id = '';
    }

    public function commit() {
        $this->users = AppUser::join('users_company_data as ucd', 'ucd.user_id', 'users.id')->when($this->sortField, function ($query) {
            $query->orderBy('users.'.$this->sortField, $this->sortAsc ? 'asc' : 'desc');
        })->when($this->sortRelations, function ($query) {
            $query->orderBy($this->sortRelations, $this->sortAsc ? 'asc' : 'desc');
        })->when($this->stateUserSelected, function ($query) {
            if ($this->stateUserSelected == 1) {
                $query->where('users.state', '=', 1);
            } else if ($this->stateUserSelected  == 2) {
                $query->onlyTrashed();
            } else if ($this->stateUserSelected == 3) {
                $query->where('users.state', '=', 0);
            }
        })->when($this->balanceUserSelected, function ($query) {
            if ($this->balanceUserSelected == 1) {
                $query->where('users.plafond', '>', 0);
            } else if ($this->balanceUserSelected == 2) {
                $query->where('users.plafond', '<', 0);
            } else if ($this->balanceUserSelected == 3) {
                $query->where('users.plafond', '=', 0);
            }
        })->when($this->roleUserSelected !== 'null' && $this->roleUserSelected, function ($query) {
            $query->role($this->roleUserSelected);
        })->when($this->cityUserSelected !== 'null' && $this->cityUserSelected, function ($query) {
            $query->where('ucd.legal_seat_city', '=', $this->cityUserSelected);
        })->select('users.*');
    }

    public function search() {
        $this->users = AppUser::join('users_company_data as ucd', 'ucd.user_id', 'users.id')->when($this->searchInput !== 'null' && $this->searchInput, function ($query) {
            $query->where('ucd.company_name', 'like', '%'.$this->searchInput.'%')->orWhere('users.email', 'like', '%'.$this->searchInput.'%');
        })->select('users.*');
    }

}
