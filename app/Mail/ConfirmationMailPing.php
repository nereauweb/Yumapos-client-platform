<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmationMailPing extends Mailable
{
    use Queueable, SerializesModels;

	protected $context = 'Ping';
	protected $context_url = 'https://dash.ping.international';
	protected $context_title = 'Ping International';
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
        return $this->subject('Attivazione servizi Ping')->from('info@ping.international','Ping International')->markdown('emails.confirmation')->with(['user' => $this->user, 'password' => $this->notHashedPwd, 'context' => $this->context, 'context_url' => $this->context_url, 'context_title' => $this->context_title]);
    }
}
