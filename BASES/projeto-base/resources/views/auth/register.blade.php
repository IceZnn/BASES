@extends('layouts.auth')
@section('title', 'Cadastro')
@section('content')
<h1 class="h3 mb-1">Crie sua conta</h1><p class="text-secondary mb-4">Preencha os dados para começar.</p>
<form method="POST" action="{{ route('register.store') }}">@csrf
    <x-input name="name" label="Nome" required autocomplete="name" />
    <x-input name="email" label="E-mail" type="email" required autocomplete="email" />
    <x-input name="phone" label="Telefone" type="tel" autocomplete="tel" />
    <x-input name="password" label="Senha (mínimo 8 caracteres)" type="password" required autocomplete="new-password" />
    <x-input name="password_confirmation" label="Confirme a senha" type="password" required autocomplete="new-password" />
    <x-button type="submit" class="w-100 py-2 mt-2">Criar conta</x-button>
</form>
<p class="text-center text-secondary mt-4 mb-0">Já possui conta? <a href="{{ route('login') }}">Entrar</a></p>
@endsection
