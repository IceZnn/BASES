<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chamado;
use App\Http\Requests\StoreChamadoRequest;
use App\Http\Resources\ChamadoResource;
use Illuminate\Http\Request;

class ChamadoController extends Controller
{
    public function index(Request $request)
    {
        $query = Chamado::with(['usuario:id,name', 'local:id,nome', 'categoria:id,nome', 'prioridade:id,nome,cor']);
        if (!$request->user()->podeGerenciarChamados()) $query->where('usuario_id', $request->user()->id);
        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('busca')) $query->where('titulo', 'like', '%'.$request->busca.'%');
        return ChamadoResource::collection($query->latest('data_abertura')->paginate(10));
    }

    public function show(Request $request, Chamado $chamado)
    {
        abort_unless($request->user()->podeGerenciarChamados() || $chamado->usuario_id === $request->user()->id, 403);
        return new ChamadoResource($chamado->load(['usuario', 'local', 'categoria', 'prioridade', 'historicos.usuario']));
    }

    public function store(StoreChamadoRequest $request)
    {
        $data = $request->validated();
        $data['usuario_id'] = $request->user()->id;
        if ($request->hasFile('foto')) $data['foto'] = $request->file('foto')->store('chamados', 'public');
        $chamado = Chamado::create($data);
        return (new ChamadoResource($chamado->load(['local', 'categoria', 'prioridade'])))->response()->setStatusCode(201);
    }

    public function update(Request $request, Chamado $chamado)
    {
        abort_unless($request->user()->podeGerenciarChamados() || $chamado->usuario_id === $request->user()->id, 403);
        abort_unless($request->user()->podeGerenciarChamados() || $chamado->status === 'Pendente', 403);
        $data = $request->validate(['titulo' => 'sometimes|string|max:160', 'descricao' => 'sometimes|string', 'status' => 'sometimes|in:Pendente,Em atendimento,Resolvido', 'prioridade_id' => 'sometimes|exists:prioridades,id', 'categoria_id' => 'sometimes|exists:categorias,id', 'local_id' => 'sometimes|exists:locais,id', 'foto' => 'nullable|image|max:5120']);
        if (!$request->user()->podeGerenciarChamados()) unset($data['status']);
        $statusAnterior = $chamado->status;
        if ($request->hasFile('foto')) $data['foto'] = $request->file('foto')->store('chamados', 'public');
        if (($data['status'] ?? null) === 'Resolvido') $data['data_conclusao'] = now();
        $chamado->update($data);
        if (array_key_exists('status', $data) || $request->filled('observacao')) $chamado->historicos()->create(['usuario_id' => $request->user()->id, 'observacao' => $request->input('observacao', 'Chamado atualizado.'), 'status_anterior' => $statusAnterior, 'novo_status' => $chamado->status]);
        return new ChamadoResource($chamado->fresh()->load(['local', 'categoria', 'prioridade', 'historicos.usuario']));
    }

    public function destroy(Request $request, Chamado $chamado)
    {
        abort_unless($request->user()->tipo === 'Administrador', 403);
        $chamado->delete();
        return response()->noContent();
    }
}