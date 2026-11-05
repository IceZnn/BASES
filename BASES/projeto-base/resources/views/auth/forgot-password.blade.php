@extends('layouts.auth')
@section('title', 'Recuperar senha')
@section('content')
<h1 class="h3 mb-1">Recuperar senha</h1><p class="text-secondary mb-4">Enviaremos um link para o e-mail cadastrado.</p>
<form method="POST" action="{{ route('password.email') }}">@csrf<x-input name="email" label="E-mail" type="email" required autofocus /><x-button type="submit" class="w-100">Enviar link</x-button></form>
<p class="text-center mt-4 mb-0"><a href="{{ route('login') }}">Voltar ao login</a></p>
@endsection
