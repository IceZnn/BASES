<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="icon" href="logo.png" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EVERSWEET</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --vinho: #4a0012;
            --vinho-claro: #6b1a2c;
            --rosa-suave: #ffb3c1;
            --creme: #fff9f5;
            --borda: #ead1d1;
            --texto: #2d0a12;
            --danger: #c0392b;
        }

        body {
            background-color: var(--creme);
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            color: var(--texto);
        }

        .navbar {
            background: rgba(74, 0, 18, 0.97);
            backdrop-filter: blur(16px);
            padding: 0 2.5rem;
            position: sticky; top: 0; z-index: 1000;
            box-shadow: 0 2px 30px rgba(74, 0, 18, 0.25);
            height: 68px; display: flex; align-items: center;
        }
        .nav-container { max-width: 1200px; margin: 0 auto; width: 100%; display: flex; justify-content: space-between; align-items: center; }
        .logo span { color: white; font-family: 'Playfair Display', serif; font-size: 22px; font-weight: 700; letter-spacing: 2px; }
        .nav-links { display: flex; gap: 32px; }
        .nav-links a { color: rgba(255,255,255,0.7); text-decoration: none; font-size: 13px; font-weight: 500; letter-spacing: 0.5px; padding: 4px 0; border-bottom: 1px solid transparent; transition: color .2s, border-color .2s; }
        .nav-links a:hover { color: var(--rosa-suave); border-color: var(--rosa-suave); }
        .nav-user { color: rgba(255,255,255,0.6); font-size: 22px; cursor: pointer; }

        .page-wrapper {
            min-height: calc(100vh - 68px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .delete-shell {
            width: 100%;
            max-width: 560px;
        }

        .danger-icon-wrap {
            width: 72px;
            height: 72px;
            background: #fdf0ee;
            border: 2px solid #f5c0b8;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        .danger-icon-wrap i {
            font-size: 28px;
            color: var(--danger);
            animation: wiggle 3s ease-in-out infinite;
        }

        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 30px;
            font-weight: 700;
            color: var(--vinho);
            text-align: center;
            margin-bottom: 6px;
        }
        .page-subtitle {
            text-align: center;
            font-size: 13px;
            color: #a06070;
            margin-bottom: 28px;
        }

        .delete-card {
            background: white;
            border-radius: 24px;
            border: 1px solid var(--borda);
            overflow: hidden;
        }

        .card-header-doce {
            background: linear-gradient(135deg, var(--vinho) 0%, #7a1830 100%);
            padding: 22px 28px;
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .doce-avatar {
            width: 46px;
            height: 46px;
            background: rgba(255,255,255,0.15);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .doce-avatar i { font-size: 20px; color: rgba(255,255,255,0.9); }
        .doce-header-info h3 {
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            color: white;
            font-weight: 700;
            margin-bottom: 2px;
        }
        .doce-header-info span {
            font-size: 12px;
            color: rgba(255,255,255,0.6);
            letter-spacing: 0.5px;
        }
        .doce-badge-id {
            margin-left: auto;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 20px;
            padding: 4px 12px;
            font-size: 12px;
            color: rgba(255,255,255,0.75);
            white-space: nowrap;
        }

        .card-body-doce { padding: 24px 28px; }

        .info-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 10px;
        }
        .info-row.single { grid-template-columns: 1fr; }

        .info-chip {
            background: #fdf8f8;
            border: 1px solid #f0dede;
            border-radius: 12px;
            padding: 10px 14px;
            transition: border-color .2s, background .2s;
        }
        .info-chip:hover { background: white; border-color: #e0b0b8; }
        .info-chip .chip-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #b07080;
            margin-bottom: 3px;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .info-chip .chip-label i { font-size: 11px; }
        .info-chip .chip-value {
            font-size: 14px;
            font-weight: 500;
            color: var(--texto);
            word-break: break-word;
            line-height: 1.4;
        }

        .danger-strip {
            margin: 0 28px 20px;
            background: #fff5f3;
            border: 1px solid #f5c0b8;
            border-radius: 12px;
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            color: #8b2020;
        }
        .danger-strip i { font-size: 16px; color: var(--danger); flex-shrink: 0; }

        .card-footer-actions {
            padding: 0 28px 24px;
            display: flex;
            gap: 12px;
        }

        .btn-voltar {
            background: transparent;
            color: #7a4050;
            border: 1.5px solid var(--borda);
            padding: 13px 22px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 600;
            border-radius: 50px;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 7px;
            transition: all .25s;
            white-space: nowrap;
        }
        .btn-voltar:hover { border-color: var(--vinho); color: var(--vinho); transform: translateY(-2px); }

        .btn-delete {
            flex: 1;
            background: var(--danger);
            color: white;
            border: none;
            padding: 13px 22px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 600;
            border-radius: 50px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all .25s;
            box-shadow: 0 4px 16px rgba(192, 57, 43, 0.3);
        }
        .btn-delete:hover { background: #a93226; transform: translateY(-2px); box-shadow: 0 8px 24px rgba(192, 57, 43, 0.4); }
        .btn-delete:active { transform: translateY(0); }

        @keyframes wiggle {
            0%, 100% { transform: rotate(0deg); }
            20% { transform: rotate(-10deg); }
            40% { transform: rotate(10deg); }
            60% { transform: rotate(-6deg); }
            80% { transform: rotate(6deg); }
        }

        @media (max-width: 768px) {
            .nav-links { display: none; }
            .card-header-doce { padding: 18px 20px; }
            .card-body-doce { padding: 20px; }
            .danger-strip { margin: 0 20px 16px; }
            .card-footer-actions { padding: 0 20px 20px; flex-direction: column-reverse; }
            .info-row { grid-template-columns: 1fr; }
            .doce-badge-id { display: none; }
        }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="nav-container">
        <div class="logo"><span>EVERSWEET</span></div>
        <div class="nav-links">
            <a href="/Inicio">Início</a>
            <a href="/Login">Login</a>
            <a href="/Dashboard">Dashboard</a>
            <a href="/doces">Doces</a>
            <a href="/Sobre">Sobre</a>
        </div>
        <a href="/Perfil">
            <i class="fas fa-user-circle nav-user"></i>
        </a>
    </div>
</nav>

<div class="page-wrapper">
    <div class="delete-shell">

        <div class="danger-icon-wrap">
            <i class="fas fa-trash-alt"></i>
        </div>
        <h1 class="page-title">Deletar Doce</h1>
        <p class="page-subtitle">Revise as informações antes de confirmar</p>

        <div class="delete-card">

            <div class="card-header-doce">
                <div class="doce-avatar">
                    <i class="fas fa-cookie-bite"></i>
                </div>
                <div class="doce-header-info">
                    <h3>{{ $doce->Nome ?? 'Doce' }}</h3>
                    <span>{{ $doce->Sabor ?? '' }}</span>
                </div>
                <div class="doce-badge-id">#{{ $doce->id ?? $id }}</div>
            </div>

            <div class="card-body-doce">
                <div class="info-row">
                    <div class="info-chip">
                        <div class="chip-label"><i class="fas fa-dollar-sign"></i> Preço</div>
                        <div class="chip-value">R$ {{ number_format($doce->Preco ?? 0, 2, ',', '.') }}</div>
                    </div>
                    <div class="info-chip">
                        <div class="chip-label"><i class="fas fa-box"></i> Quantidade</div>
                        <div class="chip-value">{{ $doce->Quantidade ?? 0 }} unidades</div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-chip">
                        <div class="chip-label"><i class="fas fa-exclamation-triangle"></i> Alérgicos</div>
                        <div class="chip-value">{{ $doce->Alergicos ?? 'Nenhum' }}</div>
                    </div>
                    <div class="info-chip">
                        <div class="chip-label"><i class="fas fa-list"></i> Ingredientes</div>
                        <div class="chip-value">{{ Str::limit($doce->Ingredientes ?? 'Não informado', 40) }}</div>
                    </div>
                </div>
                <div class="info-row single">
                    <div class="info-chip">
                        <div class="chip-label"><i class="fas fa-align-left"></i> Descrição</div>
                        <div class="chip-value">{{ $doce->Descricao ?? 'Sem descrição' }}</div>
                    </div>
                </div>
            </div>

            <div class="danger-strip">
                <i class="fas fa-exclamation-circle"></i>
                Esta ação é<strong>permanente</strong>e não poderá ser desfeita.
            </div>

            <form id="deleteForm" action="{{ url('/deletar/' . $id) }}" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" name="token" value="{{ request()->query('token') }}">

                <div class="card-footer-actions">
                    <a href="/doces" class="btn-voltar"><i class="fas fa-arrow-left"></i> Voltar</a>
                    <button type="button" class="btn-delete" id="btnDeletar">
                        <i class="fas fa-trash-alt"></i> Confirmar exclusão
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    document.getElementById('btnDeletar').addEventListener('click', function () {
        Swal.fire({
            title: 'Tem certeza?',
            text: 'Você não poderá reverter esta ação!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#c0392b',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sim, deletar!',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm').submit();
            }
        });
    });
</script>
</body>
</html>