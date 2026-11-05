@extends('layouts.app')
@section('title', 'Configurações')
@section('content')
<x-breadcrumb :items="['Início' => route('dashboard'), 'Configurações' => null]" />
<div class="mb-4"><h1 class="h3 mb-1">Configurações</h1><p class="text-secondary mb-0">Preferências pessoais da sua conta.</p></div>
<div class="card"><div class="card-body p-4">
    <form method="POST" action="{{ route('settings.update') }}">@csrf @method('PUT')
        <div class="mb-3"><label for="language" class="form-label">Idioma preferido</label><select class="form-select" name="language" id="language"><option value="pt_BR" @selected(($preferences['language'] ?? 'pt_BR') === 'pt_BR')>Português (Brasil)</option><option value="en" @selected(($preferences['language'] ?? '') === 'en')>English</option></select></div>
        <div class="mb-3"><label for="theme" class="form-label">Tema</label><select class="form-select" name="theme" id="theme"><option value="light" @selected(($preferences['theme'] ?? 'light') === 'light')>Claro</option><option value="dark" @selected(($preferences['theme'] ?? '') === 'dark')>Escuro (preferência salva para extensão futura)</option></select></div>
        <x-button type="submit">Salvar preferências</x-button>
    </form>
</div></div>
@endsection
