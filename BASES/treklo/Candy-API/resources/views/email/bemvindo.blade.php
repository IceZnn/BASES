<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo à EVERSWEET</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f9f3ef;
            font-family: 'DM Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            padding: 30px 0;
        }

        /* Container principal do e-mail */
        .email-container {
            max-width: 560px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 32px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(74, 0, 18, 0.08);
            border: 1px solid #ead1d1;
        }

        /* Cabeçalho com gradiente e logo */
        .email-header {
            background: linear-gradient(135deg, #4a0012 0%, #6b1a2c 100%);
            padding: 40px 30px 36px;
            text-align: center;
            position: relative;
        }

        .logo {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 34px;
            font-weight: 800;
            letter-spacing: 2px;
            color: white;
            margin-bottom: 12px;
            display: inline-block;
            border-bottom: 2px solid #ffb3c1;
            padding-bottom: 6px;
        }

        .logo em {
            font-style: italic;
            color: #ffb3c1;
        }

        .welcome-badge {
            background: rgba(255, 179, 193, 0.18);
            display: inline-block;
            padding: 6px 18px;
            border-radius: 40px;
            font-size: 12px;
            font-weight: 600;
            color: #ffb3c1;
            letter-spacing: 0.5px;
            margin-top: 14px;
        }

        /* Corpo do e-mail */
        .email-body {
            padding: 40px 34px 34px;
        }

        .greeting {
            font-size: 28px;
            font-weight: 700;
            font-family: 'Playfair Display', Georgia, serif;
            color: #4a0012;
            margin-bottom: 12px;
            line-height: 1.2;
        }

        .greeting span {
            color: #a0293e;
            font-weight: 800;
        }

        .user-name {
            color: #6b1a2c;
            font-weight: 600;
        }

        .message-text {
            color: #3e1a24;
            font-size: 16px;
            line-height: 1.65;
            margin: 20px 0 28px;
            font-weight: 400;
        }

        /* Card de destaques */
        .highlight-card {
            background: #fff9f5;
            border-left: 4px solid #ffb3c1;
            border-radius: 20px;
            padding: 20px 24px;
            margin: 28px 0;
            box-shadow: 0 2px 10px rgba(74, 0, 18, 0.05);
        }

        .highlight-card p {
            margin: 8px 0;
            font-size: 14px;
            color: #5a2a36;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .highlight-card i {
            color: #a0293e;
            width: 20px;
            font-size: 16px;
        }

        /* Botão principal */
        .btn-primary {
            display: inline-block;
            background-color: #4a0012;
            color: white;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 15px;
            letter-spacing: 0.5px;
            margin: 12px 0 8px;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(74, 0, 18, 0.2);
            border: none;
        }

        .btn-primary:hover {
            background-color: #6b1a2c;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(74, 0, 18, 0.25);
        }

        /* Rodapé do e-mail */
        .email-footer {
            background-color: #fff5f0;
            padding: 28px 34px 32px;
            border-top: 1px solid #ead1d1;
            text-align: center;
        }

        .social-icons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 24px;
        }

        .social-icons a {
            color: #6b1a2c;
            background: white;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.2s;
            border: 1px solid #ead1d1;
        }

        .social-icons a:hover {
            background-color: #ffb3c1;
            color: #4a0012;
            border-color: #ffb3c1;
        }

        .footer-links {
            font-size: 12px;
            color: #8a5060;
            margin-bottom: 20px;
        }

        .footer-links a {
            color: #8a5060;
            text-decoration: none;
            margin: 0 10px;
            transition: color 0.2s;
        }

        .footer-links a:hover {
            color: #4a0012;
            text-decoration: underline;
        }

        .copyright {
            font-size: 11px;
            color: #b28797;
            margin-top: 20px;
        }

        hr {
            border: none;
            height: 1px;
            background: linear-gradient(to right, #ead1d1, transparent);
            margin: 16px 0;
        }

        @media (max-width: 600px) {
            .email-body {
                padding: 30px 24px;
            }
            .greeting {
                font-size: 24px;
            }
            .btn-primary {
                display: block;
                text-align: center;
            }
        }
    </style>
</head>
<body>

<div class="email-container">
    <!-- HEADER -->
    <div class="email-header">
        <div class="logo">Ever<em>sweet</em></div>
        <div class="welcome-badge">
            <i class="fas fa-heart" style="font-size: 10px; margin-right: 6px;"></i> Seja bem-vindo(a)!
        </div>
    </div>

    <!-- BODY -->
    <div class="email-body">
        <div class="greeting">
            Olá, <span class="user-name">{{ $usuario->nome }}</span>! 
            <span style="display: inline-block;">✨</span>
        </div>

        <div class="message-text">
            Que alegria ter você com a gente! Seu cadastro na <strong>EVERSWEET</strong> foi um sucesso e agora você faz parte da nossa família de amantes de doces artesanais.
        </div>

        <div class="message-text">
            Prepare-se para receber receitinhas exclusivas, promoções especiais e todo o sabor que só a gente tem. 🍰🍫
        </div>

        <!-- Destaques fofos -->
        <div class="highlight-card">
            <p><i class="fas fa-crown"></i> <strong>Primeira compra?</strong> Use o cupom <strong style="color:#a0293e;">DOCEESTREIA</strong> e ganhe 10% OFF</p>
            <p><i class="fas fa-truck-fast"></i> Frete grátis para pedidos acima de R$89,90</p>
            <p><i class="fas fa-gift"></i> Todo mês sorteamos um <strong>KIT PREMIUM</strong> entre assinantes</p>
        </div>

        <div style="text-align: center; margin: 30px 0 10px;">
            <a href="https://eversweet.com/doces" class="btn-primary">
                <i class="fas fa-candy-cane" style="margin-right: 8px;"></i> Explorar catálogo
            </a>
        </div>

        <hr>
        <p style="font-size: 12px; color: #a6707c; text-align: center; margin-top: 20px;">
            💌 Estamos loucos para adoçar o seu dia. Se precisar de algo, é só responder este e-mail.
        </p>
    </div>

    <!-- FOOTER -->
    <div class="email-footer">
        <div class="social-icons">
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-whatsapp"></i></a>
            <a href="#"><i class="fab fa-tiktok"></i></a>
        </div>
        <div class="footer-links">
            <a href="#">Início</a> • 
            <a href="#">Catálogo</a> • 
            <a href="#">Sobre nós</a> • 
            <a href="#">Ajuda</a>
        </div>
        <div class="copyright">
            © 2026 EVERSWEET Doces Artesanais • Feito com ❤️ e açúcar
            <br>
            <span style="font-size: 10px;">Rua da Doçura, 123 - São Paulo, SP</span>
        </div>
    </div>
</div>

</body>
</html>