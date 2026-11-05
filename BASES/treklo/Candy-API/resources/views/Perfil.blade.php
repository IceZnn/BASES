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

    .nav-links a:hover, .nav-links a.active {
      color: var(--rosa-suave);
      border-color: var(--rosa-suave);
    }

    .nav-user {
      color: var(--rosa-suave);
      font-size: 22px;
      cursor: pointer;
      transition: color .2s;
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
      content: '🍬';
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

    .avatar-wrap {
      display: flex;
      justify-content: center;
      margin-bottom: 28px;
    }

    .avatar {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--vinho) 0%, var(--vinho-claro) 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-family: 'Playfair Display', serif;
      font-size: 32px;
      font-weight: 700;
      box-shadow: 0 8px 24px rgba(74,0,18,0.25);
      border: 3px solid var(--borda);
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
    input[type="text"],
    input[type="tel"] {
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

    input[readonly] {
      background: #fdf6f7;
      cursor: default;
      color: #7a3a4a;
    }

    input::placeholder { color: #c9a0a8; }

    input:focus {
      border-color: var(--vinho);
      box-shadow: 0 0 0 3px rgba(74, 0, 18, 0.08);
    }

    input[readonly]:focus {
      border-color: var(--borda);
      box-shadow: none;
    }

    .input-wrap:focus-within i { color: var(--vinho); }

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

    .field-error.show { display: block; }

    .section-divider {
      display: flex;
      align-items: center;
      gap: 12px;
      margin: 1.5rem 0 1.2rem;
    }

    .section-divider span {
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      color: #c4748a;
      white-space: nowrap;
    }

    .section-divider::before,
    .section-divider::after {
      content: '';
      flex: 1;
      height: 1px;
      background: var(--borda);
    }

    .btn-salvar {
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

    .btn-salvar:hover {
      background: var(--vinho-claro);
      transform: translateY(-2px);
      box-shadow: 0 10px 28px rgba(74, 0, 18, 0.35);
    }

    .btn-salvar:active { transform: translateY(0); }

    .btn-salvar:disabled {
      opacity: 0.65;
      cursor: not-allowed;
      transform: none;
    }

    .btn-outline {
      width: 100%;
      padding: 14px;
      background: transparent;
      border: 1.5px solid var(--borda);
      border-radius: 50px;
      color: var(--vinho);
      font-family: 'DM Sans', sans-serif;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      transition: all .25s;
      margin-top: 0.6rem;
    }

    .btn-outline:hover {
      border-color: var(--vinho);
      background: rgba(74,0,18,0.04);
    }

    .btn-logout {
      width: 100%;
      padding: 14px;
      background: #dc2626;
      border: none;
      border-radius: 50px;
      color: white;
      font-family: 'DM Sans', sans-serif;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      transition: all .25s;
      margin-top: 1rem;
    }

    .btn-logout:hover {
      background: #b91c1c;
      transform: translateY(-2px);
      box-shadow: 0 10px 28px rgba(220, 38, 38, 0.35);
    }

    .btn-logout:active { transform: translateY(0); }

    .btn-logout:disabled {
      opacity: 0.65;
      cursor: not-allowed;
      transform: none;
    }

    .spinner {
      display: none;
      width: 24px;
      height: 24px;
      border: 3px solid rgba(255,255,255,0.2);
      border-top: 3px solid white;
      border-right: 3px solid white;
      border-radius: 50%;
      animation: spin 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55) infinite;
      margin: 0 auto;
    }

    .btn-salvar.loading .btn-text { display: none; }
    .btn-salvar.loading .spinner { display: block; }
    .btn-logout.loading .btn-text { display: none; }
    .btn-logout.loading .spinner { display: block; }

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

    .toast.show { transform: translateX(-50%) translateY(0); }
    .toast.success { border-color: #10b981; }
    .toast.error   { border-color: #e53e3e; }
    .toast-icon    { font-size: 18px; }

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

    .footer-section a:hover { color: var(--rosa-suave); }

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

    @keyframes spin { to { transform: rotate(360deg); } }

    @media (max-width: 768px) {
      .nav-links { display: none; }
      .footer-content { grid-template-columns: 1fr; gap: 30px; }
      .form-card, .welcome-card { padding: 24px 18px; }
      .welcome-card h1 { font-size: 28px; }
    }
  </style>
</head>
<body>

<nav class="navbar">
  <div class="nav-container">
    <div class="logo"><span>EVERSWEET</span></div>
    <div class="nav-links">
      <a href="/Inicio">Início</a>
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
    <h1>Meu Perfil</h1>
    <p>Gerencie suas informações pessoais.</p>
  </div>

  <div class="form-card">

    <div class="avatar-wrap">
      <div class="avatar" id="avatarLetra">?</div>
    </div>

    <div class="section-divider"><span>Dados Pessoais</span></div>

    <div class="form-group">
      <label for="nome">Nome</label>
      <div class="input-wrap">
        <input type="text" id="nome" placeholder="Seu nome completo"/>
        <i class="fa-solid fa-user"></i>
      </div>
      <div class="field-error" id="err-nome">Informe seu nome.</div>
    </div>

    <div class="form-group">
      <label for="email">E-mail</label>
      <div class="input-wrap">
        <input type="email" id="email" placeholder="voce@empresa.com" readonly/>
        <i class="fa-solid fa-envelope"></i>
      </div>
    </div>

    <div class="form-group">
      <label for="telefone">Telefone</label>
      <div class="input-wrap">
        <input type="tel" id="telefone" placeholder="(00) 00000-0000"/>
        <i class="fa-solid fa-phone"></i>
      </div>
      <div class="field-error" id="err-telefone">Informe seu telefone.</div>
    </div>

    <div class="form-group">
      <label for="empresa">Empresa</label>
      <div class="input-wrap">
        <input type="text" id="empresa" placeholder="Nome da sua empresa"/>
        <i class="fa-solid fa-building"></i>
      </div>
      <div class="field-error" id="err-empresa">Informe sua empresa.</div>
    </div>

    <button class="btn-salvar" id="btnSalvar">
      <span class="btn-text">Salvar Alterações</span>
      <div class="spinner"></div>
    </button>

    <button class="btn-outline" id="btnDupla">Carregando autenticação dupla...</button>

    <div class="section-divider" style="margin-top: 2rem;"><span>Alterar Senha</span></div>

    <div class="form-group">
      <label for="senha-atual">Senha Atual</label>
      <div class="input-wrap">
        <input type="password" id="senha-atual" placeholder="Sua senha atual"/>
        <i class="fa-solid fa-lock"></i>
        <i class="fa-solid fa-eye toggle-senha" id="toggleAtual"></i>
      </div>
      <div class="field-error" id="err-senha-atual">Informe sua senha atual.</div>
    </div>

    <div class="form-group">
      <label for="senha-nova">Nova Senha</label>
      <div class="input-wrap">
        <input type="password" id="senha-nova" placeholder="Mínimo 6 caracteres"/>
        <i class="fa-solid fa-lock"></i>
        <i class="fa-solid fa-eye toggle-senha" id="toggleNova"></i>
      </div>
      <div class="field-error" id="err-senha-nova">A senha deve ter ao menos 6 caracteres.</div>
    </div>

    <button class="btn-outline" id="btnSenha">Atualizar Senha</button>

    <button class="btn-logout" id="btnLogout">
      <span class="btn-text"><i class="fa-solid fa-sign-out-alt" style="margin-right: 8px;"></i>Sair da Conta</span>
      <div class="spinner"></div>
    </button>

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

  const token  = $.cookie('token');
  const userId = $.cookie('user_id');

  if (!token) {
    window.location.href = '/Login';
  }

  function carregarPerfil() {
    $.ajax({
      url: '/api/perfil?token=' + token,
      method: 'GET',
      success: function (res) {
        if (res.erro === 'n') {
          const u = res.usuario;
          $('#nome').val(u.nome);
          $('#email').val(u.email);
          $('#telefone').val(u.telefone);
          $('#empresa').val(u.empresa);
          $('#avatarLetra').text(u.nome ? u.nome.charAt(0).toUpperCase() : '?');
          updateDuplaButton(u.dupla_autentica === '1');
        }
      },
      error: function () {
        showToast('Erro ao carregar perfil.', 'error');
      }
    });
  }

  carregarPerfil();

  $('#toggleAtual').on('click', function () {
    const i = $('#senha-atual');
    i.attr('type', i.attr('type') === 'password' ? 'text' : 'password');
    $(this).toggleClass('fa-eye fa-eye-slash');
  });

  $('#toggleNova').on('click', function () {
    const i = $('#senha-nova');
    i.attr('type', i.attr('type') === 'password' ? 'text' : 'password');
    $(this).toggleClass('fa-eye fa-eye-slash');
  });

  $('input').on('input', function () {
    const id = $(this).attr('id');
    $(this).removeClass('is-invalid');
    $('#err-' + id).removeClass('show');
  });

  $('#btnSalvar').on('click', function () {
    let valid = true;
    ['nome', 'telefone', 'empresa'].forEach(function (c) {
      if (!$('#' + c).val().trim()) {
        $('#' + c).addClass('is-invalid');
        $('#err-' + c).addClass('show');
        valid = false;
      }
    });

    if (!valid) return;

    const $btn = $(this).addClass('loading').prop('disabled', true);

    $.ajax({
      url: '/api/perfil?token=' + token,
      method: 'PUT',
      data: {
        nome:     $('#nome').val().trim(),
        telefone: $('#telefone').val().trim(),
        empresa:  $('#empresa').val().trim(),
      },
      success: function (res) {
        if (res.erro === 'n') {
          showToast('Perfil atualizado com sucesso!', 'success');
          $('#avatarLetra').text($('#nome').val().charAt(0).toUpperCase());
        } else {
          showToast(res.data || 'Erro ao atualizar.', 'error');
        }
      },
      error: function () {
        showToast('Erro ao conectar com o servidor.', 'error');
      },
      complete: function () {
        $btn.removeClass('loading').prop('disabled', false);
      }
    });
  });

  $('#btnSenha').on('click', function () {
    let valid = true;
    const atual = $('#senha-atual').val();
    const nova  = $('#senha-nova').val();

    if (!atual) {
      $('#senha-atual').addClass('is-invalid');
      $('#err-senha-atual').addClass('show');
      valid = false;
    }
    if (!nova || nova.length < 6) {
      $('#senha-nova').addClass('is-invalid');
      $('#err-senha-nova').addClass('show');
      valid = false;
    }
    if (!valid) return;

    const $btn = $(this).prop('disabled', true).text('Aguarde...');

    $.ajax({
      url: '/api/perfil/senha?token=' + token,
      method: 'PUT',
      data: { senha_atual: atual, senha_nova: nova },
      success: function (res) {
        if (res.erro === 'n') {
          showToast('Senha alterada com sucesso!', 'success');
          $('#senha-atual, #senha-nova').val('');
        } else {
          showToast(res.data || 'Senha atual incorreta.', 'error');
        }
      },
      error: function (xhr) {
        const msg = xhr.responseJSON?.data || 'Erro ao alterar senha.';
        showToast(msg, 'error');
      },
      complete: function () {
        $btn.prop('disabled', false).text('Atualizar Senha');
      }
    });
  });

  $('#btnDupla').on('click', function () {
    const ativa = $(this).data('ativa') ? 0 : 1;
    const $btn = $(this).prop('disabled', true).text('Aguarde...');

    $.ajax({
      url: '/api/perfil/dupla-autentica?token=' + token,
      method: 'PUT',
      data: { ativa },
      success: function (res) {
        if (res.erro === 'n') {
          showToast(res.data, 'success');
          updateDuplaButton(res.dupla_autentica === '1');
        } else {
          showToast(res.data || 'Erro ao alterar autenticação dupla.', 'error');
        }
      },
      error: function (xhr) {
        const msg = xhr.responseJSON?.data || 'Erro ao alterar autenticação dupla.';
        showToast(msg, 'error');
      },
      complete: function () {
        $btn.prop('disabled', false);
      }
    });
  });

  $('#btnLogout').on('click', function () {
    const $btn = $(this).addClass('loading').prop('disabled', true);

    $.ajax({
      url: '/api/logout?token=' + token,
      method: 'POST',
      success: function () {
        $.removeCookie('token');
        $.removeCookie('user_id');
        showToast('Deslogado com sucesso!', 'success');
        setTimeout(() => {
          window.location.href = '/Login';
        }, 1000);
      },
      error: function () {
        showToast('Erro ao deslogar.', 'error');
        $btn.removeClass('loading').prop('disabled', false);
      }
    });
  });

  function updateDuplaButton(active) {
    $('#btnDupla')
      .data('ativa', active ? 1 : 0)
      .text(active ? 'Desativar autenticação dupla' : 'Ativar autenticação dupla');
  }

  function showToast(msg, type) {
    $('#toastIcon').text(type === 'success' ? '✅' : '❌');
    $('#toastMsg').text(msg);
    $('#toast').removeClass('success error').addClass(type + ' show');
    setTimeout(() => $('#toast').removeClass('show'), 3000);
  }

});
</script>

</body>
</html>