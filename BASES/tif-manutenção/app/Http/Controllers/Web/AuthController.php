<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginForm() { return view('auth.login'); }

    public function registerForm() { return view('auth.register'); }

    public function login(Request $request)
    {
        $data = $request->validate(['email' => 'required|email', 'password' => 'required|string']);
        $email = strtolower(trim($data['email']));
        $user = User::where('email', $email)->where('ativo', true)->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            return back()->withErrors(['email' => 'E-mail, senha ou situação da conta inválida.'])->withInput();
        }
        Auth::login($user, true);
        $request->session()->regenerate();
        $request->session()->put('api_token', $user->createToken('web-session')->plainTextToken);
        return redirect()->intended($user->podeGerenciarChamados() ? route('dashboard') : route('home')); 
    }

    public function register(Request $request)
    {
        $request->merge(['email' => strtolower(trim((string) $request->input('email')))]);
        $data = $request->validate([
            'name' => 'required|string|max:120', 'email' => 'required|email|unique:users',
            'telefone' => 'nullable|string|max:30', 'password' => 'required|string|min:8|confirmed',
            'tipo' => 'required|in:Aluno,Professor,Funcionário',
        ]);
        $tipo = $data['tipo'] === 'Funcionário' ? 'Manutenção' : $data['tipo'];
        $user = User::create([...$data, 'tipo' => $tipo, 'password' => Hash::make($data['password']), 'ativo' => true]);
        Auth::login($user);
        $request->session()->regenerate();
        $request->session()->put('api_token', $user->createToken('web-session')->plainTextToken);
        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        if ($request->user()?->currentAccessToken()) $request->user()->currentAccessToken()->delete();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}