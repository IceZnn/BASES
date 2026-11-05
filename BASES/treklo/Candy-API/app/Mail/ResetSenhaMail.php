<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetSenhaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $codigo;
    public $email;

    public function __construct($codigo, $email)
    {
        $this->codigo = $codigo;
        $this->email = $email;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Recupere sua senha',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'email.reset_senha',
            with: ['codigo' => $this->codigo, 'email' => $this->email]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
