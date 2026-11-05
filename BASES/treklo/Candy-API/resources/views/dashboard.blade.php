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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>
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

        .main-content {
            flex: 1;
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
            width: 100%;
        }

        .welcome-card {
            background: linear-gradient(135deg, var(--vinho) 0%, var(--vinho-claro) 100%);
            border-radius: 28px;
            padding: 35px;
            margin-bottom: 30px;
            color: white;
            box-shadow: 0 15px 30px rgba(74, 0, 18, 0.3);
            position: relative;
            overflow: hidden;
        }

        .welcome-card::before {
            content: '🍰';
            position: absolute;
            right: 20px;
            bottom: -20px;
            font-size: 150px;
            opacity: 0.08;
            transform: rotate(15deg);
        }

        .welcome-card h1 {
            font-family: 'Playfair Display', serif;
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 6px;
            letter-spacing: -1px;
        }

        .welcome-card p {
            font-size: 15px;
            opacity: 0.85;
        }

        .welcome-actions {
            display: flex;
            gap: 12px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .btn-welcome {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 22px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: all .2s;
            cursor: pointer;
            border: none;
            font-family: 'DM Sans', sans-serif;
        }

        .btn-welcome.primary {
            background: white;
            color: var(--vinho);
        }

        .btn-welcome.primary:hover {
            background: var(--rosa-suave);
            transform: translateY(-2px);
        }

        .btn-welcome.secondary {
            background: rgba(255,255,255,0.15);
            color: white;
            border: 1px solid rgba(255,255,255,0.3);
        }

        .btn-welcome.secondary:hover {
            background: rgba(255,255,255,0.25);
            transform: translateY(-2px);
        }

        .btn-welcome.pdf {
            background: rgba(255,255,255,0.1);
            color: white;
            border: 1px solid rgba(255,255,255,0.2);
        }

        .btn-welcome.pdf:hover {
            background: rgba(255,255,255,0.2);
            transform: translateY(-2px);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 24px;
            border: 1px solid var(--borda);
            box-shadow: 0 4px 15px rgba(74, 0, 18, 0.04);
            transition: transform .2s, box-shadow .2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 28px rgba(74, 0, 18, 0.1);
        }

        .stat-card h3 {
            color: #c06070;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .stat-number {
            font-family: 'Playfair Display', serif;
            font-size: 42px;
            font-weight: 800;
            color: var(--vinho);
            letter-spacing: -1px;
            line-height: 1;
            margin-bottom: 6px;
        }

        .stat-sub {
            font-size: 12px;
            color: #c9a0a8;
        }

        .destaques-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .destaque-card {
            background: white;
            border-radius: 20px;
            padding: 22px 24px;
            border: 1px solid var(--borda);
            box-shadow: 0 4px 15px rgba(74, 0, 18, 0.04);
            transition: transform .2s, box-shadow .2s;
        }

        .destaque-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 28px rgba(74, 0, 18, 0.1);
        }

        .destaque-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #c06070;
            margin-bottom: 8px;
        }

        .destaque-nome {
            font-family: 'Playfair Display', serif;
            font-size: 16px;
            font-weight: 700;
            color: var(--vinho);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 200px;
        }

        .destaque-preco {
            font-size: 22px;
            font-weight: 800;
            color: var(--vinho);
            margin-top: 6px;
        }

        .destaque-sabor {
            font-size: 12px;
            color: #c9a0a8;
            margin-top: 4px;
        }

        .chart-card {
            background: white;
            border-radius: 20px;
            padding: 26px;
            border: 1px solid var(--borda);
            box-shadow: 0 4px 15px rgba(74, 0, 18, 0.04);
            margin-bottom: 30px;
        }

        .chart-card h3 {
            color: var(--vinho);
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: 'DM Sans', sans-serif;
        }

        .chart-wrap {
            position: relative;
            height: 280px;
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

        @media (max-width: 900px) {
            .stats-grid {
                grid-template-columns: 1fr 1fr;
            }
            .destaques-grid {
                grid-template-columns: 1fr;
            }
            .footer-content {
                grid-template-columns: 1fr;
                gap: 30px;
            }
            .nav-links {
                display: none;
            }
        }

        @media (max-width: 600px) {
            .stats-grid {
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
            <a href="/Login">Login</a>
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

<main class="main-content">
    <div class="welcome-card">
        <h1>Dashboard</h1>
        <p>Visão geral do sistema EVERSWEET</p>
        <div class="welcome-actions">
            <a href="/Cadastro" class="btn-welcome primary"><i class="fas fa-plus"></i> Cadastrar Doce</a>
            <a href="/doces" class="btn-welcome secondary"><i class="fas fa-eye"></i> Ver Catálogo</a>
            <button class="btn-welcome pdf" id="btnPdf"> Exportar PDF</button>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <h3>Total de Doces</h3>
            <div class="stat-number" id="statTotal">—</div>
            <div class="stat-sub">cadastrados no sistema</div>
        </div>
        <div class="stat-card">
            <h3>Sabores Únicos</h3>
            <div class="stat-number" id="statSabores">—</div>
            <div class="stat-sub">variedades diferentes</div>
        </div>
        <div class="stat-card">
            <h3>Preço Médio</h3>
            <div class="stat-number" id="statPreco">—</div>
            <div class="stat-sub">por doce</div>
        </div>
    </div>

    <div class="destaques-grid">
        <div class="destaque-card">
            <div class="destaque-label"><i class="fas fa-arrow-up"></i> Doce mais caro</div>
            <div class="destaque-nome" id="maiorNome">—</div>
            <div class="destaque-preco" id="maiorPreco">—</div>
            <div class="destaque-sabor" id="maiorSabor">—</div>
        </div>
        <div class="destaque-card">
            <div class="destaque-label"><i class="fas fa-arrow-down"></i> Doce mais barato</div>
            <div class="destaque-nome" id="menorNome">—</div>
            <div class="destaque-preco" id="menorPreco">—</div>
            <div class="destaque-sabor" id="menorSabor">—</div>
        </div>
    </div>

    <div class="chart-card">
        <h3><i class="fas fa-chart-bar"></i> Doces Cadastrados por Mês</h3>
        <div class="chart-wrap">
            <canvas id="graficoMeses"></canvas>
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
    //parte do grafico
    const MESES = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
    let grafico = null;
    let todosDoces = [];

    //pegar o dado dos doces
    $.ajax({
        url: '/api/todos_doces',
        method: 'GET',
        success: function (res) {
            if (res.erro !== 'n') return;

            todosDoces = res.doces;
            const total = todosDoces.length;
            const sabores = [...new Set(todosDoces.map(d => d.Sabor.trim().toLowerCase()))].length;
            const media = total > 0
                ? (todosDoces.reduce((s, d) => s + parseFloat(d.Preco), 0) / total).toFixed(2)
                : '0.00';

                //pega os dados especificos: sabores,preço e total
            $('#statTotal').text(total);
            $('#statSabores').text(sabores);
            $('#statPreco').text('R$ ' + media.replace('.', ','));

            if (total > 0) {
                const maior = todosDoces.reduce((a, b) => parseFloat(a.Preco) > parseFloat(b.Preco) ? a : b);
                const menor = todosDoces.reduce((a, b) => parseFloat(a.Preco) < parseFloat(b.Preco) ? a : b);

                $('#maiorNome').text(maior.Nome);
                $('#maiorPreco').text('R$ ' + parseFloat(maior.Preco).toFixed(2).replace('.', ','));
                $('#maiorSabor').text(maior.Sabor);

                $('#menorNome').text(menor.Nome);
                $('#menorPreco').text('R$ ' + parseFloat(menor.Preco).toFixed(2).replace('.', ','));
                $('#menorSabor').text(menor.Sabor);
            }

            //datas e qnd foi criado
            const contagem = Array(12).fill(0);
            todosDoces.forEach(function (d) {
                if (d.created_at) {
                    contagem[new Date(d.created_at).getMonth()]++;
                }
            });

            const ctx = document.getElementById('graficoMeses').getContext('2d');
            if (grafico) grafico.destroy();

            //grafico inteiro
            grafico = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: MESES,
                    datasets: [{
                        label: 'Doces cadastrados',
                        data: contagem,
                        backgroundColor: 'rgba(74, 0, 18, 0.08)',
                        borderColor: '#4a0012',
                        borderWidth: 2,
                        borderRadius: 8,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(ctx) {
                                    return ' ' + ctx.parsed.y + ' doce(s)';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { color: '#c9a0a8', font: { size: 11, family: "'DM Sans', sans-serif" } }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1, color: '#c9a0a8', font: { size: 11 } },
                            grid: { color: '#f0e0e0' }
                        }
                    }
                }
            });
        }
    });
    $('#btnPdf').on('click', function () {
    window.open('/api/exportar-pdf', '_blank');
    });
});
</script>

</body>
</html>