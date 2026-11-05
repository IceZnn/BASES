<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
        }
        .header {
            background: linear-gradient(135deg, #4a0012, #6b1a2c);
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .content p {
            margin: 10px 0;
        }
        .button-container {
            text-align: center;
            margin: 30px 0;
        }
        .reset-button {
            background: linear-gradient(135deg, #4a0012, #6b1a2c);
            color: white;
            padding: 15px 40px;
            text-decoration: none;
            border-radius: 8px;
            display: inline-block;
            font-weight: bold;
        }
        .reset-button:hover {
            opacity: 0.9;
        }
        .token-box {
            background: #f0f0f0;
            padding: 15px;
            border-left: 4px solid #4a0012;
            margin: 20px 0;
            border-radius: 4px;
        }
        .token-box p {
            margin: 5px 0;
            font-size: 14px;
        }
        .token-box strong {
            display: block;
            margin: 10px 0 5px 0;
            color: #4a0012;
        }
        .footer {
            color: #666;
            font-size: 12px;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Recuperação de Senha</h1>
        </div>

        <div class="content">
            <p>Olá!</p>
            <p>Recebemos uma solicitação para recuperar a senha da sua conta. Se não foi você, ignore este e-mail.</p>

            <p>Para redefinir sua senha, use o código abaixo:</p>

            <p><strong>Seu código de recuperação:</strong></p>
            <div class="token-box">
                <strong style="font-size: 24px; letter-spacing: 2px;">{{ $codigo }}</strong>
            </div>

            <p>Acesse este link e digite o código:</p>

            <div class="button-container">
                <a href="{{ config('app.frontend_url') }}/digita_reset_senha?email={{ $email }}" class="reset-button">
                    Recuperar Senha
                </a>
            </div>

            <p style="color: #d9534f;">
                <strong>⚠️ Este código expira em 10 minutos.</strong>
            </p>

            <p>Se você não solicitou uma recuperação de senha, por favor, ignore este e-mail.</p>

            <p>Se você não solicitou uma recuperação de senha, por favor, ignore este e-mail.</p>
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} Candy. Todos os direitos reservados.</p>
            <p>Este é um e-mail automático, por favor não responda.</p>
        </div>
    </div>
</body>
</html>
