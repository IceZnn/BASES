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

class SincronizarLedsChamados implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 5;

    public function backoff(): array
    {
        return [5, 15, 30, 60];
    }

    public function handle(Esp32Service $esp32): void
    {
        $prioridades = config('services.esp32.priorities', []);

        foreach ($prioridades as $nivel => $cor) {
            $deveFicarLigado = Chamado::query()
                ->whereHas('prioridade', fn ($query) => $query->where('nome', $nivel))
                ->whereIn('status', ['Pendente', 'Em atendimento'])
                ->exists();

            $resultado = $this->acionar($esp32, $cor, $deveFicarLigado);

            if (! $resultado['success']) {
                throw new RuntimeException($resultado['message']);
            }
        }
    }

    private function acionar(Esp32Service $esp32, string $cor, bool $ligado): array
    {
        return match ($cor) {
            'verde' => $ligado ? $esp32->ligarVerde() : $esp32->desligarVerde(),
            'amarelo' => $ligado ? $esp32->ligarAmarelo() : $esp32->desligarAmarelo(),
            'vermelho' => $ligado ? $esp32->ligarVermelho() : $esp32->desligarVermelho(),
            default => throw new RuntimeException("Cor de LED inválida configurada: {$cor}."),
        };
    }
}
