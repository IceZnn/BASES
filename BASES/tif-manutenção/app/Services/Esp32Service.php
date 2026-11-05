<?php

namespace App\Services;

use App\Models\Chamado;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class Esp32Service
{
    private const LEDS = [
        'verde' => ['ligar' => 'ligarverde', 'desligar' => 'desligarverde'],
        'amarelo' => ['ligar' => 'ligaramarelo', 'desligar' => 'desligaramarelo'],
        'vermelho' => ['ligar' => 'ligarvermelho', 'desligar' => 'desligarvermelho'],
    ];

    public function ligarVerde(): array { return $this->setLed('verde', true); }
    public function desligarVerde(): array { return $this->setLed('verde', false); }
    public function ligarAmarelo(): array { return $this->setLed('amarelo', true); }
    public function desligarAmarelo(): array { return $this->setLed('amarelo', false); }
    public function ligarVermelho(): array { return $this->setLed('vermelho', true); }
    public function desligarVermelho(): array { return $this->setLed('vermelho', false); }

    public function statusTodos(): array
    {
        return $this->get('/led/status');
    }

    public function statusLed(string $cor): array
    {
        $cor = $this->normalizarCor($cor);

        return $this->get("/led/status/{$cor}");
    }

    /** @return array{success: bool, message: string, data?: mixed} */
    public function notificarNovoChamado(Chamado $chamado): array
    {
        $chamado->loadMissing(['prioridade', 'local', 'categoria']);

        $nivel = $chamado->prioridade?->nome;
        $blocoAndar = array_filter([
            $chamado->local?->bloco,
            $chamado->local?->andar,
        ]);
        $local = $chamado->local?->nome;

        if ($blocoAndar !== []) {
            $local .= ' ('.implode(', ', $blocoAndar).')';
        }

        $payload = [
            'id' => $chamado->id,
            'titulo' => $chamado->titulo,
            'prioridade' => $nivel,
            'led' => config("services.esp32.priorities.{$nivel}"),
            'local' => $local,
            'categoria' => $chamado->categoria?->nome,
            'status' => $chamado->status,
            'criado_em' => $chamado->data_abertura?->toIso8601String(),
        ];

        return $this->postJson(
            (string) config('services.esp32.display_path', '/chamado/novo'),
            $payload,
            'novo chamado'
        );
    }

    /** @return array{success: bool, message: string, data?: mixed} */
    private function setLed(string $cor, bool $ligado): array
    {
        $acao = $ligado ? 'ligar' : 'desligar';
        $endpoint = self::LEDS[$cor][$acao];
        $caminho = "/led/{$endpoint}";

        return $this->postJson($caminho, [], "{$acao} o LED {$cor}");
    }

    /** @param array<string, mixed> $payload
     *  @return array{success: bool, message: string, data?: mixed}
     */
    private function postJson(string $path, array $payload, string $acao): array
    {
        try {
            $url = $this->url($path);
            $request = Http::timeout($this->timeout());
            $response = $payload === []
                ? $request->post($url)
                : $request->asJson()->post($url, $payload);

            if (! $response->successful()) {
                return $this->falha("ESP32 respondeu HTTP {$response->status()} ao {$acao}.", $url);
            }

            return ['success' => true, 'message' => "Solicitação para {$acao} enviada ao ESP32.", 'data' => $response->json()];
        } catch (ConnectionException $exception) {
            return $this->falha("Não foi possível conectar ao ESP32 para {$acao}.", $url ?? (string) config('services.esp32.url'), $exception);
        } catch (\RuntimeException $exception) {
            return $this->falha($exception->getMessage(), (string) config('services.esp32.url'));
        }
    }

    /** @return array{success: bool, message: string, data?: mixed} */
    private function get(string $path): array
    {
        try {
            $url = $this->url($path);
            $response = Http::timeout($this->timeout())->get($url);

            if (! $response->successful()) {
                return $this->falha("ESP32 respondeu HTTP {$response->status()} ao consultar o status.", $url);
            }

            return ['success' => true, 'message' => 'Status do ESP32 consultado.', 'data' => $response->json() ?? $response->body()];
        } catch (ConnectionException $exception) {
            return $this->falha('Não foi possível conectar ao ESP32 para consultar o status.', $url ?? (string) config('services.esp32.url'), $exception);
        } catch (\RuntimeException $exception) {
            return $this->falha($exception->getMessage(), (string) config('services.esp32.url'));
        }
    }

    private function url(string $path): string
    {
        $baseUrl = rtrim((string) config('services.esp32.url'), '/');

        if ($baseUrl === '') {
            throw new \RuntimeException('ESP32_URL não está configurada.');
        }

        return $baseUrl.$path;
    }

    private function timeout(): int
    {
        return (int) config('services.esp32.timeout', 3);
    }

    private function normalizarCor(string $cor): string
    {
        $cor = strtolower($cor);

        if (! array_key_exists($cor, self::LEDS)) {
            throw new InvalidArgumentException("Cor de LED inválida: {$cor}.");
        }

        return $cor;
    }

    private function falha(string $message, string $url, ?ConnectionException $exception = null): array
    {
        Log::warning('ESP32 offline ou requisição malsucedida.', [
            'url' => $url,
            'message' => $message,
            'exception' => $exception?->getMessage(),
        ]);

        return ['success' => false, 'message' => $message];
    }

}
