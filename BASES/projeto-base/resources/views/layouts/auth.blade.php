<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Acesso') · Projeto Base</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>body{min-height:100vh;background:linear-gradient(135deg,#edf1ff,#f9fbff);display:grid;place-items:center}.auth-card{width:min(100% - 2rem,480px);border:0;border-radius:1.25rem;box-shadow:0 20px 70px rgba(37,54,104,.12)}.brand-icon{width:3rem;height:3rem;border-radius:.9rem;background:#3758f9;color:#fff;display:grid;place-items:center}</style>
</head>
<body>
    <div class="w-100 d-flex justify-content-center py-4">
        <div class="auth-card card p-4 p-md-5">
            <a href="{{ route('home') }}" class="text-decoration-none text-dark d-flex align-items-center gap-3 mb-4">
                <span class="brand-icon"><i class="bi bi-grid-1x2-fill"></i></span>
                <span><strong>Projeto Base</strong><small class="d-block text-secondary">Laravel 12 Boilerplate</small></span>
            </a>
            <x-alert />
            @yield('content')
        </div>
    </div>
    <x-toast />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>document.querySelectorAll('[data-auto-toast]').forEach((element) => new bootstrap.Toast(element, { delay: 5000 }).show());</script>
</body>
</html>
