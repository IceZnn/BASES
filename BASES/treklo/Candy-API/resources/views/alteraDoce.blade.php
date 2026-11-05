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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --vinho: #4a0012;
            --vinho-claro: #6b1a2c;
            --rosa-suave: #ffb3c1;
            --creme: #fff9f5;
            --borda: #ead1d1;
            --texto: #2d0a12;
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
        .nav-user { color: rgba(255,255,255,0.6); font-size: 22px; cursor: pointer; transition: color .2s; }
        .nav-user:hover { color: var(--rosa-suave); }

        .page-header { text-align: center; padding: 56px 20px 40px; }
        .page-header .eyebrow { font-size: 11px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; color: #c06070; margin-bottom: 10px; }
        .page-header h1 { font-family: 'Playfair Display', serif; font-size: clamp(32px, 5vw, 52px); font-weight: 700; color: var(--vinho); letter-spacing: -1px; }

        .form-card {
            background: white;
            border-radius: 28px;
            border: 1px solid var(--borda);
            box-shadow: 0 8px 40px rgba(74, 0, 18, 0.07);
            padding: 40px;
            max-width: 760px;
            margin: 0 auto 60px;
        }

        .form-section-title {
            display: flex; align-items: center; gap: 10px;
            font-size: 11px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase;
            color: #c06070; margin-bottom: 28px; padding-bottom: 16px; border-bottom: 1px solid var(--borda);
        }
        .form-section-title i { font-size: 14px; color: var(--vinho); }

        .form-label { font-size: 11px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: var(--vinho); margin-bottom: 6px; display: block; }

        .form-control {
            border: 1.5px solid var(--borda); border-radius: 12px; padding: 12px 16px;
            font-family: 'DM Sans', sans-serif; font-size: 14px; background: #fff; color: var(--texto);
            width: 100%; transition: border-color .2s, box-shadow .2s; outline: none;
        }
        .form-control:focus { border-color: var(--vinho); box-shadow: 0 0 0 3px rgba(74, 0, 18, 0.08); }
        .form-control::placeholder { color: #c9a0a8; }
        textarea.form-control { resize: vertical; min-height: 88px; }

        .btn-actions { display: flex; gap: 14px; margin-top: 32px; }

        .btn-save {
            background: var(--vinho); color: white; border: none;
            padding: 14px 32px; font-family: 'DM Sans', sans-serif;
            font-size: 14px; font-weight: 600; border-radius: 50px; cursor: pointer;
            display: flex; align-items: center; gap: 8px; flex: 1; justify-content: center;
            transition: all .25s; box-shadow: 0 6px 20px rgba(74, 0, 18, 0.25);
        }
        .btn-save:hover { background: var(--vinho-claro); transform: translateY(-2px); box-shadow: 0 10px 28px rgba(74, 0, 18, 0.35); }

        .btn-voltar {
            background: transparent; color: #7a4050; border: 1.5px solid var(--borda);
            padding: 14px 28px; font-family: 'DM Sans', sans-serif;
            font-size: 14px; font-weight: 600; border-radius: 50px; cursor: pointer;
            text-decoration: none; display: flex; align-items: center; gap: 8px;
            transition: all .25s; white-space: nowrap;
        }
        .btn-voltar:hover { border-color: var(--vinho); color: var(--vinho); transform: translateY(-2px); }

        .input-wrap { position: relative; margin-bottom: 0; }
        .input-wrap i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #c4748a;
            font-size: 14px;
            pointer-events: none;
            transition: color 0.2s;
        }
        .form-control.with-icon { padding-left: 40px; }
        .form-control:focus + i { color: var(--vinho); }
        .form-control.is-invalid { border-color: #e53e3e !important; box-shadow: 0 0 0 3px rgba(229, 62, 62, 0.1) !important; }
        .form-control.is-valid { border-color: #10b981 !important; box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1) !important; }
        .field-error { display: none; font-size: 12px; color: #c53030; margin-top: 5px; }
        .field-error.show { display: block; }

        .spinner {
            display: none;
            width: 18px;
            height: 18px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top: 2px solid white;
            border-right: 2px solid white;
            border-radius: 50%;
            animation: spin 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55) infinite;
        }

        .btn-save.loading .btn-text { display: none; }
        .btn-save.loading .spinner { display: inline-block; }
        .btn-save:disabled { opacity: 0.65; cursor: not-allowed; transform: none; }

        @keyframes spin { to { transform: rotate(360deg); } }

        @media (max-width: 768px) {
            .nav-links { display: none; }
            .form-card { padding: 24px 18px; }
            .btn-actions { flex-direction: column; }
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

<div class="container px-3">
    <div class="page-header">
        <p class="eyebrow">Gerenciar Catálogo</p>
        <h1>Editar Doce</h1>
    </div>

    <div class="form-card">
        <div class="form-section-title">
            <i class="fas fa-pen"></i>
            Alterar Dados do Doce
        </div>

        <form id="editaDoceForm">
            <input type="hidden" id="doceId" value="{{ $doce->id ?? '' }}">

            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label">Nome</label>
                    <div class="input-wrap">
                        <input type="text" class="form-control with-icon" id="inputNome" name="Nome" value="{{ $doce->Nome ?? '' }}" placeholder="Ex: Brigadeiro de Pistache">
                        <i class="fa-solid fa-tag"></i>
                    </div>
                    <div class="field-error" id="err-inputNome">O nome é obrigatório.</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Sabor</label>
                    <div class="input-wrap">
                        <input type="text" class="form-control with-icon" id="inputSabor" name="Sabor" value="{{ $doce->Sabor ?? '' }}" placeholder="Ex: Doce / Amargo">
                        <i class="fa-solid fa-palette"></i>
                    </div>
                    <div class="field-error" id="err-inputSabor">O sabor é obrigatório.</div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Preço (R$)</label>
                    <div class="input-wrap">
                        <input type="text" class="form-control with-icon" id="inputPreco" name="Preco" value="{{ $doce->Preco ?? '' }}" placeholder="0,00">
                        <i class="fa-solid fa-dollar-sign"></i>
                    </div>
                    <div class="field-error" id="err-inputPreco">O preço é obrigatório.</div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Quantidade</label>
                    <div class="input-wrap">
                        <input type="number" class="form-control with-icon" id="inputQuantidade" name="Quantidade" value="{{ $doce->Quantidade ?? '' }}" placeholder="0">
                        <i class="fa-solid fa-box"></i>
                    </div>
                    <div class="field-error" id="err-inputQuantidade">A quantidade é obrigatória.</div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Alérgicos</label>
                    <div class="input-wrap">
                        <input type="text" class="form-control with-icon" id="inputAlergicos" name="Alergicos" value="{{ $doce->Alergicos ?? '' }}" placeholder="Ex: Lactose">
                        <i class="fa-solid fa-exclamation-triangle"></i>
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label">Ingredientes</label>
                    <div class="input-wrap">
                        <input type="text" class="form-control with-icon" id="inputIngredientes" name="Ingredientes" value="{{ $doce->Ingredientes ?? '' }}" placeholder="Liste os ingredientes">
                        <i class="fa-solid fa-list"></i>
                    </div>
                    <div class="field-error" id="err-inputIngredientes">Os ingredientes são obrigatórios.</div>
                </div>
                <div class="col-12">
                    <label class="form-label">Descrição</label>
                    <div class="input-wrap">
                        <textarea class="form-control with-icon" id="inputDescricao" name="Descricao" rows="2" placeholder="Breve descrição do doce" style="padding-left: 40px;">{{ $doce->Descricao ?? '' }}</textarea>
                        <i class="fa-solid fa-align-left"></i>
                    </div>
                    <div class="field-error" id="err-inputDescricao">A descrição é obrigatória.</div>
                </div>
            </div>

            <div class="btn-actions">
                <a href="/doces" class="btn-voltar"><i class="fas fa-arrow-left"></i> Voltar</a>
                <button type="button" class="btn-save" id="atualizaBotao">
                    <span class="btn-text"><i class="fas fa-save"></i> Atualizar Doce</span>
                    <div class="spinner"></div>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function () {
    const token = $.cookie('token');
    const id    = $('#doceId').val();

    // Validação em tempo real
    $('#inputNome, #inputSabor, #inputPreco, #inputQuantidade, #inputIngredientes, #inputDescricao').on('input change', function () {
        const fieldId = $(this).attr('id');
        $(this).removeClass('is-invalid is-valid');
        $('#err-' + fieldId).removeClass('show');
    });

    $('#atualizaBotao').click(function () {
        let valid = true;
        const campos = ['inputNome', 'inputSabor', 'inputPreco', 'inputQuantidade', 'inputIngredientes', 'inputDescricao'];
        
        campos.forEach(function(fieldId) {
            if (!$('#' + fieldId).val().trim()) {
                $('#' + fieldId).addClass('is-invalid');
                $('#err-' + fieldId).addClass('show');
                valid = false;
            }
        });

        if (!valid) return;

        const $btn = $(this).addClass('loading').prop('disabled', true);

        $.ajax({
            url: `/api/atualiza_doce/${id}?token=${token}`,
            type: 'POST',
            data: {
                _method:      'PUT',
                Nome:         $('#inputNome').val(),
                Sabor:        $('#inputSabor').val(),
                Preco:        $('#inputPreco').val(),
                Quantidade:   $('#inputQuantidade').val(),
                Alergicos:    $('#inputAlergicos').val(),
                Ingredientes: $('#inputIngredientes').val(),
                Descricao:    $('#inputDescricao').val()
            },
            success: function () {
                Swal.fire({ title: 'Sucesso!', text: 'Doce atualizado.', icon: 'success', confirmButtonColor: '#4a0012' })
                    .then(() => { window.location.href = '/doces'; });
            },
            error: function (err) {
                Swal.fire({ title: 'Erro!', text: 'Não foi possível atualizar: ' + (err.responseJSON?.message ?? 'erro desconhecido'), icon: 'error', confirmButtonColor: '#4a0012' });
                $btn.removeClass('loading').prop('disabled', false);
            }
        });
    });
});
</script>
</body>
</html>