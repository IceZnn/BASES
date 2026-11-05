<!DOCTYPE html
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
        .nav-container { max-width: 1200px; margin: 0 auto; width: 100%; display: flex; justify-content: space-between; align-items: center; }
        .logo span { color: white; font-family: 'Playfair Display', serif; font-size: 22px; font-weight: 700; letter-spacing: 2px; }
        .nav-links { display: flex; gap: 24px; align-items: center; }
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
        .nav-links a:hover { color: var(--rosa-suave); border-color: var(--rosa-suave); }
        .nav-user { color: rgba(255,255,255,0.6); font-size: 22px; cursor: pointer; transition: color .2s; }
        .nav-user:hover { color: var(--rosa-suave); }

        .page-header { text-align: center; padding: 40px 20px 20px; }
        .page-header .eyebrow {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #c06070;
            margin-bottom: 10px;
        }

        .main-card {
            background: white;
            border-radius: 28px;
            border: 1px solid var(--borda);
            box-shadow: 0 8px 40px rgba(74, 0, 18, 0.07);
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            animation: slideUp 0.6s ease-out;
        }

        .badge-status {
            background: rgba(255,179,193,0.18);
            border: 1px solid rgba(255,179,193,0.5);
            color: var(--vinho);
            border-radius: 999px;
            padding: 6px 12px;
            font-weight: 800;
            font-size: 12px;
        }

        .tracking-box {
            background: #fff;
            border: 1px solid var(--borda);
            border-radius: 16px;
            padding: 16px;
        }

        @media (max-width: 768px) {
            .nav-links { display: none; }
            .navbar-sweet { padding: 0 1.5rem; }
        }
    </style>
</head>
<body>

<nav class="navbar-sweet">
    <div class="nav-container">
        <div class="logo"><span>EVERSWEET</span></div>
        <div class="nav-links">
            <a href="/Inicio">Início</a>
            <a href="/doces">Doces</a>
            <a href="/carrinho"><i class="fas fa-shopping-bag me-1"></i> Compras</a>
            <a href="/Sobre">Sobre</a>
        </div>
        <a href="/Perfil"><i class="fas fa-user-circle nav-user"></i></a>
    </div>
</nav>

<div class="page-header">
    <p class="eyebrow">Suas compras</p>
</div>

