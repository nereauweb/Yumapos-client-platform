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

    public function render()
    {
        $you = auth()->user();
        $users = AppUser::when($this->sortField, function ($query) {
            $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
        });

        if ($this->sortRelations) {
            switch ($this->sortRelations) {
                case 'company_data.company_name':
                    $users = AppUser::join('users_company_data as cd', 'cd.user_id', 'users.id')->orderBy('cd.company_name', $this->sortAsc ? 'asc' : 'desc')->select('users.*');
                    break;
                case 'company_data.legal_seat_city':
                    $users = AppUser::join('users_company_data as cd', 'cd.user_id', 'users.id')->orderBy('cd.legal_seat_city', $this->sortAsc ? 'asc' : 'desc')->select('users.*');
                    break;
                default:
                    $users = AppUser::when($this->sortField, function ($query) {
                        $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
                    });
                    break;
            }
        }

        $users = $users->paginate(10);

        $groups = UsersGroup::all();
        return view('livewire.user', compact('users', 'you', 'groups'));
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }
        $this->sortField = $field;
    }

    public function sortByRelations($field)
    {
        if ($this->sortRelations === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }
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

}
