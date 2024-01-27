<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerifyMail extends Mailable
{
    use Queueable, SerializesModels;

    public User   $user;
    public string $verification_code;

    public function canBeMailSending() {}

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, string $verification_code)
    {
        $user->userVerifications->eMailLastCodeSendDate > now() ? abort(403, 'Too many requests') : null;
        $this->user              = $user;
        $this->verification_code = $verification_code;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Fenocity Verify Mail',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            markdown: 'emails.verify-mail',
            with    : [
                          'name'              => 'name',
                          'verification_code' => 'verification_code',
                      ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
