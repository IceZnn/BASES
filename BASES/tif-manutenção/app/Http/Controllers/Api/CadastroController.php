<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Local;
use Illuminate\Http\Request;

class CadastroController extends Controller
{
    private function autorizado(Request $request): void { abort_unless($request->user()->podeGerenciarChamados(), 403); }
    public function index(Request $request, string $tipo) { $this->autorizado($request); $model = $this->model($tipo); return response()->json($model::query()->latest()->paginate(15)); }
    public function store(Request $request, string $tipo) { $this->autorizado($request); $model = $this->model($tipo); $data = $request->validate($this->rules($tipo)); return response()->json($model::create($data), 201); }
    public function update(Request $request, string $tipo, int $id) { $this->autorizado($request); $record = $this->model($tipo)::findOrFail($id); $record->update($request->validate($this->rules($tipo, true))); return response()->json($record); }
    public function destroy(Request $request, string $tipo, int $id) { $this->autorizado($request); $this->model($tipo)::findOrFail($id)->delete(); return response()->noContent(); }
    private function model(string $tipo): string { return match ($tipo) { 'categorias' => Categoria::class, 'locais' => Local::class, default => abort(404) }; }
    private function rules(string $tipo, bool $optional = false): array { $prefix = $optional ? 'sometimes|' : ''; return $tipo === 'categorias' ? ['nome' => $prefix.'required|string|max:100', 'descricao' => 'nullable|string'] : ['nome' => $prefix.'required|string|max:100', 'bloco' => 'nullable|string|max:50', 'andar' => 'nullable|string|max:50', 'descricao' => 'nullable|string']; }
}
