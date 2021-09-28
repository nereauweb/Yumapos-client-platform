<?php

namespace App\Http\Livewire;

use App\Mail\ConfirmationMail;
use App\Mail\ConfirmationMailPing;
use App\Models\UsersGroup;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Component;

use \Swift_Mailer;
use \Swift_SmtpTransport as SmtpTransport;

class DashboardUserManagment extends Component
{
    public $user_id;
    public $user;

    public $debt_limit;
    public $plafond;
    public $parent_percent;
    public $group_id;

    /*
     * render function loads the component in welcome.blade.php.
     * */
    public function render()
    {
        $groups = UsersGroup::all();
        return view('livewire.dashboard-user-managment', compact('groups'));
    }

    // approve function gets called when we click on approve inside dashboard when approving the users
    public function approve($id) {
        $this->user_id = $id;
    }

    // store function updates the state of the user depending on if approved or not
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

                // mail is sent to the user with the not hashed password
                Mail::to($user->email)->send(new ConfirmationMail($user, $notHashedPassword));
				
				if($user->parent_id==172){
					//set
					$transport = (new SmtpTransport('smtp.office365.com', 587, 'TLS'))->setUsername('info@ping.international')->setPassword('729507Byt3!');
					$mailer = new Swift_Mailer($transport);
					Mail::setSwiftMailer($mailer);
					//send
					Mail::to($user->email)->send(new ConfirmationMailPing($user, $notHashedPassword));
					//reset
					$transport = (new SmtpTransport(config('mail.host'), config('mail.port'), config('mail.encryption')))->setUsername(config('mail.username'))->setPassword(config('mail.password'));
					$mailer = new Swift_Mailer($transport);
					Mail::setSwiftMailer($mailer);
					session()->flash('success', 'User approved successfully! (PING)');
				} else {
					Mail::to($user->email)->send(new ConfirmationMail($user, $notHashedPassword));
					session()->flash('success', 'User approved successfully!');
				}
                
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
    // the user doesn't get approved
    public function destroy($id) {
        $this->user_id = $id;
    }

    // the user gets removed from the list and moves to the trashed list
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

    // the inputs which admin has to fill gets reseted if in case there's an error in approval
    private function resetInputFields(){
        $this->parent_percent = '';
        $this->group = '';
        $this->user_id = '';
    }
}
