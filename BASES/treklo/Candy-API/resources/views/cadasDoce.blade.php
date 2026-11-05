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
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #c06070;
            margin-bottom: 28px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--borda);
        }

        .form-section-title i {
            font-size: 14px;
            color: var(--vinho);
        }

        .form-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--vinho);
            margin-bottom: 6px;
            display: block;
        }

        .form-control {
            border: 1.5px solid var(--borda);
            border-radius: 12px;
            padding: 12px 16px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            background: #fff;
            color: var(--texto);
            width: 100%;
            transition: border-color .2s, box-shadow .2s;
            outline: none;
        }

        .form-control:focus {
            border-color: var(--vinho);
            box-shadow: 0 0 0 3px rgba(74, 0, 18, 0.08);
        }

        .form-control::placeholder {
            color: #c9a0a8;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 88px;
        }

        .btn-save {
            background: var(--vinho);
            color: white;
            border: none;
            padding: 15px 40px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.5px;
            border-radius: 50px;
            cursor: pointer;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all .25s;
            box-shadow: 0 6px 20px rgba(74, 0, 18, 0.25);
            margin-top: 32px;
        }

        .btn-save:hover {
            background: var(--vinho-claro);
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(74, 0, 18, 0.35);
        }

        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }
            .form-card {
                padding: 24px 18px;
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
        <h1>Cadastrar Novo Doce</h1>
    </div>

    <div class="form-card">
        <div class="form-section-title">
            <i class="fas fa-cookie-bite"></i>
            Informações do Doce
        </div>

        <form id="doceForm" enctype="multipart/form-data">
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label">Nome</label>
                    <input type="text" class="form-control" id="inputNome" name="Nome" placeholder="Ex: Brigadeiro de Pistache">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Sabor</label>
                    <input type="text" class="form-control" id="inputSabor" name="Sabor" placeholder="Ex: Doce / Amargo">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Preço (R$)</label>
                    <input type="text" class="form-control" id="inputPreco" name="Preco" placeholder="0.00">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Quantidade</label>
                    <input type="number" class="form-control" id="inputQuantidade" name="Quantidade" placeholder="0">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Alérgicos</label>
                    <input type="text" class="form-control" id="inputAlergicos" name="Alergicos" placeholder="Ex: Lactose">
                </div>
                <div class="col-12">
                    <label class="form-label">Ingredientes</label>
                    <input type="text" class="form-control" id="inputIngredientes" name="Ingredientes" placeholder="Liste os ingredientes separados por vírgula">
                </div>
                <div class="col-12">
                    <label class="form-label">Descrição</label>
                    <textarea class="form-control" id="inputDescricao" name="Descricao" placeholder="Breve descrição do doce"></textarea>
                </div>

                <div class="col-12">
                    <label class="form-label">Imagem do Doce</label>
                    <input type="file" class="form-control" id="inputImagem" name="imagem" accept="image/*" />
                    <small class="text-muted">Envie uma imagem (JPG/PNG/WEBP).</small>
                </div>
            </div>


            <button type="button" class="btn-save" id="salvaBotao">
                <i class="fas fa-save"></i> Salvar no Banco de Dados
            </button>
        </form>
    </div>
</div>

</body>
</html>