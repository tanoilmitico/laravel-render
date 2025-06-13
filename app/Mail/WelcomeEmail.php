<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    /**
     * Create a new message instance.
     */
    public function __construct($user)
    {
        $this->user=$user;
    }

    /**
     * chi è in copia a chi rispondiamo etc.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from:new Address('provissima@corsolaravel.iom', 'Edoardo Midalion'),
            subject: 'Welcome Email',
        );
    }

    /**
     * Il contenuto.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.welcome',
            with: ['user' => $this->user],
        );
    }

    /**
     * Gli allegati.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
