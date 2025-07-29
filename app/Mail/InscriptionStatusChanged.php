<?php

namespace App\Mail;

use App\Models\Inscription;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InscriptionStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public $inscription;
    public $newStatus;
    public $parent;

    public function __construct(Inscription $inscription, $newStatus, User $parent)
    {
        $this->inscription = $inscription;
        $this->newStatus = $newStatus;
        $this->parent = $parent;
    }

    public function build()
    {
        $subject = $this->newStatus === 'accepté' 
            ? 'Inscription acceptée - ' . $this->inscription->student->getFullName()
            : 'Inscription refusée - ' . $this->inscription->student->getFullName();

        return $this->subject($subject)
                    ->view('emails.inscription-status-changed');
    }
}
