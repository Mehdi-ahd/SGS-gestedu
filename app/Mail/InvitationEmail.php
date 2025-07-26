<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvitationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $invitationLink;
    public $roleName;

    public function __construct($invitationLink, $roleName)
    {
        $this->invitationLink = $invitationLink;
        $this->roleName = $roleName;
    }

    public function build()
    {
        return $this->subject('Invitation à rejoindre GestEdu')
                    ->view('emails.invitation')
                    ->with([
                        'invitationLink' => $this->invitationLink,
                        'roleName' => $this->roleName,
                    ]);
    }
}
