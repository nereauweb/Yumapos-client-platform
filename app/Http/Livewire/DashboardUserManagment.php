<?php

namespace App\Http\Livewire;

use App\Mail\ConfirmationMail;
use App\Models\UsersGroup;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Component;

class DashboardUserManagment extends Component
{
    public $user_id;
    public $user;

    public $debt_limit;
    public $plafond;
    public $parent_percent;
    public $group_id;

    public function render()
    {
        $groups = UsersGroup::all();
        return view('livewire.dashboard-user-managment', compact('groups'));
    }

    public function approve($id) {
        $this->user_id = $id;
    }

    public function store() {
        $user = User::findOrFail($this->user_id);
        if ($user) {
            $this->validate([
                'parent_percent' => 'required',
                'group_id' => 'required',
                'plafond' => 'required',
                'debt_limit' => 'required'
            ]);

            try {
                $notHashedPassword = Str::random(10);

                $user->update([
                    'state' => 1,
                    'group_id' => $this->group_id,
                    'plafond' => $this->plafond,
                    'debt_limit' => $this->debt_limit,
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
