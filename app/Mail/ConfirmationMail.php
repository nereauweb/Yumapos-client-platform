<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;


    protected $user;
    protected $notHashedPwd;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $notHashedPwd)
    {
        $this->user = $user;
        $this->notHashedPwd = $notHashedPwd;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Attivazione servizi Yuma')->from('postmaster@yumapos.it','Yumapos')->markdown('emails.confirmation')->with(['user' => $this->user, 'password' => $this->notHashedPwd]);
    }
}
