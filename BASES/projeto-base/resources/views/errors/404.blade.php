@extends('layouts.auth')
@section('title', 'Página não encontrada')
@section('content')
<div class="text-center"><div class="display-2 fw-bold text-primary">404</div><h1 class="h4">Página não encontrada</h1><p class="text-secondary">O endereço informado não existe ou foi movido.</p><a class="btn btn-primary" href="{{ route('home') }}">Voltar ao início</a></div>
@endsection
