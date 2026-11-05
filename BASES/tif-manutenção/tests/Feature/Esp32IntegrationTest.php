<?php

namespace Tests\Feature;

use App\Jobs\SincronizarLedsChamados;
use App\Jobs\NotificarNovoChamadoNoEsp32;
use App\Models\Categoria;
use App\Models\Chamado;
use App\Models\Local;
use App\Models\Prioridade;
use App\Models\User;
use App\Services\Esp32Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class Esp32IntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['services.esp32.url' => 'http://192.168.0.150']);
    }

    public function test_service_sends_post_requests_to_each_led_route(): void
    {
        Http::fake(['*' => Http::response(['ok' => true], 200)]);
        $service = app(Esp32Service::class);

        foreach ([
            'ligarVerde' => '/led/ligarverde',
            'desligarVerde' => '/led/desligarverde',
            'ligarAmarelo' => '/led/ligaramarelo',
            'desligarAmarelo' => '/led/desligaramarelo',
            'ligarVermelho' => '/led/ligarvermelho',
            'desligarVermelho' => '/led/desligarvermelho',
        ] as $method => $path) {
            $this->assertTrue($service->{$method}()['success']);
            Http::assertSent(fn ($request) => $request->method() === 'POST' && $request->url() === 'http://192.168.0.150'.$path);
        }
    }

    public function test_service_reads_all_and_single_led_status(): void
    {
        Http::fake(['*' => Http::response(['ligado' => true], 200)]);
        $service = app(Esp32Service::class);

        $this->assertSame(['ligado' => true], $service->statusTodos()['data']);
        $this->assertSame(['ligado' => true], $service->statusLed('AMARELO')['data']);
        Http::assertSent(fn ($request) => $request->method() === 'GET' && $request->url() === 'http://192.168.0.150/led/status');
        Http::assertSent(fn ($request) => $request->method() === 'GET' && $request->url() === 'http://192.168.0.150/led/status/amarelo');
    }

    public function test_service_posts_new_ticket_data_to_the_display_endpoint(): void
    {
        Http::fake(['*' => Http::response(['ok' => true], 202)]);
        Queue::fake();
        $chamado = $this->criarChamado(prioridadeId: 2, status: 'Pendente');

        $result = app(Esp32Service::class)->notificarNovoChamado($chamado);

        $this->assertTrue($result['success']);
        Http::assertSent(fn ($request) =>
            $request->method() === 'POST'
            && $request->url() === 'http://192.168.0.150/chamado/novo'
            && $request->data()['id'] === $chamado->id
            && $request->data()['prioridade'] === 'Nível 2'
            && $request->data()['led'] === 'amarelo'
            && $request->data()['local'] === 'Bloco teste'
        );
    }

    public function test_service_returns_clear_failure_when_esp32_is_offline(): void
    {
        Http::fake(fn () => throw new ConnectionException('offline'));

        $result = app(Esp32Service::class)->ligarVerde();

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('Não foi possível conectar', $result['message']);
    }

    public function test_job_turns_on_a_priority_led_when_an_active_ticket_exists(): void
    {
        Queue::fake();
        $this->criarChamado(prioridadeId: 1, status: 'Pendente');
        Http::fake(['*' => Http::response(['ok' => true], 200)]);

        (new SincronizarLedsChamados())->handle(app(Esp32Service::class));

        Http::assertSent(fn ($request) => $request->method() === 'POST' && $request->url() === 'http://192.168.0.150/led/ligarverde');
        Http::assertSent(fn ($request) => $request->method() === 'POST' && $request->url() === 'http://192.168.0.150/led/desligaramarelo');
        Http::assertSent(fn ($request) => $request->method() === 'POST' && $request->url() === 'http://192.168.0.150/led/desligarvermelho');
    }

    public function test_job_turns_off_led_when_no_active_ticket_exists_for_priority(): void
    {
        Queue::fake();
        $this->criarChamado(prioridadeId: 3, status: 'Resolvido');
        Http::fake(['*' => Http::response(['ok' => true], 200)]);

        (new SincronizarLedsChamados())->handle(app(Esp32Service::class));

        Http::assertSent(fn ($request) => $request->url() === 'http://192.168.0.150/led/desligarvermelho');
    }

    public function test_observer_dispatches_led_sync_after_ticket_creation(): void
    {
        Queue::fake();
        $this->criarChamado(prioridadeId: 1, status: 'Pendente');

        Queue::assertPushed(SincronizarLedsChamados::class);
        Queue::assertPushed(NotificarNovoChamadoNoEsp32::class);
    }

    public function test_api_create_and_resolve_routes_dispatch_led_sync(): void
    {
        Queue::fake();
        $user = User::create(['name' => 'Administrador teste', 'email' => 'api-test@example.test', 'password' => 'password', 'tipo' => 'Administrador']);
        $local = Local::create(['nome' => 'Bloco API']);
        $categoria = Categoria::create(['nome' => 'Elétrica']);
        $prioridade = Prioridade::create(['nome' => 'Nível 1', 'cor' => '#00ff00']);

        $created = $this->actingAs($user)->postJson('/api/chamados', [
            'local_id' => $local->id,
            'categoria_id' => $categoria->id,
            'prioridade_id' => $prioridade->id,
            'titulo' => 'Chamado via API',
            'descricao' => 'Descrição do chamado',
        ]);
        $created->assertCreated();
        $chamadoId = $created->json('data.id');

        $this->actingAs($user)->putJson("/api/chamados/{$chamadoId}", ['status' => 'Resolvido'])->assertOk();

        Queue::assertPushed(SincronizarLedsChamados::class, 2);
        Queue::assertPushed(NotificarNovoChamadoNoEsp32::class, 1);
    }

    private function criarChamado(int $prioridadeId, string $status): Chamado
    {
        $user = User::create(['name' => 'Teste', 'email' => uniqid().'@example.test', 'password' => 'password', 'tipo' => 'Administrador']);
        $local = Local::create(['nome' => 'Bloco teste']);
        $categoria = Categoria::create(['nome' => 'Elétrica']);

        while (Prioridade::whereKey($prioridadeId)->doesntExist()) {
            $id = (int) Prioridade::max('id') + 1;
            Prioridade::create(['id' => $id, 'nome' => "Nível {$id}", 'cor' => '#000000']);
        }

        return Chamado::create([
            'usuario_id' => $user->id,
            'local_id' => $local->id,
            'categoria_id' => $categoria->id,
            'prioridade_id' => $prioridadeId,
            'titulo' => 'Chamado de teste',
            'descricao' => 'Descrição',
            'status' => $status,
        ]);
    }
}
