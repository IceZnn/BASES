<aside class="sidebar p-3">
    <a class="d-flex align-items-center gap-2 text-decoration-none text-dark fw-bold fs-5 px-2 py-3" href="{{ route('dashboard') }}">
        <i class="bi bi-grid-1x2-fill text-primary"></i> Projeto Base
    </a>
    <div class="text-uppercase text-secondary small fw-semibold px-3 mt-4 mb-2">Visão geral</div>
    <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
    @if(in_array(auth()->user()->role, ['administrator', 'manager'], true))
        <div class="text-uppercase text-secondary small fw-semibold px-3 mt-4 mb-2">Cadastros</div>
        @foreach([
            'users' => ['Usuários', 'people'],
            'products' => ['Produtos', 'box-seam'],
            'categories' => ['Categorias', 'tags'],
            'clients' => ['Clientes', 'person-lines-fill'],
            'suppliers' => ['Fornecedores', 'truck'],
            'orders' => ['Pedidos', 'receipt'],
            'employees' => ['Funcionários', 'person-badge'],
            'departments' => ['Departamentos', 'diagram-3'],
        ] as $resource => [$label, $icon])
            <a href="{{ route('admin.'.$resource.'.index') }}" class="sidebar-link {{ request()->routeIs('admin.'.$resource.'.*') ? 'active' : '' }}">
                <i class="bi bi-{{ $icon }}"></i> {{ $label }}
            </a>
        @endforeach
        <a href="{{ route('admin.stock.index') }}" class="sidebar-link {{ request()->routeIs('admin.stock.*') ? 'active' : '' }}"><i class="bi bi-boxes"></i> Estoque</a>
        <a href="{{ route('admin.reports.index') }}" class="sidebar-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}"><i class="bi bi-bar-chart"></i> Relatórios</a>
    @endif
    <div class="text-uppercase text-secondary small fw-semibold px-3 mt-4 mb-2">Conta</div>
    <a href="{{ route('profile.edit') }}" class="sidebar-link"><i class="bi bi-person-circle"></i> Meu perfil</a>
    <a href="{{ route('settings.edit') }}" class="sidebar-link"><i class="bi bi-gear"></i> Configurações</a>
    <a href="{{ route('notifications.index') }}" class="sidebar-link"><i class="bi bi-bell"></i> Notificações</a>
</aside>
