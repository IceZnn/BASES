<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="icon" href="logo.png" type="image/png">
    <meta charset="UTF-8">
    <title>EVERSWEET</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            display: flex;
            flex-direction: column;
        }

        .navbar {
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

        .page-header {
            text-align: center;
            padding: 56px 20px 40px;
        }

        .page-header .eyebrow {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #c06070;
            margin-bottom: 10px;
        }

        .page-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(32px, 5vw, 52px);
            font-weight: 700;
            color: var(--vinho);
            letter-spacing: -1px;
        }

        .page-header p {
            font-size: 16px;
            color: #888;
            margin-top: 8px;
        }

        .main-content {
            flex: 1;
            max-width: 1200px;
            margin: 0 auto 60px;
            padding: 0 20px;
            width: 100%;
        }

        .search-bar {
            display: flex;
            align-items: center;
            gap: 12px;
            background: white;
            border-radius: 50px;
            padding: 8px 20px;
            box-shadow: 0 4px 15px rgba(74,0,18,0.05);
            margin-bottom: 40px;
            border: 1.5px solid var(--borda);
            transition: all .2s;
        }

        .search-bar:focus-within {
            border-color: var(--vinho);
            box-shadow: 0 0 0 3px rgba(74, 0, 18, 0.08);
        }

        .search-bar i {
            color: var(--vinho);
            opacity: 0.5;
        }

        .search-bar input {
            border: none;
            outline: none;
            width: 100%;
            font-size: 14px;
            background: transparent;
            color: var(--texto);
            font-family: 'DM Sans', sans-serif;
            padding: 12px 0;
        }

        .search-bar input::placeholder {
            color: #c9a0a8;
        }

        .state-msg {
            text-align: center;
            padding: 60px 20px;
            color: #c9a0a8;
            font-size: 16px;
        }

        .state-msg i {
            font-size: 48px;
            display: block;
            margin-bottom: 16px;
            color: var(--rosa-suave);
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 28px;
        }

        .card {
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(74,0,18,0.05);
            border: 1px solid var(--borda);
            transition: transform .25s, box-shadow .25s;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .card:not(.esgotado):hover {
            transform: translateY(-5px);
            box-shadow: 0 16px 36px rgba(74,0,18,0.12);
        }

        /* ── Esgotado ── */
        .card.esgotado {
            opacity: 0.72;
            filter: grayscale(35%);
        }

        .card.esgotado .card-thumb {
            background: linear-gradient(135deg, #6b6b6b 0%, #9a9a9a 100%);
        }

        .badge-esgotado {
            position: absolute;
            top: 14px;
            right: 14px;
            background: #dc2626;
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 5px 12px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 5px;
            z-index: 2;
            box-shadow: 0 2px 8px rgba(220,38,38,0.35);
        }

        .card-thumb {
            background: linear-gradient(135deg, var(--vinho) 0%, var(--vinho-claro) 100%);
            height: 220px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 56px;
            position: relative;
            overflow: hidden;
        }


.card-thumb::after {
            content: '🥀';
            font-size: 64px;
            opacity: 0.2;
            transition: opacity .2s;
            pointer-events: none;
        }

        .card-thumb.has-imagem::after {
            display: none;
        }



        .card-body {
            padding: 24px;
            flex: 1;
        }

        .card-body h3 {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            font-weight: 700;
            color: var(--vinho);
            margin-bottom: 6px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .card-body .sabor {
            font-size: 12px;
            font-weight: 500;
            color: #c06070;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
        }

        .card-body .descricao {
            font-size: 13px;
            color: #888;
            line-height: 1.6;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin-bottom: 16px;
        }

        .card-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 14px;
        }

        .preco {
            font-size: 24px;
            font-weight: 700;
            color: var(--vinho);
            font-family: 'Playfair Display', serif;
        }

        .qtd {
            font-size: 12px;
            background: var(--creme);
            color: var(--vinho);
            padding: 5px 14px;
            border-radius: 50px;
            font-weight: 600;
            border: 1px solid var(--borda);
        }

        .alergicos {
            font-size: 11px;
            color: #b45309;
            background: #fffbeb;
            border-radius: 8px;
            padding: 8px 12px;
            margin-bottom: 0;
            display: flex;
            align-items: center;
            gap: 8px;
            border: 1px solid #fde68a;
        }

        .card-actions {
            display: flex;
            gap: 10px;
            padding: 0 24px 24px;
            align-items: center;
        }

        .btn-ver {
            flex: 1;
            padding: 12px 18px;
            border-radius: 12px;
            border: none;
            background: var(--vinho);
            color: white;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            transition: all .2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
        }

        .btn-ver:hover {
            background: var(--vinho-claro);
            transform: translateY(-1px);
        }

        
        .btn-ver.bloqueado {
            background: #e5e7eb;
            color: #9ca3af;
            cursor: not-allowed;
            pointer-events: none;
        }

        .btn-ver.bloqueado:hover {
            transform: none;
        }

        .btn-editar, .btn-deletar {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            transition: all .2s;
            flex-shrink: 0;
        }

        .btn-editar {
            background: var(--creme);
            color: var(--vinho);
            border: 1px solid var(--borda);
        }

        .btn-editar:hover {
            background: var(--vinho);
            color: white;
            transform: translateY(-1px);
        }

        .btn-deletar {
            background: var(--creme);
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .btn-deletar:hover {
            background: #dc2626;
            color: white;
            transform: translateY(-1px);
        }

        .badge-dono {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 10px;
            background: #d1fae5;
            color: #065f46;
            border-radius: 50px;
            padding: 3px 10px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        footer {
            background: var(--vinho);
            padding: 40px 0 20px;
            margin-top: 50px;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 40px;
        }

        .footer-section h4 {
            color: white;
            margin-bottom: 20px;
            font-size: 16px;
            font-family: 'Playfair Display', serif;
            letter-spacing: 1px;
        }

        .footer-section p {
            color: #a8a8a8;
            line-height: 1.6;
            margin-bottom: 10px;
            font-size: 13px;
        }

        .footer-section a {
            color: #a8a8a8;
            text-decoration: none;
            transition: color .2s;
        }

        .footer-section a:hover {
            color: var(--rosa-suave);
        }

        .social-links {
            display: flex;
            gap: 12px;
            margin-top: 15px;
        }

        .social-links a {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: all .3s;
        }

        .social-links a:hover {
            background: var(--rosa-suave);
            transform: translateY(-3px);
            color: var(--vinho);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            margin-top: 30px;
            border-top: 1px solid rgba(255,255,255,0.1);
            color: rgba(255,255,255,0.4);
            font-size: 12px;
        }

        @media (max-width: 768px) {
            .footer-content {
                grid-template-columns: 1fr;
                gap: 30px;
            }
            .nav-links {
                display: none;
            }
            .grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="nav-container">
        <div class="logo">
            <span>EVERSWEET</span>
        </div>
        <div class="nav-links">
            <a href="/Inicio">Início</a>
            <a href="/Dashboard">Dashboard</a>
            <a href="/Cadastro">Cadastrar Doce</a>
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
    <p class="eyebrow">Catálogo</p>
    <h1>Nossos Doces</h1>
    <p>Confira todos os doces disponíveis</p>
</div>

<main class="main-content">
    <div class="search-bar">
        <i class="fas fa-search"></i>
        <input type="text" id="busca" placeholder="Buscar por nome ou sabor...">
    </div>
    <div id="conteudo">
        <div class="state-msg">
            <i class="fas fa-spinner fa-pulse"></i>
            Carregando doces...
        </div>
    </div>
</main>

<footer>
    <div class="footer-content">
        <div class="footer-section">
            <h4>EVERSWEET</h4>
            <p>Doces artesanais com sabor e carinho.</p>
            <div class="social-links">
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-whatsapp"></i></a>
            </div>
        </div>
        <div class="footer-section">
            <h4>Links Rápidos</h4>
            <p><a href="/Dashboard">Dashboard</a></p>
            <p><a href="/Cadastro">Cadastrar Doce</a></p>
            <p><a href="/doces">Catálogo</a></p>
            <p><a href="/Sobre">Sobre Nós</a></p>
        </div>
        <div class="footer-section">
            <h4>Contato</h4>
            <p><i class="fas fa-phone" style="margin-right:8px"></i> (15) 99999-9999</p>
            <p><i class="fas fa-envelope" style="margin-right:8px"></i> email@eversweet.com</p>
            <p><i class="fas fa-map-marker-alt" style="margin-right:8px"></i> São Paulo, SP</p>
        </div>
    </div>
    <div class="footer-bottom">
        <p>© 2026 EVERSWEET - Todos os direitos reservados</p>
    </div>
</footer>

<script>
$(document).ready(function () {
    const token    = $.cookie("token");
    const userId   = parseInt($.cookie("user_id"));
    let todosDoces = [];

    function eEsgotado(d) {
        
        return d.Quantidade !== undefined && d.Quantidade !== null && parseInt(d.Quantidade) === 0;
    }

    function renderizar(doces) {
        if (doces.length === 0) {
            $('#conteudo').html(`
                <div class="state-msg">
                    <i class="fas fa-cookie-bite"></i>
                    Nenhum doce encontrado.
                </div>
            `);
            return;
        }
        let html = '<div class="grid">';
        doces.forEach(function (d) {
            const eDono    = !isNaN(userId) && parseInt(d.user_id) === userId;
            const esgotado = eEsgotado(d);

            const badgeEsgotado = esgotado
                ? `<div class="badge-esgotado"><i class="fas fa-ban"></i> Esgotado</div>`
                : '';

            const qtdBadge = !esgotado && d.Quantidade !== undefined && d.Quantidade !== null
                ? `<span class="qtd"><i class="fas fa-box"></i> ${d.Quantidade} un.</span>`
                : '';

            const badgeDono = eDono
                ? `<div class="badge-dono"><i class="fas fa-crown"></i> Meu doce</div>`
                : '';

            const btnEditar = (eDono && token)
                ? `<a class="btn-editar" href="/editar/${d.id}?token=${token}" title="Editar"><i class="fas fa-pen"></i></a>`
                : '';

            const btnDeletar = (eDono && token)
                ? `<a class="btn-deletar" href="/deletar/${d.id}?token=${token}" title="Deletar"><i class="fas fa-trash"></i></a>`
                : '';

            let btnVer;
            if (esgotado) {
                
                if (eDono && token) {
                    btnVer = `<a class="btn-ver" href="/doce/${d.id}?token=${token}"><i class="fas fa-eye"></i> Ver detalhes</a>`;
                } else {
                    btnVer = `<span class="btn-ver bloqueado"><i class="fas fa-ban"></i> Esgotado</span>`;
                }
            } else if (token) {
                btnVer = `<a class="btn-ver" href="/doce/${d.id}?token=${token}"><i class="fas fa-eye"></i> Ver detalhes</a>`;
            } else {
                btnVer = `<span class="btn-ver" style="opacity:.5;cursor:default;background:#ccc"><i class="fas fa-lock"></i> Faça login</span>`;
            }

            html += `
                <div class="card${esgotado ? ' esgotado' : ''}" data-nome="${d.Nome.toLowerCase()}" data-sabor="${d.Sabor.toLowerCase()}">
                    ${badgeEsgotado}
                    <div class="card-thumb${d.imagem ? ' has-imagem' : ''}">
                        ${d.imagem ? `<img src="/storage/${d.imagem}" alt="${d.Nome}" style="width:100%;height:100%;object-fit:cover;" />` : ''}
                    </div>


                    <div class="card-body">
                        ${badgeDono}
                        <h3>${d.Nome}</h3>
                        <div class="sabor">${d.Sabor}</div>
                        <div class="descricao">${d.Descricao || 'Sem descrição'}</div>
                        <div class="card-meta">
                            <span class="preco">R$ ${parseFloat(d.Preco).toFixed(2)}</span>
                            ${qtdBadge}
                        </div>
                        <div class="alergicos">
                            <i class="fas fa-exclamation-triangle"></i>
                            Alérgicos: ${d.Alergicos || 'Nenhum'}
                        </div>
                    </div>
                    <div class="card-actions">
                        ${btnVer}
                        ${btnEditar}
                        ${btnDeletar}
                    </div>
                </div>
            `;
        });
        html += '</div>';
        $('#conteudo').html(html);
    }

    function mostrarErro(msg) {
        $('#conteudo').html(`
            <div class="state-msg">
                <i class="fas fa-exclamation-circle" style="color:#dc2626"></i>
                ${msg}
            </div>
        `);
    }

    $.ajax({
        url: '/api/todos_doces',
        method: 'GET',
        success: function (res) {
            if (res.erro === 'n') {
                todosDoces = res.doces;
                renderizar(todosDoces);
            } else {
                mostrarErro('Não foi possível carregar os doces.');
            }
        },
        error: function () {
            mostrarErro('Erro ao conectar com o servidor.');
        }
    });

    $('#busca').on('input', function () {
        const termo = $(this).val().toLowerCase().trim();
        if (!termo) { renderizar(todosDoces); return; }
        const filtrado = todosDoces.filter(function (d) {
            return d.Nome.toLowerCase().includes(termo) || d.Sabor.toLowerCase().includes(termo);
        });
        renderizar(filtrado);
    });
});
</script>

</body>
</html>