<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    private function autorizar(Request $request): void { abort_unless($request->user()->tipo === 'Administrador', 403); }
    public function index(Request $request) { $this->autorizar($request); return response()->json(User::query()->when($request->busca, fn ($q, $busca) => $q->where('name', 'like', "%$busca%"))->latest()->paginate(15)); }
    public function update(Request $request, User $user) { $this->autorizar($request); $data = $request->validate(['name' => 'sometimes|string|max:120', 'telefone' => 'nullable|string|max:30', 'tipo' => 'sometimes|in:Administrador,Manutenção,Professor,Funcionário,Aluno', 'ativo' => 'sometimes|boolean', 'password' => 'nullable|string|min:8']); if (!empty($data['password'])) $data['password'] = Hash::make($data['password']); else unset($data['password']); $user->update($data); return response()->json($user); }
    public function destroy(Request $request, User $user) { $this->autorizar($request); abort_if($request->user()->is($user), 422, 'Não é possível excluir o próprio usuário.'); $user->delete(); return response()->noContent(); }
}
