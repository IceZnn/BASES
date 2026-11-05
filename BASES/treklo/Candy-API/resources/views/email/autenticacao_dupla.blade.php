<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autenticação EVERSWEET</title>
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

        .email-container {
            max-width: 560px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 32px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(74, 0, 18, 0.08);
            border: 1px solid #ead1d1;
        }

        .email-header {
            background: linear-gradient(135deg, #4a0012 0%, #6b1a2c 100%);
            padding: 40px 30px 36px;
            text-align: center;
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

        .security-badge {
            background: rgba(255, 179, 193, 0.18);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 18px;
            border-radius: 40px;
            font-size: 12px;
            font-weight: 600;
            color: #ffb3c1;
            letter-spacing: 0.5px;
            margin-top: 14px;
        }

        .email-body {
            padding: 40px 34px 34px;
        }

        .greeting {
            font-size: 26px;
            font-weight: 700;
            font-family: 'Playfair Display', Georgia, serif;
            color: #4a0012;
            margin-bottom: 10px;
            line-height: 1.2;
        }

        .message-text {
            color: #3e1a24;
            font-size: 15px;
            line-height: 1.65;
            margin: 16px 0 28px;
        }

        .code-card {
            background: #fff9f5;
            border: 1px solid #ead1d1;
            border-radius: 20px;
            padding: 28px 24px;
            text-align: center;
            margin: 0 0 24px;
        }

        .code-label {
            font-size: 12px;
            font-weight: 600;
            color: #a6707c;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 18px;
        }

        .code-value {
            font-size: 40px;
            font-weight: 800;
            color: #4a0012;
            letter-spacing: 14px;
            font-family: 'Courier New', monospace;
            margin-bottom: 18px;
            display: block;
        }

        .timer-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(160, 41, 62, 0.08);
            color: #a0293e;
            font-size: 13px;
            font-weight: 600;
            padding: 7px 16px;
            border-radius: 40px;
        }

        .alert-card {
            background: #fff0f2;
            border-left: 4px solid #ffb3c1;
            border-radius: 20px;
            padding: 16px 20px;
            margin: 24px 0;
            font-size: 13px;
            color: #5a2a36;
            line-height: 1.6;
        }

        .alert-card strong {
            color: #4a0012;
        }

        hr {
            border: none;
            height: 1px;
            background: linear-gradient(to right, #ead1d1, transparent);
            margin: 20px 0;
        }

        .footer-note {
            font-size: 12px;
            color: #a6707c;
            text-align: center;
            margin-top: 16px;
        }

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
            border: 1px solid #ead1d1;
            font-size: 15px;
        }

        .footer-links {
            font-size: 12px;
            color: #8a5060;
            margin-bottom: 20px;
        }

        .footer-links a {
            color: #8a5060;
            text-decoration: none;
            margin: 0 8px;
        }

        .copyright {
            font-size: 11px;
            color: #b28797;
            margin-top: 16px;
        }

        @media (max-width: 600px) {
            .email-body {
                padding: 30px 24px;
            }
            .greeting {
                font-size: 22px;
            }
            .code-value {
                font-size: 32px;
                letter-spacing: 10px;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="email-container">

    <!-- HEADER -->
    <div class="email-header">
        <div class="logo">Ever<em>sweet</em></div>
        <br>
        <div class="security-badge">
            <i class="fas fa-lock" style="font-size: 10px;"></i>
            Verificação de segurança
        </div>
    </div>

    <!-- BODY -->
    <div class="email-body">
        <div class="greeting">Confirme seu acesso 🔐</div>

        <p class="message-text">
            Recebemos uma solicitação de acesso à sua conta na <strong>EVERSWEET</strong>. Use o código abaixo para concluir a autenticação.
        </p>

        <!-- Card do código -->
        <div class="code-card">
            <div class="code-label">
                <i class="fas fa-shield-halved" style="margin-right: 6px;"></i>
                Código de autenticação
            </div>
            <span class="code-value">{{$codigo}}</span>
            <div class="timer-pill">
                <i class="fas fa-clock" style="font-size: 12px;"></i>
                Válido por 10 minutos
            </div>
        </div>

        <!-- Aviso de segurança -->
        <div class="alert-card">
            <i class="fas fa-triangle-exclamation" style="color: #a0293e; margin-right: 8px;"></i>
            <strong>Não foi você?</strong> Ignore este e-mail com segurança. Sua conta continua protegida e nenhuma ação adicional é necessária.
        </div>

        <hr>
        <p class="footer-note">
            💌 Alguma dúvida? É só responder este e-mail — estamos aqui pra ajudar.
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