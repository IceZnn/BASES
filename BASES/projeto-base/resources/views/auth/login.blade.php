@extends('layouts.auth')
@section('title', 'Entrar')
@section('content')
<h1 class="h3 mb-1">Acesse sua conta</h1><p class="text-secondary mb-4">Entre para continuar no painel.</p>
<form method="POST" action="{{ route('login.store') }}">@csrf
    <x-input name="email" label="E-mail" type="email" autocomplete="username" required autofocus />
    <x-input name="password" label="Senha" type="password" autocomplete="current-password" required />
    <div class="d-flex justify-content-between align-items-center mb-4"><label class="form-check"><input class="form-check-input" type="checkbox" name="remember"><span class="form-check-label">Lembrar de mim</span></label><a href="{{ route('password.request') }}" class="small">Esqueci a senha</a></div>
    <x-button type="submit" class="w-100 py-2">Entrar</x-button>
</form>
<p class="text-center text-secondary mt-4 mb-0">Ainda não tem conta? <a href="{{ route('register') }}">Cadastre-se</a></p>
@endsection
