@extends('layouts.auth')
@section('title', 'Início')
@section('content')
<div class="text-center py-2">
    <span class="badge rounded-pill text-bg-primary-subtle text-primary mb-3">Laravel 12 · PHP 8.3+</span>
    <h1 class="display-6 fw-bold">Uma base sólida para seu próximo projeto.</h1>
    <p class="lead text-secondary mt-3">Boas práticas, autenticação, CRUDs, relacionamentos e API prontos para adaptar.</p>
    <div class="d-flex justify-content-center gap-2 mt-4">
        @auth<a class="btn btn-primary btn-lg" href="{{ route('dashboard') }}">Abrir painel</a>
        @else<a class="btn btn-primary btn-lg" href="{{ route('register') }}">Começar agora</a><a class="btn btn-outline-secondary btn-lg" href="{{ route('login') }}">Entrar</a>@endauth
    </div>
</div>
<div class="row g-3 mt-4">
    @foreach([['CRUDs reutilizáveis', 'Cadastros com pesquisa, filtros e paginação.'], ['API protegida', 'Tokens pessoais via Laravel Sanctum.'], ['Relacionamentos', 'Exemplos Eloquent para domínios comuns.']] as [$heading, $description])
        <div class="col-md-4"><div class="card h-100"><div class="card-body"><i class="bi bi-check-circle text-primary fs-4"></i><h2 class="h5 mt-3">{{ $heading }}</h2><p class="text-secondary mb-0">{{ $description }}</p></div></div></div>
    @endforeach
</div>
@endsection
