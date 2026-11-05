<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Models\Usuario;
use Illuminate\Mail\Message;

class EnviarEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    protected $usuario;

    public function __construct(Usuario $usuario)
    {
        $this->usuario = $usuario;
    }

    public function handle(): void
    {
        // Envia o e-mail usando a view Blade
        Mail::send('email.bemvindo', ['usuario' => $this->usuario], function (Message $message) {
            $message->to($this->usuario->email, $this->usuario->nome)
                    ->subject('🍬 Bem-vindo à EVERSWEET! 🎉')
                    ->from('contato@eversweet.com', 'EVERSWEET Doces Artesanais');
        });
    }
}