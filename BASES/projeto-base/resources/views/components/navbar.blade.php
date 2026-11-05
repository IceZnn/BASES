<header class="topbar px-3 px-lg-4 py-3 d-flex align-items-center justify-content-between">
    <div>
        <span class="text-secondary small">Olá,</span>
        <strong>{{ auth()->user()->name }}</strong>
    </div>
    <div class="d-flex align-items-center gap-3">
        <span class="badge rounded-pill text-bg-light border">{{ ucfirst(auth()->user()->role) }}</span>
        <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-person"></i> Perfil</a>
        <form method="POST" action="{{ route('logout') }}">@csrf<button class="btn btn-sm btn-outline-danger"><i class="bi bi-box-arrow-right"></i> Sair</button></form>
    </div>
</header>
