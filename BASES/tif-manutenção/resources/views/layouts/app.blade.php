<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title', 'Manutenção Tatuí')</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
<style>
:root{--navy:#102744;--blue:#246bce;--paper:#f6f8fb;--ink:#172235}body{background:var(--paper);color:var(--ink);font-family:'DM Sans',sans-serif}h1,h2,h3,.brand{font-family:'Space Grotesk',sans-serif}.sidebar{background:var(--navy);min-height:100vh;width:250px;position:fixed;left:0;top:0;z-index:10}.brand{color:#fff;letter-spacing:-.04em}.brand-mark{width:34px;height:34px;background:#f0c84b;color:var(--navy);display:grid;place-items:center;border-radius:9px;font-weight:700}.nav-link{color:#b9c6d8;border-radius:8px;padding:.7rem .85rem}.nav-link:hover,.nav-link.active{background:#ffffff16;color:#fff}.main{margin-left:250px}.topbar{height:76px;background:#fff;border-bottom:1px solid #e5eaf1}.panel{background:#fff;border:1px solid #e5eaf1;border-radius:14px;box-shadow:0 10px 30px #1027440d}.eyebrow{color:var(--blue);text-transform:uppercase;letter-spacing:.13em;font-size:.72rem;font-weight:700}.stat{border-left:4px solid var(--blue)}.table>:not(caption)>*>*{padding:1rem .75rem}@media(max-width:767px){.sidebar{width:72px}.sidebar .label,.sidebar .brand-text{display:none}.sidebar .nav-link{text-align:center;font-size:1.15rem}.main{margin-left:72px}.topbar{padding-left:1rem!important;padding-right:1rem!important}}
</style>
</head>
<body>
@php($administrativo = auth()->user()->podeGerenciarChamados())
<aside class="sidebar p-3">
<a class="brand d-flex align-items-center gap-2 text-decoration-none mb-4" href="{{ $administrativo ? route('dashboard') : route('home') }}"><span class="brand-mark">M</span><span class="brand-text">manutenção.tatuí</span></a>
<nav class="d-grid gap-1">
@if($administrativo)
<a class="nav-link {{ request()->routeIs('dashboard')?'active':'' }}" href="{{ route('dashboard') }}">⌂ <span class="label">Dashboard</span></a>
<a class="nav-link {{ request()->routeIs('chamados.index')?'active':'' }}" href="{{ route('chamados.index') }}">☷ <span class="label">Chamados</span></a>
<a class="nav-link {{ request()->routeIs('relatorios')?'active':'' }}" href="{{ route('relatorios') }}">▥ <span class="label">Relatórios</span></a>
<a class="nav-link {{ request()->routeIs('automation')?'active':'' }}" href="{{ route('automation') }}">◎ <span class="label">Automação</span></a>
@if(auth()->user()->tipo === 'Administrador')<a class="nav-link" href="{{ route('categorias') }}">⚙ <span class="label">Categorias</span></a><a class="nav-link" href="{{ route('locais') }}">⌖ <span class="label">Locais</span></a>@endif
@else
<a class="nav-link {{ request()->routeIs('home')?'active':'' }}" href="{{ route('home') }}">⌂ <span class="label">Home</span></a>
@endif
<a class="nav-link {{ request()->routeIs('chamados.create')?'active':'' }}" href="{{ route('chamados.create') }}">＋ <span class="label">Abrir Chamado</span></a>
<a class="nav-link {{ request()->routeIs('chamados.mine')?'active':'' }}" href="{{ route('chamados.mine') }}">▤ <span class="label">Meus Chamados</span></a>
<a class="nav-link {{ request()->routeIs('profile')?'active':'' }}" href="{{ route('profile') }}">◉ <span class="label">Meu Perfil</span></a>
</nav>
<form action="{{ route('logout') }}" method="post" class="mt-4">@csrf<button class="nav-link border-0 bg-transparent w-100 text-start">↪ <span class="label">Sair</span></button></form>
</aside>
<div class="main"><header class="topbar d-flex align-items-center justify-content-between px-4"><div><span class="text-secondary small">Área de trabalho</span><h1 class="h5 mb-0">@yield('heading', 'Home')</h1></div><div class="text-end"><strong class="small d-block">{{ auth()->user()->name }}</strong><span class="text-secondary small">{{ auth()->user()->tipo }}</span></div></header><main class="p-4 p-lg-5">@yield('content')</main></div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script><script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>@yield('scripts')
</body></html>