<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate(['email' => 'required|email', 'password' => 'required']);
        $email = strtolower(trim($data['email']));
        $user = User::where('email', $email)->where('ativo', true)->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json(['message' => 'Credenciais inválidas.'], 422);
        }
        return response()->json(['token' => $user->createToken('web')->plainTextToken, 'user' => $user]);
    }

    public function register(Request $request)
    {
        $request->merge(['email' => strtolower(trim((string) $request->input('email')))]);
        $data = $request->validate(['name' => 'required|string|max:120', 'email' => 'required|email|unique:users', 'password' => 'required|string|min:8|confirmed', 'tipo' => 'nullable|in:Professor,Funcionário,Aluno']);
        $tipo = ($data['tipo'] ?? 'Aluno') === 'Funcionário' ? 'Manutenção' : ($data['tipo'] ?? 'Aluno');
        $user = User::create([...$data, 'password' => Hash::make($data['password']), 'tipo' => $tipo]);
        return response()->json(['token' => $user->createToken('web')->plainTextToken, 'user' => $user], 201);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Sessão encerrada.']);
    }
}