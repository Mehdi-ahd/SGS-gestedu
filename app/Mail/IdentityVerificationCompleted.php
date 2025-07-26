<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class IdentityVerificationCompleted extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Vérification d\'identité complétée')
                    ->view('emails.identity-verification-completed')
                    ->with([
                        'user' => $this->user,
                        'userDetailsUrl' => route('users.show', $this->user->id)
                    ]);
    }
}
