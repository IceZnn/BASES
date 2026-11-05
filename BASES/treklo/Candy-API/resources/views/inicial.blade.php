<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="icon" href="logo.png" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EVERSWEET</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
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
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        /* ── NAVBAR ── */
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
        .nav-container { max-width: 1200px; margin: 0 auto; width: 100%; display: flex; justify-content: space-between; align-items: center; }
        .logo span { color: white; font-family: 'Playfair Display', serif; font-size: 22px; font-weight: 700; letter-spacing: 2px; }
        .nav-links { display: flex; gap: 32px; }
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

        /* ── HERO ── */
        .hero {
            position: relative;
            overflow: hidden;
            padding: 100px 20px 90px;
            text-align: center;
        }

        .hero-bg {
            position: absolute; inset: 0;
            background:
                radial-gradient(ellipse 70% 60% at 50% 0%, rgba(255,179,193,0.22) 0%, transparent 70%),
                radial-gradient(ellipse 40% 40% at 10% 90%, rgba(74,0,18,0.07) 0%, transparent 60%);
            pointer-events: none;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(74,0,18,0.07);
            border: 1px solid var(--borda);
            color: var(--vinho);
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 6px 16px;
            border-radius: 50px;
            margin-bottom: 28px;
        }

        .hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(52px, 8vw, 96px);
            font-weight: 700;
            color: var(--vinho);
            line-height: 1;
            letter-spacing: -2px;
            margin-bottom: 24px;
        }

        .hero h1 em {
            font-style: italic;
            color: #a0293e;
        }

        .hero p {
            font-size: 18px;
            color: #7a4050;
            max-width: 520px;
            margin: 0 auto 40px;
            line-height: 1.65;
            font-weight: 300;
        }

        .hero-actions { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }

        .btn-primary-hero {
            background: var(--vinho);
            color: white;
            border: none;
            padding: 15px 38px;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.5px;
            border-radius: 50px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all .25s;
            box-shadow: 0 8px 24px rgba(74, 0, 18, 0.3);
        }
        .btn-primary-hero:hover { background: var(--vinho-claro); transform: translateY(-2px); box-shadow: 0 12px 32px rgba(74, 0, 18, 0.4); color: white; }

        .btn-outline-hero {
            background: transparent;
            color: var(--vinho);
            border: 1.5px solid var(--vinho);
            padding: 15px 38px;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.5px;
            border-radius: 50px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all .25s;
        }
        .btn-outline-hero:hover { background: var(--vinho); color: white; transform: translateY(-2px); }

        
        .divider {
            text-align: center;
            color: var(--borda);
            font-size: 22px;
            letter-spacing: 8px;
            margin: 10px 0 60px;
        }

        
        .features-section { max-width: 1100px; margin: 0 auto; padding: 0 20px 90px; }

        .section-label {
            text-align: center;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #c06070;
            margin-bottom: 12px;
        }

        .section-title {
            text-align: center;
            font-family: 'Playfair Display', serif;
            font-size: clamp(28px, 4vw, 42px);
            color: var(--vinho);
            margin-bottom: 56px;
            letter-spacing: -0.5px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .feature-card {
            background: white;
            border-radius: 24px;
            padding: 36px 28px;
            border: 1px solid var(--borda);
            box-shadow: 0 4px 20px rgba(74,0,18,0.05);
            transition: transform .25s, box-shadow .25s;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--vinho), var(--rosa-suave));
            opacity: 0;
            transition: opacity .25s;
        }

        .feature-card:hover { transform: translateY(-6px); box-shadow: 0 16px 40px rgba(74,0,18,0.1); }
        .feature-card:hover::before { opacity: 1; }

        .feature-icon {
            width: 52px; height: 52px;
            background: linear-gradient(135deg, #fff0f3, #ffe4e8);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px;
            color: var(--vinho);
            margin-bottom: 20px;
        }

        .feature-card h3 {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            color: var(--texto);
            margin-bottom: 10px;
        }

        .feature-card p { color: #8a5060; font-size: 14px; line-height: 1.7; font-weight: 300; }

        
        .footer { background: #2a0008; color: #7a4050; padding: 56px 0 28px; margin-top: auto; }
        .footer-inner { max-width: 1200px; margin: 0 auto; padding: 0 24px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 48px; }
        .footer h4 { font-family: 'Playfair Display', serif; color: white; font-size: 17px; margin-bottom: 18px; }
        .footer p { color: #a8a8a8;font-size: 13px; line-height: 1.7; margin-bottom: 8px; }
        .footer a { color: #a8a8a8; text-decoration: none; transition: color .2s; }
        .footer a:hover { color: var(--rosa-suave); }
        .social-links { display: flex; gap: 12px; margin-top: 4px; }
        .social-links a {
            width: 38px; height: 38px;
            border-radius: 50%;
            background: rgba(255,255,255,0.07);
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 14px;
            transition: all .2s;
            border: 1px solid rgba(255,255,255,0.1);
        }
        .social-links a:hover { background: var(--vinho); border-color: var(--vinho); transform: translateY(-2px); }
        .footer-bottom { text-align: center; padding-top: 28px; margin-top: 28px; border-top: 1px solid #4a1520; color: #4a2030; font-size: 12px; letter-spacing: 0.5px; }

        @media (max-width: 768px) {
            .features-grid { grid-template-columns: 1fr; }
            .footer-inner { grid-template-columns: 1fr; gap: 32px; }
            .nav-links { display: none; }
        }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="nav-container">
        <div class="logo"><span>EVERSWEET</span></div>
        <div class="nav-links">
            <a href="#">Início</a>
            <a href="/Login">Login</a>
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

<main>
    <section class="hero">
        <div class="hero-bg"></div>
        <div class="hero-badge"> Artesanal E Feito com Amor</div>
        <h1>Ever<em>sweet</em></h1>
        <p>Os melhores doces artesanais você encontra aqui. Feitos com dedicação e ingredientes selecionados.</p>
        <div class="hero-actions">
            <a href="/doces" class="btn-primary-hero"> Ver Catálogo</a>
            <a href="/Sobre" class="btn-outline-hero">Sobre nós</a>
        </div>
    </section>

    <section class="features-section">
        <p class="section-label">Por que nos escolher</p>
        <h2 class="section-title">Feito diferente, com propósito</h2>
        <div class="features-grid">
            <div class="feature-card">
                <h3>Feito com Dedicação</h3>
                <p>Cada doce é preparado à mão, com atenção aos detalhes e ingredientes de qualidade superior.</p>
            </div>
            <div class="feature-card">
                <h3>Entrega Rápida</h3>
                <p>Somos tão rápidos que até o Flash pede açúcar emprestado. Sua encomenda chega quentinha.</p>
            </div>
            <div class="feature-card">
                <h3>Qualidade Garantida</h3>
                <p>Ingredientes selecionados, receitas aperfeiçoadas e um cuidado que você sente no primeiro mordida.</p>
            </div>
        </div>
    </section>
</main>

<footer class="footer">
    <div class="footer-inner">
        <div>
            <h4>EVERSWEET</h4>
            <p>Os melhores doces artesanais da região. Feitos com amor e ingredientes selecionados.</p>
            <div class="social-links">
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-whatsapp"></i></a>
            </div>
        </div>
        <div>
            <h4>Links Rápidos</h4>
            <p><a href="/">Início</a></p>
            <p><a href="/Dashboard">Dashboard</a></p>
            <p><a href="/Cadastro">Cadastrar Doce</a></p>
            <p><a href="/doces">Catálogo</a></p>
            <p><a href="/Sobre">Sobre Nós</a></p>
        </div>
        <div>
            <h4>Contato</h4>
            <p><i class="fas fa-phone" style="margin-right:8px;opacity:.5"></i>(15) 99999-9999</p>
            <p><i class="fas fa-envelope" style="margin-right:8px;opacity:.5"></i>contato@eversweet.com</p>
            <p><i class="fas fa-map-marker-alt" style="margin-right:8px;opacity:.5"></i>São Paulo, SP</p>
        </div>
    </div>
    <div class="footer-bottom">© 2026 EVERSWEET — Nenhum direito reservado</div>
</footer>

</body>
</html>