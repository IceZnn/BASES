<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="icon" href="logo.png" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        .hero {
            background: linear-gradient(135deg, var(--vinho) 0%, var(--vinho-claro) 100%);
            padding: 70px 20px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '🍫';
            position: absolute;
            right: 60px;
            bottom: -30px;
            font-size: 180px;
            opacity: 0.06;
        }

        .hero::after {
            content: '🍰';
            position: absolute;
            left: 40px;
            top: -20px;
            font-size: 140px;
            opacity: 0.05;
        }

        .hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: 48px;
            font-weight: 700;
            letter-spacing: -2px;
            margin-bottom: 12px;
        }

        .hero p {
            font-size: 16px;
            opacity: 0.85;
            max-width: 520px;
            margin: 0 auto;
            line-height: 1.6;
        }

        .main-content {
            flex: 1;
            max-width: 1100px;
            margin: 60px auto;
            padding: 0 24px;
            width: 100%;
        }

        .section-title {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #c06070;
            margin-bottom: 10px;
        }

        .section-heading {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            font-weight: 700;
            color: var(--vinho);
            letter-spacing: -1px;
            margin-bottom: 20px;
        }

        .projeto-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: center;
            margin-bottom: 80px;
        }

        .projeto-text p {
            font-size: 15px;
            color: #666;
            line-height: 1.8;
            margin-bottom: 16px;
        }

        .projeto-visual {
            background: linear-gradient(135deg, var(--vinho) 0%, var(--vinho-claro) 100%);
            border-radius: 28px;
            padding: 40px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .feature-item {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            background: rgba(255,255,255,0.08);
            border-radius: 20px;
            padding: 18px 22px;
            transition: transform .2s;
        }

        .feature-item:hover {
            transform: translateX(5px);
            background: rgba(255,255,255,0.12);
        }

        .feature-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: rgba(255,179,193,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }

        .feature-text h4 {
            color: white;
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .feature-text p {
            color: rgba(255,255,255,0.65);
            font-size: 13px;
            line-height: 1.5;
        }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 80px;
        }

        .stat-box {
            background: white;
            border: 1px solid var(--borda);
            border-radius: 20px;
            padding: 28px 20px;
            text-align: center;
            box-shadow: 0 4px 16px rgba(74,0,18,0.04);
            transition: transform .2s, box-shadow .2s;
        }

        .stat-box:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 28px rgba(74,0,18,0.1);
        }

        .stat-box .num {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            font-weight: 800;
            color: var(--vinho);
            letter-spacing: -1px;
        }

        .stat-box .lbl {
            font-size: 12px;
            color: #c9a0a8;
            margin-top: 6px;
            font-weight: 500;
        }

        .tech-section {
            margin-bottom: 80px;
            text-align: center;
        }

        .tech-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            justify-content: center;
            margin-top: 30px;
        }

        .tech-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: white;
            border: 1.5px solid var(--borda);
            border-radius: 50px;
            padding: 10px 22px;
            font-size: 13px;
            font-weight: 600;
            color: var(--vinho);
            box-shadow: 0 2px 8px rgba(74,0,18,0.04);
            transition: transform .2s, box-shadow .2s;
        }

        .tech-badge:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(74,0,18,0.1);
            border-color: var(--rosa-suave);
        }

        .tech-badge i {
            font-size: 16px;
        }

        .criadores-section {
            margin-bottom: 80px;
        }

        .criadores-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 28px;
            margin-top: 30px;
        }

        .criador-card {
            background: white;
            border: 1px solid var(--borda);
            border-radius: 24px;
            padding: 36px 28px;
            text-align: center;
            box-shadow: 0 8px 24px rgba(74,0,18,0.05);
            transition: transform .25s, box-shadow .25s;
        }

        .criador-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 40px rgba(74,0,18,0.12);
        }

        .criador-avatar {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--vinho), var(--vinho-claro));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            margin: 0 auto 18px;
            border: 3px solid var(--rosa-suave);
            overflow: hidden;
        }

        .criador-card h3 {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            font-weight: 700;
            color: var(--vinho);
            margin-bottom: 6px;
        }

        .criador-card .cargo {
            display: inline-block;
            background: var(--creme);
            color: var(--vinho);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 4px 14px;
            border-radius: 50px;
            margin-bottom: 16px;
            border: 1px solid var(--borda);
        }

        .criador-card p {
            font-size: 14px;
            color: #888;
            line-height: 1.7;
        }

        .criador-skills {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            justify-content: center;
            margin-top: 18px;
        }

        .skill-tag {
            background: var(--creme);
            border: 1px solid var(--borda);
            color: var(--vinho);
            font-size: 11px;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 8px;
        }

        footer {
            background: var(--vinho);
            padding: 40px 0 20px;
            margin-top: 20px;
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
            .projeto-grid, .criadores-grid {
                grid-template-columns: 1fr;
            }
            .stats-row {
                grid-template-columns: repeat(2, 1fr);
            }
            .footer-content {
                grid-template-columns: 1fr;
                gap: 30px;
            }
            .nav-links {
                display: none;
            }
            .hero h1 {
                font-size: 32px;
            }
            .section-heading {
                font-size: 26px;
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

<div class="hero">
    <h1>Sobre o EVERSWEET</h1>
    <p>Conheça o projeto e as pessoas por trás desta plataforma de gestão de confeitaria.</p>
</div>

<main class="main-content">
    <div class="projeto-grid">
        <div class="projeto-text">
            <div class="section-title">O Projeto</div>
            <h2 class="section-heading">O que é o EVERSWEET?</h2>
            <p>O EVERSWEET é um sistema de gestão desenvolvido para confeitarias e produtores de doces artesanais. A plataforma centraliza o cadastro, controle e visualização de produtos, facilitando a organização.</p>
            <p>Com foco em simplicidade e eficiência, o sistema permite que cada produtor gerencie seu próprio catálogo de doces com total autonomia.</p>
            <p>O projeto nasceu de uma atividade do SENAI DS Tatuí pelos professores Vinicius e Daniel.</p>
        </div>
        <div class="projeto-visual">
            <div class="feature-item">
                <div class="feature-icon">🍬</div>
                <div class="feature-text">
                    <h4>Catálogo de Doces</h4>
                    <p>Gerencie todos os seus produtos em um só lugar.</p>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon">🔒</div>
                <div class="feature-text">
                    <h4>Controle por Usuário</h4>
                    <p>Cada doce pertence ao seu criador com permissões únicas.</p>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon">📊</div>
                <div class="feature-text">
                    <h4>Dashboard</h4>
                    <p>Visualize informações essenciais e estatísticas.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="stats-row">
        <div class="stat-box">
            <div class="num">PROJETO</div>
            <div class="lbl">Educacional</div>
        </div>
        <div class="stat-box">
            <div class="num">2</div>
            <div class="lbl">Desenvolvedores</div>
        </div>
        <div class="stat-box">
            <div class="num">API</div>
            <div class="lbl">REST com Token</div>
        </div>
        <div class="stat-box">
            <div class="num">Laravel</div>
            <div class="lbl">Backend</div>
        </div>
    </div>

    <div class="tech-section">
        <div class="section-title">Stack</div>
        <h2 class="section-heading">Tecnologias utilizadas</h2>
        <div class="tech-grid">
            <span class="tech-badge"><i class="fab fa-laravel"></i> Laravel</span>
            <span class="tech-badge"><i class="fab fa-php"></i> PHP</span>
            <span class="tech-badge"><i class="fas fa-database"></i> MySQL</span>
            <span class="tech-badge"><i class="fab fa-js"></i> JavaScript</span>
            <span class="tech-badge"><i class="fab fa-bootstrap"></i> Bootstrap</span>
            <span class="tech-badge"><i class="fab fa-html5"></i> HTML & CSS</span>
            <span class="tech-badge"><i class="fas fa-cookie-bite"></i> jQuery Cookie</span>
            <span class="tech-badge"><i class="fas fa-key"></i> Auth por Token</span>
            <span class="tech-badge"><i class="fas fa-key"></i> MailTrap</span>
        </div>
    </div>

    <div class="criadores-section">
        <div class="section-title">Time</div>
        <h2 class="section-heading">Quem fez o EVERSWEET</h2>
        <div class="criadores-grid">
            <div class="criador-card">
                <div class="criador-avatar">
                    <img src="/penpen.jpg" style="width:100%;height:100%;border-radius:50%;object-fit:cover;">
                </div>
                <h3>Kauã Soares</h3>
                <span class="cargo">Backend Developer</span>
                <p>Responsável pela API, autenticação por token, rotas e controllers.</p>
                <div class="criador-skills">
                    <span class="skill-tag">Laravel</span>
                    <span class="skill-tag">PHP</span>
                    <span class="skill-tag">MySQL</span>
                    <span class="skill-tag">REST API</span>
                </div>
            </div>
            <div class="criador-card">
                <div class="criador-avatar">
                    <img src="/grifo.jpg" style="width:100%;height:100%;border-radius:50%;object-fit:cover;">
                </div>
                <h3>Kauan Bonome</h3>
                <span class="cargo">FrontEnd Developer</span>
                <p>Responsável pelo design das interfaces, JavaScript e CSS.</p>
                <div class="criador-skills">
                    <span class="skill-tag">HTML & CSS</span>
                    <span class="skill-tag">JavaScript</span>
                    <span class="skill-tag">Bootstrap</span>
                    <span class="skill-tag">jQuery</span>
                </div>
            </div>
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

</body>
</html>