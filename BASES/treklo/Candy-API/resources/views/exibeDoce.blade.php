<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="icon" href="logo.png" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EVERSWEET</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <script src="inicial.js"></script>
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

        .navbar-sweet {
            background: rgba(74, 0, 18, 0.97);
            backdrop-filter: blur(16px);
            padding: 0 2.5rem;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 30px rgba(74, 0, 18, 0.25);
            height: 68px;
            display: flex;
            align-items: center;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo span {
            color: white;
            font-family: 'Playfair Display', serif;
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 2px;
        }

        .nav-links {
            display: flex;
            gap: 32px;
        }

        .nav-links a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            letter-spacing: 0.5px;
            padding: 4px 0;
            border-bottom: 1px solid transparent;
            transition: color .2s, border-color .2s;
        }

        .nav-links a:hover {
            color: var(--rosa-suave);
            border-color: var(--rosa-suave);
        }

        .nav-user {
            color: rgba(255,255,255,0.6);
            font-size: 22px;
            cursor: pointer;
            transition: color .2s;
        }

        .nav-user:hover {
            color: var(--rosa-suave);
        }

        .main-card {
            background: white;
            border-radius: 28px;
            border: 1px solid var(--borda);
            box-shadow: 0 8px 40px rgba(74, 0, 18, 0.07);
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .btn-voltar {
            background-color: var(--vinho);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 13px;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-voltar:hover {
            background-color: var(--vinho-claro);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(74, 0, 18, 0.25);
        }

        .btn-editar {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 13px;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-editar:hover {
            background-color: #5a6268;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(108, 117, 125, 0.25);
        }

        .info-card {
            background-color: var(--creme);
            border-radius: 20px;
            padding: 28px;
            border: 1px solid var(--borda);
            transition: all 0.3s ease;
        }
        .info-card:hover {
            background-color: white;
            box-shadow: 0 12px 30px rgba(74, 0, 18, 0.12);
            border-color: var(--rosa-suave);
        }

        .info-label {
            font-size: 10px;
            text-transform: uppercase;
            color: #c06070;
            font-weight: 700;
            letter-spacing: 1.5px;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .info-value {
            font-size: 1rem;
            color: var(--texto);
            font-weight: 500;
            word-break: break-word;
        }

        .badge-alergico {
            background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
            color: #b45309;
            border: 1px solid #fde68a;
            padding: 8px 14px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
        }
        .badge-alergico:hover {
            background: linear-gradient(135deg, #fef3c7 0%, #fffbeb 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(180, 83, 9, 0.15);
        }

        .badge-estoque {
            background: linear-gradient(135deg, var(--creme) 0%, rgba(255, 179, 193, 0.1) 100%);
            color: var(--vinho);
            border: 1.5px solid var(--rosa-suave);
            padding: 10px 20px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }
        .badge-estoque:hover {
            background: linear-gradient(135deg, rgba(255, 179, 193, 0.15) 0%, var(--creme) 100%);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(74, 0, 18, 0.15);
            border-color: var(--vinho);
        }

        .page-header {
            text-align: center;
            padding: 40px 20px 20px;
        }

        .page-header .eyebrow {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #c06070;
            margin-bottom: 10px;
        }

        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }
            .navbar-sweet {
                padding: 0 1.5rem;
            }
            .main-card {
                padding: 1.5rem !important;
            }
        }
    </style>
</head>
<body>

<nav class="navbar-sweet">
    <div class="nav-container">
        <div class="logo">
            <span>EVERSWEET</span>
        </div>
        <div class="nav-links">
            <a href="/Inicio">Início</a>
            <a href="/Login">Login</a>
            <a href="/Dashboard">Dashboard</a>
            <a href="/doces">Doces</a>
            <a href="/Sobre">Sobre</a>

        </div>
        <a href="/carrinho" aria-label="Carrinho">
            <i class="fas fa-shopping-cart nav-user"></i>
        </a>
        <a href="/Perfil">
            <i class="fas fa-user-circle nav-user"></i>
        </a>
    </div>
</nav>

<div class="page-header">
    <p class="eyebrow">Detalhes do Produto</p>
</div>

<div class="container py-4">
    @if(isset($doce) && $doce)
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="main-card p-4 p-md-5">
                <div class="text-center mb-4">
                    <div class="card-thumb" style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--vinho), var(--vinho-claro)); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; overflow:hidden;">
                        @if(!empty($doce->imagem))
                            <img src="/storage/{{ $doce->imagem }}" alt="{{ $doce->Nome }}" style="width:100%;height:100%;object-fit:cover;" />
                        @else
                            <i class="fas fa-cookie-bite" style="font-size: 36px; color: var(--rosa-suave);"></i>
                        @endif
                    </div>

                    <h2 class="display-6 fw-bold" style="font-family: 'Playfair Display', serif; color: var(--vinho);">{{ $doce->Nome ?? 'Sem nome' }}</h2>
                    <span class="badge-estoque mt-3 d-inline-block">
                        <i class="fas fa-box me-2"></i>{{ $doce->Quantidade ?? 0 }} unidades em estoque
                    </span>
                </div>

                <div class="info-card mt-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="info-label">
                                <i class="fas fa-tag me-1"></i> Sabor
                            </div>
                            <div class="info-value">{{ $doce->Sabor ?? 'Não informado' }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-label">
                                <i class="fas fa-dollar-sign me-1"></i> Preço
                            </div>
                            <div class="info-value fw-bold" style="font-size: 1.3rem; color: var(--vinho);">R$ {{ number_format($doce->Preco ?? 0, 2, ',', '.') }}</div>
                        </div>
                        <div class="col-12">
                            <div class="info-label">
                                <i class="fas fa-exclamation-triangle me-1"></i> Alérgicos
                            </div>
                            <div class="info-value">
                                @if($doce->Alergicos)
                                    <span class="badge-alergico"><i class="fas fa-info-circle me-1"></i> {{ $doce->Alergicos }}</span>
                                @else
                                    <span class="text-muted">Nenhum alérgeno declarado</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="info-label">
                                <i class="fas fa-list me-1"></i> Ingredientes
                            </div>
                            <div class="info-value">{{ $doce->Ingredientes ?? 'Não informado' }}</div>
                        </div>
                        <div class="col-12">
                            <div class="info-label">
                                <i class="fas fa-align-left me-1"></i> Descrição
                            </div>
                            <div class="info-value">{{ $doce->Descricao ?? 'Sem descrição' }}</div>
                        </div>
                        <div class="col-12">
                            <div class="info-label">
                                <i class="fas fa-barcode me-1"></i> Código do Produto
                            </div>
                            <div class="info-value small text-muted">#{{ $doce->id ?? '-' }}</div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 p-3 p-md-4" style="background: rgba(255, 179, 193, 0.10); border: 1px solid rgba(255, 179, 193, 0.45); border-radius: 18px;">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-6">
                            <div class="info-label"><i class="fas fa-shopping-cart me-1"></i> Comprar</div>
                            <div class="info-value">Quantidade disponível: <strong>{{ $doce->Quantidade ?? 0 }}</strong></div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label" style="margin:0; font-size:11px;">Quantidade</label>
                            <input id="comprarQuantidade" type="number" min="1" class="form-control" value="1" style="border-radius:14px;" />
                        </div>
                        <div class="col-md-3 d-grid">
                            <button id="btnComprar" class="btn-voltar" style="justify-content:center; width:100%;">
                                <i class="fas fa-bag-shopping"></i> Comprar
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mt-2 p-3" style="background: rgba(255,179,193,0.08); border: 1px dashed rgba(255,179,193,0.8); border-radius: 16px;">
                    <div class="info-label" style="margin-bottom:8px;">Pagamento</div>
                    <div class="info-value">Somente PIX</div>
                </div>

                <div class="d-flex justify-content-center gap-3 mt-5">
                    <a href="/doces" class="btn-voltar">
                        <i class="fas fa-arrow-left"></i> Voltar para Catálogo
                    </a>
                    @if(isset($podeEditar) && $podeEditar)
                    <a href="/editar/{{ $doce->id }}" class="btn-editar">
                        <i class="fas fa-pen"></i> Editar Doce
                    </a>
                    @endif
                </div>

                <script>
                    $(document).ready(function () {
                        const token = $.cookie('token');
                        const doceId = {{ (int) ($doce->id ?? 0) }};

                        function mostrarModalPix(tracking) {
                            const codigo = tracking && tracking.codigo ? tracking.codigo : '-';

                            Swal.fire({
                                title: 'Pagamento PIX',
                                html: `
                                    <div style="text-align:left;">
                                        <p><b>Código PIX:</b> ${codigo}</p>
                                        <p class="text-muted" style="font-size:13px;">Escaneie o QR Code abaixo.</p>
<div style="display:flex; justify-content:center; margin: 14px 0;">
                                            <img alt="QR" src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=https://www.youtube.com/watch?v=4XKGfziuw5c&list=RD4XKGfziuw5c&start_radio=1" />
                                        </div>
                                        <p class="text-muted" style="font-size:13px;"></p>
                                    </div>
                                `,
                                icon: 'info',
                                showCancelButton: false,
                                confirmButtonText: 'Prosseguir',
                                confirmButtonColor: '#4a0012'
                            }).then(() => {
                                window.location.href = '/carrinho';
                            });
                        }

                        $('#btnComprar').on('click', function () {
                            if (!token) {
                                Swal.fire({ title: 'Faça login', text: 'Para comprar, é necessário estar logado.', icon: 'warning', confirmButtonColor: '#4a0012' });
                                return;
                            }

                            const qtd = parseInt($('#comprarQuantidade').val(), 10);
                            if (!qtd || qtd < 1) {
                                Swal.fire({ title: 'Quantidade inválida', text: 'Informe uma quantidade maior ou igual a 1.', icon: 'error', confirmButtonColor: '#4a0012' });
                                return;
                            }

                            const $btn = $('#btnComprar');
                            $btn.prop('disabled', true).css('opacity', 0.7);

                            Swal.fire({
                                title: 'Processando...',
                                text: 'Registrando sua compra.',
                                allowOutsideClick: false,
                                didOpen: () => { Swal.showLoading(); }
                            });

                            $.ajax({
                                url: `/api/comprar/${doceId}?token=${token}`,
                                method: 'POST',
                                data: {
                                    quantidade: qtd
                                },
                                success: function (res) {
                                    Swal.close();

                                    Swal.fire({
                                        title: 'Compra registrada!',
                                        text: res.mensagem || 'Sucesso!',
                                        icon: 'success',
                                        confirmButtonColor: '#4a0012'
                                    }).then(() => {
                                        mostrarModalPix(res.tracking || {});
                                    });
                                },
                                error: function (err) {
                                    Swal.close();
                                    const r = err.responseJSON || {};
                                    const msg = r.mensagem || 'Erro ao realizar compra.';
                                    Swal.fire({ title: 'Erro!', text: msg, icon: 'error', confirmButtonColor: '#4a0012' });
                                },
                                complete: function () {
                                    $btn.prop('disabled', false).css('opacity', 1);
                                }
                            });
                        });
                    });
                </script>
            </div>
        </div>
    </div>
    @else
    <div class="row justify-content-center">
        <div class="col-lg-6 text-center">
            <div class="main-card p-5">
                <div style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--vinho), var(--vinho-claro)); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                    <i class="fas fa-exclamation-triangle fa-2x" style="color: var(--rosa-suave);"></i>
                </div>
                <h3 style="font-family: 'Playfair Display', serif; color: var(--vinho);">Doce não encontrado!</h3>
                <p class="text-muted mt-2">O doce que você está procurando não existe ou foi removido.</p>
                <a href="/doces" class="btn-voltar mt-4">
                    <i class="fas fa-arrow-left me-2"></i> Voltar para Lista
                </a>
            </div>
        </div>
    </div>
    @endif
</div>

</body>
</html>