<?php

namespace App\Jobs;

use App\Models\Chamado;
use App\Services\Esp32Service;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use RuntimeException;

class NotificarNovoChamadoNoEsp32 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 5;

    public function __construct(public int $chamadoId)
    {
    }

    public function backoff(): array
    {
        return [5, 15, 30, 60];
    }

    public function handle(Esp32Service $esp32): void
    {
        $chamado = Chamado::with(['prioridade', 'local', 'categoria'])->findOrFail($this->chamadoId);
        $resultado = $esp32->notificarNovoChamado($chamado);

        if (! $resultado['success']) {
            throw new RuntimeException($resultado['message']);
        }
    }
}
