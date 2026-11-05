<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Autenticação de dois fatores</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>

    <script src="{{ asset('autenticacao_dupla.js') }}"></script>
    <style>
        :root {
            --vinho: #4a0012;
            --vinho-claro: #6b1a2c;
            --rosa-suave: #ffb3c1;
            --creme: #fff9f5;
            --borda: #ead1d1;
            --texto: #2d0a12;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'DM Sans', sans-serif;
            background: linear-gradient(180deg, #fdf0f2 0%, #ffe8eb 100%);
            color: var(--texto);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .page-wrapper {
            width: 100%;
            max-width: 520px;
        }

        .auth-card {
            background: white;
            border-radius: 28px;
            box-shadow: 0 18px 50px rgba(74, 0, 18, 0.12);
            padding: 34px 32px;
            border: 1px solid var(--borda);
        }

        .auth-header {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 28px;
        }

        .auth-header h1 {
            font-size: 28px;
            margin: 0;
            color: var(--vinho);
        }

        .auth-header p {
            margin: 0;
            color: #5f323f;
            line-height: 1.5;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1px;
            color: var(--vinho);
            text-transform: uppercase;
        }

        .input-group input {
            width: 100%;
            padding: 14px 16px;
            border-radius: 14px;
            border: 1.5px solid var(--borda);
            font-size: 15px;
            color: var(--texto);
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .input-group input:focus {
            border-color: var(--vinho);
            box-shadow: 0 0 0 4px rgba(106, 7, 31, 0.08);
        }

        .btn-submit {
            width: 100%;
            background: linear-gradient(135deg, var(--vinho), var(--vinho-claro));
            border: none;
            border-radius: 999px;
            color: white;
            font-size: 15px;
            font-weight: 700;
            padding: 15px 0;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(74, 0, 18, 0.22);
        }

        .auth-footer {
            margin-top: 22px;
            color: #7a4b5f;
            font-size: 14px;
            text-align: center;
            line-height: 1.6;
        }

        .toast {
            position: fixed;
            left: 50%;
            bottom: 20px;
            transform: translateX(-50%) translateY(100px);
            background: white;
            border: 1px solid var(--borda);
            border-radius: 14px;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 280px;
            box-shadow: 0 20px 50px rgba(74, 0, 18, 0.12);
            opacity: 0;
            transition: transform 0.3s ease, opacity 0.3s ease;
            pointer-events: none;
        }

        .toast.show {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
            pointer-events: auto;
        }

        .toast-icon {
            font-size: 18px;
        }

        @media (max-width: 500px) {
            .auth-card {
                padding: 26px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="page-wrapper">
        <section class="auth-card">
            <div class="auth-header">
                <span style="color: var(--rosa-suave); font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px;">Autenticação de dois fatores</span>
                <h1>Digite seu código</h1>
                <p>Enviamos um código para o seu e-mail. Use-o para concluir seu login com segurança.</p>
            </div>

            <div class="input-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" placeholder="seu@email.com" />
            </div>

            <div class="input-group">
                <label for="codigo">Código de verificação</label>
                <input type="text" id="codigo" name="codigo" placeholder="000000" maxlength="6" />
            </div>

            <button id="enviar_codigo" class="btn-submit">Enviar código</button>

            <p class="auth-footer">
                Não recebeu o código? Verifique a pasta de spam ou tente novamente em alguns minutos.
            </p>
        </section>
    </div>

    <div class="toast" id="toast">
        <span class="toast-icon" id="toastIcon">✅</span>
        <span id="toastMsg">Aguardando validação do código...</span>
    </div>
</body>
</html>