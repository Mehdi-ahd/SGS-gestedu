<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Teaching;
use App\Models\User;

class TeacherAssigned extends Mailable
{
    use Queueable, SerializesModels;

    public $teaching;
    public $teacher;

    /**
     * Create a new message instance.
     */
    public function __construct(Teaching $teaching, User $teacher)
    {
        $this->teaching = $teaching;
        $this->teacher = $teacher;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nouvelle assignation d\'enseignement - GestEdu',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.teacher-assigned',
            with: [
                'teaching' => $this->teaching,
                'teacher' => $this->teacher,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
