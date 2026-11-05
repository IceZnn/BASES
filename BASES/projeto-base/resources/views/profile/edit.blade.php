@extends('layouts.app')
@section('title', 'Meu perfil')
@section('content')
<x-breadcrumb :items="['Início' => route('dashboard'), 'Perfil' => null]" />
<h1 class="h3 mb-4">Meu perfil</h1>
<div class="row g-4">
    <div class="col-lg-7"><div class="card"><div class="card-header bg-white border-0 pt-4 px-4 fw-semibold">Dados pessoais</div><div class="card-body p-4">
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">@csrf @method('PUT')
            <x-input name="name" label="Nome" :value="$user->name" required />
            <x-input name="email" label="E-mail" type="email" :value="$user->email" required />
            <x-input name="phone" label="Telefone" :value="$user->phone" />
            <x-input name="photo" label="Foto de perfil" type="file" accept="image/*" />
            @if($user->photo)<img src="{{ Storage::disk('public')->url($user->photo) }}" class="rounded-circle mb-3" width="72" height="72" alt="Foto atual">@endif
            <x-input name="bio" label="Sobre você" :value="$user->profile?->bio" />
            <x-input name="address" label="Endereço" :value="$user->profile?->address" />
            <x-button type="submit">Salvar perfil</x-button>
        </form>
    </div></div></div>
    <div class="col-lg-5"><div class="card"><div class="card-header bg-white border-0 pt-4 px-4 fw-semibold">Alterar senha</div><div class="card-body p-4">
        <form method="POST" action="{{ route('profile.password') }}">@csrf @method('PUT')
            <x-input name="current_password" label="Senha atual" type="password" required autocomplete="current-password" />
            <x-input name="password" label="Nova senha" type="password" required autocomplete="new-password" />
            <x-input name="password_confirmation" label="Confirme a nova senha" type="password" required autocomplete="new-password" />
            <x-button type="submit">Atualizar senha</x-button>
        </form>
    </div></div></div>
</div>
@endsection
