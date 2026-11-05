<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Usuario;

class BemVindoMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(protected Usuario $usuario)
    {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bem vindo, ' . $this->usuario->nome,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'email.bemvindo',
            with: ['usuario' => $this->usuario]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}