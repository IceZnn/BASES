<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chamado;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __invoke()
    {
        abort_unless(request()->user()->podeGerenciarChamados(), 403);
        $base = Chamado::query();
        $meses = Chamado::get()->groupBy(fn ($chamado) => $chamado->data_abertura->format('Y-m'))->map(fn ($itens, $mes) => ['mes' => $mes, 'total' => $itens->count()])->values();
        return response()->json([
            'indicadores' => [
                'total' => (clone $base)->count(), 'pendentes' => (clone $base)->where('status', 'Pendente')->count(),
                'atendimento' => (clone $base)->where('status', 'Em atendimento')->count(), 'resolvidos' => (clone $base)->where('status', 'Resolvido')->count(),
                'nivel_1' => (clone $base)->where('prioridade_id', 1)->count(), 'nivel_2' => (clone $base)->where('prioridade_id', 2)->count(), 'nivel_3' => (clone $base)->where('prioridade_id', 3)->count(),
            ],
            'categorias' => Chamado::join('categorias', 'categorias.id', '=', 'chamados.categoria_id')->select('categorias.nome', DB::raw('count(*) as total'))->groupBy('categorias.id', 'categorias.nome')->get(),
            'prioridades' => Chamado::join('prioridades', 'prioridades.id', '=', 'chamados.prioridade_id')->select('prioridades.nome', DB::raw('count(*) as total'))->groupBy('prioridades.id', 'prioridades.nome')->get(),
            'meses' => $meses,
        ]);
    }
}