<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="main-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-3 gap-2 flex-wrap">
                    <h3 style="font-family: 'Playfair Display', serif; color: var(--vinho); margin:0;">Carrinho</h3>
                    <div class="d-flex gap-2">
                        <button id="btnAutoAvanco" class="btn" style="background: #fff; color: var(--vinho); border:1.5px solid var(--borda); border-radius: 999px; font-weight:800;">
                            Auto (timer)
                        </button>
                    </div>
                </div>


                <div id="msg" class="text-muted">Carregando...</div>
                <div id="lista" class="tracking-box" style="display:none;"></div>

                <div class="tracking-box mt-4">
                    <div class="d-flex justify-content-between align-items-center">
            </div>
                    </div>
                    <div id="listaConcluidos" class="mt-3" style="display:none;"></div>
                    <div id="msgConcluidos" class="text-muted mt-3">Carregando...</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function statusLabel(s) {
        if (!s) return '—';
        return s;
    }

    async function loadCarrinho() {
        const token = $.cookie('token');
        if (!token) {
            $('#msg').html('Faça login para ver suas compras.');
            $('#lista').hide();
            return;
        }

        
        $('#msg').html('Atualizando...');

        $.ajax({
            url: `/api/carrinho`,
            method: 'GET',
            data: { token },
            success: function(res) {
                if (res.erro !== 'n') {
                    $('#msg').html('Erro ao carregar carrinho.');
                    $('#msgConcluidos').html('Erro ao carregar doces concluídos.');
                    return;
                }

                const compras = res.compras || [];
                if (compras.length === 0) {
                    $('#msg').html('Seu carrinho está vazio.');
                    $('#lista').html('').hide();
                    $('#listaConcluidos').html('').hide();
                    return;
                }

                const conclu = compras.filter(c => (c.status || '').toUpperCase() === 'FINALIZADA');
                if (!conclu || conclu.length === 0) {
                    $('#msgConcluidos').html('Nenhum doce concluído ainda.');
                    $('#listaConcluidos').hide();
                } else {
                    let htmlConcl = '';
                    conclu.forEach(c => {
                        htmlConcl += `
                            <div style="padding:14px; border:1px solid #ead1d1; border-radius:16px; margin-bottom:12px;">
                                <div style="font-weight:900; color: var(--vinho);">${c.doce_nome || `Doce #${c.doce_id}`}</div>
                                <div class="text-muted">Quantidade: ${c.quantidade}</div>
                                <div class="text-muted" style="font-size:13px;">Código tracking: <b>${(c.tracking && c.tracking.codigo) ? c.tracking.codigo : '-'}</b></div>
                            </div>
                        `;
                    });
                    $('#listaConcluidos').html(htmlConcl).show();
                    $('#msgConcluidos').hide();
                }


                
                let html = '';
                const pendentes = compras.filter(c => (c.status || '').toUpperCase() !== 'FINALIZADA');
                pendentes.forEach(c => {

                    const dados = c.tracking || {};
                    html += `
                        <div class="mb-3" style="padding:14px; border:1px solid #ead1d1; border-radius:16px;">
                            <div class="d-flex justify-content-between align-items-start gap-3">
                                <div>
                                    <div style="font-weight:900; color: var(--vinho);">${c.doce_nome || `Doce #${c.doce_id}`}</div>
                                    <div class="text-muted">Quantidade: ${c.quantidade}</div>

                                </div>
                                <div class="badge-status">${statusLabel(c.status)}</div>
                            </div>

                            <div class="mt-2">
                                <div class="text-muted" style="font-size: 13px;">Código tracking : <b>${dados.codigo || '-'}</b></div>
                            </div>

                            <div class="mt-3">
                                <div style="display:flex; gap:10px; flex-wrap:wrap;">
                                    <button class="btn" onclick="simularAvanco(${c.id})" style="background:#6b1a2c; color:white; border-radius:999px; font-weight:800;">Avançar etapa</button>
                                    <button class="btn" onclick="verRastreio('${dados.codigo || ''}')" style="border-radius:999px; font-weight:800; border:1px solid #ead1d1;">Ver rastreio</button>
                                </div>
                            </div>
                        </div>
                    `;
                });

                $('#lista').html(html).show();
                $('#msg').hide();
            },
            error: function(xhr) {
                const r = xhr && xhr.responseJSON ? xhr.responseJSON : {};
                const msg = r.msg || r.mensagem || 'Erro ao carregar carrinho (ver console/network).';
                $('#msg').html(msg);
                console.error('Carrinho error:', xhr && xhr.responseText ? xhr.responseText : xhr);
            }
        });
    }

    function verRastreio(codigo) {
        
        Swal.fire({
            title: 'Rastreamento',
            html: `
                <div style="text-align:left;">
                    <p><b>Código:</b> ${codigo || '-'}</p>
<p><b>Link:</b> <a href="https://www.youtube.com/watch?v=4XKGfziuw5c&list=RD4XKGfziuw5c&start_radio=1" target="_blank">Abrir tracking</a></p>
                    <p class="text-muted" style="font-size:13px;"> </p>
                </div>
            `,
            icon: 'info'
        });
    }

    function simularAvanco(id) {
        const token = $.cookie('token');
        $.ajax({
            url: `/api/compras/${id}/avancar`,
            method: 'POST',
            data: { token },
            success: function(res) {
                loadCarrinho();
                if (res && res.erro === 'n') {
                    Swal.fire({ title: 'Atualizado!', text: 'Status da compra atualizado.', icon:'success', confirmButtonColor:'#4a0012'});
                }
            },
            error: function(xhr) {
                const r = xhr && xhr.responseJSON ? xhr.responseJSON : {};
                Swal.fire({ title: 'Erro!', text: r.mensagem || r.msg || 'Não foi possível atualizar etapa.', icon:'error', confirmButtonColor:'#4a0012'});
            }
        });
    }


    function getNextCompraIdToAutoAvancar(compras) {
        if (!compras || compras.length === 0) return null;
        
        const naoFinal = compras.filter(c => (c.status || '').toUpperCase() !== 'FINALIZADA');
        const lista = naoFinal.length > 0 ? naoFinal : compras;
        return lista[0]?.id ?? null;
    }

    let autoTimerHandle = null;

    $(document).ready(function() {
        loadCarrinho();

        // Não chama loadCarrinho quando abrir alerta para evitar sensação de "F5".
        $('#btnAtualizarStatus').on('click', function() {
            Swal.fire({ title: 'Demo', text: 'Use os botões "Avançar etapa" em cada compra para simular.', icon: 'info' });
        });

        $('#btnAutoAvanco').on('click', function() {
            const token = $.cookie('token');
            if (!token) {
                Swal.fire({ title: 'Atenção', text: 'Faça login para simular avanços.', icon: 'warning', confirmButtonColor: '#4a0012' });
                return;
            }

            if (autoTimerHandle) {
                clearInterval(autoTimerHandle);
                autoTimerHandle = null;
                Swal.fire({ title: 'Auto desativado', text: 'Timer de avanço foi desligado.', icon: 'info', confirmButtonColor: '#4a0012' });
                return;
            }

            
            const intervaloMs = 6900;

            Swal.fire({ title: 'Auto ativado', text: `Avançando automaticamente a cada ${Math.round(intervaloMs/1000)}s .`, icon: 'success', confirmButtonColor: '#4a0012' });

            autoTimerHandle = setInterval(function() {
                
                $.ajax({
                    url: `/api/carrinho`,
                    method: 'GET',
                    data: { token },
                    success: function(res) {
                        if (res.erro !== 'n') return;
                        const compras = res.compras || [];
                        const idToAvancar = getNextCompraIdToAutoAvancar(compras);
                        if (!idToAvancar) {
                            clearInterval(autoTimerHandle);
                            autoTimerHandle = null;
                            Swal.fire({ title: 'Tudo finalizado', text: 'Não há mais compras para avançar.', icon: 'info', confirmButtonColor: '#4a0012' });
                            loadCarrinho();
                            return;
                        }

                        $.ajax({
                            url: `/api/compras/${idToAvancar}/avancar`,
                            method: 'POST',
                            data: { token },
                            success: function() {
                                loadCarrinho();
                            },
                            error: function(xhr) {
                                const r = xhr && xhr.responseJSON ? xhr.responseJSON : {};
                                console.error('AutoAvanco error:', r, xhr && xhr.responseText ? xhr.responseText : '');
                            }
                        });
                    },
                    error: function(xhr) {
                        const r = xhr && xhr.responseJSON ? xhr.responseJSON : {};
                        console.error('Auto load carrinho error:', r, xhr && xhr.responseText ? xhr.responseText : '');
                    }
                });
            }, intervaloMs);
        });
    });
</script>

</body>
</html>

