<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <link rel="icon" href="logo.png" type="image/png">
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>EVERSWEET</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
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

    .main-content {
      flex: 1;
      max-width: 1200px;
      margin: 40px auto;
      padding: 0 20px;
      width: 100%;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .welcome-card {
      background: linear-gradient(135deg, var(--vinho) 0%, var(--vinho-claro) 100%);
      border-radius: 25px;
      padding: 35px 40px;
      margin-bottom: 28px;
      color: white;
      box-shadow: 0 15px 30px rgba(74, 0, 18, 0.3);
      position: relative;
      overflow: hidden;
      width: 100%;
      max-width: 480px;
    }

    .welcome-card::before {
      content: '🍫';
      position: absolute;
      right: 20px;
      bottom: -20px;
      font-size: 150px;
      opacity: 0.1;
      transform: rotate(15deg);
    }

    .welcome-card h1 {
      font-family: 'Playfair Display', serif;
      font-size: 36px;
      font-weight: 700;
      margin-bottom: 8px;
    }

    .welcome-card p {
      font-size: 15px;
      opacity: 0.85;
    }

    .form-card {
      background: white;
      border-radius: 28px;
      padding: 40px;
      width: 100%;
      max-width: 480px;
      box-shadow: 0 8px 40px rgba(74, 0, 18, 0.07);
      border: 1px solid var(--borda);
    }

    .form-group {
      margin-bottom: 1.2rem;
    }

    label {
      display: block;
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      color: var(--vinho);
      margin-bottom: 6px;
    }

    .input-wrap {
      position: relative;
    }

    .input-wrap i {
      position: absolute;
      left: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: #c4748a;
      font-size: 14px;
      pointer-events: none;
      transition: color 0.2s;
    }

    .input-wrap .toggle-senha {
      left: auto;
      right: 14px;
      cursor: pointer;
      pointer-events: all;
    }

    input[type="email"],
    input[type="password"],
    input[type="text"] {
      width: 100%;
      background: #fff;
      border: 1.5px solid var(--borda);
      border-radius: 12px;
      padding: 12px 40px 12px 40px;
      color: var(--texto);
      font-family: 'DM Sans', sans-serif;
      font-size: 14px;
      outline: none;
      transition: border-color 0.2s, box-shadow 0.2s;
    }

    input::placeholder {
      color: #c9a0a8;
    }

    input:focus {
      border-color: var(--vinho);
      box-shadow: 0 0 0 3px rgba(74, 0, 18, 0.08);
    }

    .input-wrap:focus-within i {
      color: var(--vinho);
    }

    input.is-invalid {
      border-color: #e53e3e !important;
      box-shadow: 0 0 0 3px rgba(229, 62, 62, 0.1) !important;
    }

    .field-error {
      display: none;
      font-size: 12px;
      color: #c53030;
      margin-top: 5px;
    }

    .field-error.show {
      display: block;
    }

    .btn-login {
      width: 100%;
      padding: 15px;
      background: var(--vinho);
      border: none;
      border-radius: 50px;
      color: white;
      font-family: 'DM Sans', sans-serif;
      font-size: 14px;
      font-weight: 600;
      letter-spacing: 0.5px;
      cursor: pointer;
      transition: all .25s;
      box-shadow: 0 6px 20px rgba(74, 0, 18, 0.25);
      margin-top: 0.8rem;
    }

    .btn-login:hover {
      background: var(--vinho-claro);
      transform: translateY(-2px);
      box-shadow: 0 10px 28px rgba(74, 0, 18, 0.35);
    }

    .btn-login:active {
      transform: translateY(0);
    }

    .btn-login:disabled {
      opacity: 0.65;
      cursor: not-allowed;
      transform: none;
    }

    .spinner {
      display: none;
      width: 20px;
      height: 20px;
      border: 2px solid rgba(255,255,255,0.3);
      border-top-color: white;
      border-radius: 50%;
      animation: spin 0.7s linear infinite;
      margin: 0 auto;
    }

    .btn-login.loading .btn-text {
      display: none;
    }

    .btn-login.loading .spinner {
      display: block;
    }

    .form-footer {
      text-align: center;
      margin-top: 1.2rem;
      font-size: 14px;
      color: #888;
    }

    .form-footer a {
      color: var(--vinho);
      font-weight: 600;
      text-decoration: none;
    }

    .form-footer a:hover {
      text-decoration: underline;
    }

    .alert-erro {
      display: none;
      background: #fff5f5;
      border: 1.5px solid #fca5a5;
      border-radius: 12px;
      padding: 12px 16px;
      font-size: 13px;
      color: #991b1b;
      margin-bottom: 1.2rem;
      text-align: center;
    }

    .alert-erro.show {
      display: block;
    }

    .toast {
      position: fixed;
      bottom: 2rem;
      left: 50%;
      transform: translateX(-50%) translateY(120px);
      background: white;
      border: 1px solid var(--borda);
      border-radius: 14px;
      padding: 14px 22px;
      font-size: 14px;
      display: flex;
      align-items: center;
      gap: 10px;
      z-index: 9999;
      transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
      min-width: 260px;
      box-shadow: 0 20px 50px rgba(74, 0, 18, 0.15);
    }

    .toast.show {
      transform: translateX(-50%) translateY(0);
    }

    .toast.success {
      border-color: #10b981;
    }

    .toast.error {
      border-color: #e53e3e;
    }

    .toast-icon {
      font-size: 18px;
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

    @keyframes spin {
      to {
        transform: rotate(360deg);
      }
    }

    @media (max-width: 768px) {
      .nav-links {
        display: none;
      }
      .footer-content {
        grid-template-columns: 1fr;
        gap: 30px;
      }
      .form-card, .welcome-card {
        padding: 24px 18px;
      }
      .welcome-card h1 {
        font-size: 28px;
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
      <a href="/Cadastro">Cadastrar Doce</a>
      <a href="/doces">Doces</a>
      <a href="/Sobre">Sobre</a>
    </div>
    <a href="/Perfil">
        <i class="fas fa-user-circle nav-user"></i>
    </a>
  </div>
</nav>

<main class="main-content">
  <div class="welcome-card">
    <h1>Bem-vindo de volta</h1>
    <p>Entre com sua conta para continuar.</p>
  </div>

  <div class="form-card">
    <div class="alert-erro" id="alertErro">
      E-mail ou senha incorretos.
    </div>

    <div class="form-group">
      <label for="email">E-mail</label>
      <div class="input-wrap">
        <input type="email" id="email" placeholder="voce@empresa.com"/>
        <i class="fa-solid fa-envelope"></i>
      </div>
      <div class="field-error" id="err-email">Informe um e-mail válido.</div>
    </div>

    <div class="form-group">
      <label for="senha">Senha</label>
      <div class="input-wrap">
        <input type="password" id="senha" placeholder="Sua senha"/>
        <i class="fa-solid fa-lock"></i>
        <i class="fa-solid fa-eye toggle-senha" id="toggleSenha"></i>
      </div>
      <div class="field-error" id="err-senha">Por favor, informe sua senha.</div>
    </div>

    <div class="form-group">
      <label class="checkbox-label">
        <input type="checkbox" id="ativarDuplaAutentica" /> Ativar autenticação dupla 
      </label>
    </div>

    <button class="btn-login" id="btnLogin">
      <span class="btn-text">Entrar</span>
      <div class="spinner"></div>
    </button>

    <div class="form-footer">
      Não tem uma conta? <a href="/Cadastro_usuario">Cadastrar</a> | <a href="/esqueci_senha">Esqueci minha senha</a>
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

<div class="toast" id="toast">
  <span class="toast-icon" id="toastIcon"></span>
  <span id="toastMsg"></span>
</div>

<script>
$(function () {
  $('#toggleSenha').on('click', function () {
    const input = $('#senha');
    const tipo = input.attr('type') === 'password' ? 'text' : 'password';
    input.attr('type', tipo);
    $(this).toggleClass('fa-eye fa-eye-slash');
  });

  $('input').on('input', function () {
    const id = $(this).attr('id');
    $(this).removeClass('is-invalid');
    $('#err-' + id).removeClass('show');
    $('#alertErro').removeClass('show');
  });

  function validate() {
    let valid = true;
    const email = $('#email').val().trim();
    const senha = $('#senha').val();
    const reg = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    function setErr(id, cond) {
      if (cond) {
        $('#' + id).addClass('is-invalid');
        $('#err-' + id).addClass('show');
        valid = false;
      }
    }

    setErr('email', !email || !reg.test(email));
    setErr('senha', !senha);

    return valid;
  }

  function showToast(msg, type) {
    $('#toastIcon').text(type === 'success' ? '✅' : '❌');
    $('#toastMsg').text(msg);
    $('#toast').removeClass('success error').addClass(type + ' show');
    setTimeout(() => $('#toast').removeClass('show'), 3000);
  }

  $('#btnLogin').on('click', function () {
    if (!validate()) return;

    const $btn = $(this).addClass('loading').prop('disabled', true);
    $('#alertErro').removeClass('show');

    $.ajax({
      url: '/api/Login',
      method: 'POST',
      data: {
        email: $('#email').val().trim(),
        senha: $('#senha').val(),
        ativar_dupla_autentica: $('#ativarDuplaAutentica').is(':checked') ? 1 : 0
      },
      success: function (res) {
        if (res.erro === 'n') {
          $.cookie('token', res.token, { expires: 7, path: '/' });
          $.cookie('user_id', res.user_id, { expires: 7, path: '/' });
          showToast('Login realizado com sucesso!', 'success');
          setTimeout(() => window.location.href = '/Inicio?token=' + res.token, 2000);
        } else if (res.autentica_ativa || res.erro === 'p' || res.data === 'Código de autenticação enviado para o e-mail. Digite o código para continuar.') {
          showToast(res.data || 'Autenticação ativa. Redirecionando para digitar o código...', 'success');
          setTimeout(() => window.location.href = '/digita_codigo?email=' + encodeURIComponent(res.email), 1200);
        } else {
          $('#alertErro').text(res.data || 'E-mail ou senha incorretos.').addClass('show');
          $btn.removeClass('loading').prop('disabled', false);
        }
      },
      error: function (xhr) {
        if (xhr.status === 401) {
          $('#alertErro').addClass('show');
        } else {
          showToast('Erro ao conectar com o servidor.', 'error');
        }
        $btn.removeClass('loading').prop('disabled', false);
      }
    });
  });

  $('#email, #senha').on('keydown', function (e) {
    if (e.key === 'Enter') $('#btnLogin').trigger('click');
  });
});
</script>

</body>
</html>