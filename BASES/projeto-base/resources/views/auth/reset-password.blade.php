@extends('layouts.auth')
@section('title', 'Redefinir senha')
@section('content')
<h1 class="h3 mb-1">Defina uma nova senha</h1><p class="text-secondary mb-4">Escolha uma senha segura para sua conta.</p>
<form method="POST" action="{{ route('password.update') }}">@csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <x-input name="email" label="E-mail" type="email" required :value="$email" />
    <x-input name="password" label="Nova senha" type="password" required autocomplete="new-password" />
    <x-input name="password_confirmation" label="Confirme a nova senha" type="password" required autocomplete="new-password" />
    <x-button type="submit" class="w-100">Redefinir senha</x-button>
</form>
@endsection
