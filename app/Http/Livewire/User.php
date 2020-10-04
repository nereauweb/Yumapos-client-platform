<?php

namespace App\Http\Livewire;

use App\Mail\ConfirmationMail;
use App\Models\UsersGroup;
use Illuminate\Support\Str;
use App\User as AppUser;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithPagination;

class User extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $parent_percent;
    public $groupId;
    public $user_id;

    public function render()
    {
        $you = auth()->user();
        $users = AppUser::orderBy('created_at', 'desc')->paginate(10);
        $groups = UsersGroup::all();
        return view('livewire.user', compact('users', 'you', 'groups'));
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
