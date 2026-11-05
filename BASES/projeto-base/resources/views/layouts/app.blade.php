<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Painel') · Projeto Base</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root { --sidebar-width: 260px; --brand: #3758f9; }
        body { background: #f5f7fb; color: #20283e; }
        .sidebar { position: fixed; inset: 0 auto 0 0; width: var(--sidebar-width); background: #fff; border-right: 1px solid #e8ebf2; z-index: 1020; overflow-y: auto; }
        .sidebar-link { display: flex; align-items: center; gap: .75rem; padding: .65rem 1rem; color: #687087; text-decoration: none; border-radius: .65rem; }
        .sidebar-link:hover, .sidebar-link.active { background: #eef1ff; color: var(--brand); }
        .main-area { margin-left: var(--sidebar-width); min-height: 100vh; }
        .topbar { background: #fff; border-bottom: 1px solid #e8ebf2; }
        .card { border: 1px solid #e9ecf3; border-radius: 1rem; box-shadow: 0 3px 14px rgba(27,39,75,.035); }
        .btn-primary { background: var(--brand); border-color: var(--brand); }
        .table > :not(caption) > * > * { padding: .85rem .75rem; vertical-align: middle; }
        .table-sort-link { color: inherit; text-decoration: none; white-space: nowrap; }
        .table-sort-link:hover { color: var(--brand); }
        .sidebar { display: flex; flex-direction: column; }
        @media (max-width: 991.98px) { .sidebar { position: static; width: 100%; } .main-area { margin-left: 0; } }
    </style>
    @stack('styles')
</head>
<body>
@auth
    <x-sidebar />
@endauth
<div class="main-area">
    @auth
        <x-navbar />
    @endauth
    <main class="container-fluid px-3 px-lg-4 py-4">
        <x-alert />
        @yield('content')
    </main>
    @include('partials.footer')
</div>
<x-toast />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.querySelectorAll('[data-auto-toast]').forEach((element) => new bootstrap.Toast(element, { delay: 5000 }).show());

    document.querySelectorAll('[data-confirm-delete]').forEach((button) => {
        button.addEventListener('click', () => {
            const form = document.querySelector('[data-delete-confirmation-form]');
            form.action = button.dataset.confirmDelete;
            document.querySelector('[data-delete-record-label]').textContent = button.dataset.recordLabel;
        });
    });

    document.querySelectorAll('form').forEach((form) => {
        form.addEventListener('submit', (event) => {
            if (form.dataset.skipLoading !== undefined || form.method.toLowerCase() === 'get') return;

            const button = event.submitter;
            if (!button || button.disabled) return;

            button.disabled = true;
            button.dataset.originalContent = button.innerHTML;
            button.innerHTML = '<span class="spinner-border spinner-border-sm me-2" aria-hidden="true"></span>Processando...';
        });
    });
</script>
@stack('scripts')
</body>
</html>
