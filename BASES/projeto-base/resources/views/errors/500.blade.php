@extends('layouts.auth')
@section('title', 'Erro interno')
@section('content')
<div class="text-center"><div class="display-2 fw-bold text-danger">500</div><h1 class="h4">Algo deu errado</h1><p class="text-secondary">Ocorreu um erro inesperado. Tente novamente mais tarde.</p><a class="btn btn-primary" href="{{ route('home') }}">Voltar ao início</a></div>
@endsection
