# CANDY API

# 📌 SOBRE
Site web desenvolvido em Laravel com o objetivo de criar uma API para uma autenticação de usuários e gerenciamento de dados.

## 🎯 Objetivo (MVP)

* Realizar cadastro de usuários
* Autenticar usuário (login)
* Armazenar token localmente
* Consumir dados da API 

## 🚀 Tecnologias utilizadas

* Html
* Css
* JS
* PHP
* API REST
* DomPDF

## 📲 Funcionalidades

* Tela de Login
* Tela de Cadastro
* Validação de usuário
* Consumo de API (GET, POST, PUT, DELETE)
* Token
* PDF 

## ⚙️ Como executar o projeto

```bash
# Clonar repositório
git clone https://github.com/IceZnn/Candy-API.git

# Acessar pasta
cd Candy-API

# Instalar dependências
composer install

# Iniciar projeto
php artisan serve
```

## 🔌 Integração com API

A aplicação consome uma API REST desenvolvida em Laravel.

👉 Endpoints utilizados:

* [POST /Cadastro Usuario][http://127.0.0.1:8000/api/Cadastro_usuario]
* [POST /Salva Doce][http://127.0.0.1:8000/api/Login]
* [GET /Exibir Doce ][http://127.0.0.1:8000/api/exibe_doce/11?token={token}]
* [POST /Salva Doce][http://127.0.0.1:8000/api/salva_doce?token={token}]
* [PUT /Atualiza Doce][http://127.0.0.1:8000/api/atualiza_doce/11?token={token}]
* [DELETE /Deleta Doce][http://127.0.0.1:8000/api/deleta_doce/11?token={token}]
* [GET /Todos Doces][http://127.0.0.1:8000/api/todos_doces]
* [GET /Enviar Email][http://localhost:8000/api/testa-email/2]

📬 Documentação completa da API:
👉 [https://documenter.getpostman.com/view/51855037/2sBXirkURM]

## 📂 Estrutura do projeto

```
Candy-API/
 ├── app/
 ├── bootstrap/
 ├── config/
 ├── database/
 ├── public/
 ├── resources/
 ├── routes/
 ├── storage/
 ├── tests/
```

## 📄 Documentação completa

* 📘 Documentação: [https://drive.google.com/file/d/1xUXRyPjd9lmlEVtiH8T_wRGjt-9rtQy4/view]
* 📬 API (Postman): [https://documenter.getpostman.com/view/51855037/2sBXirkURM#58ece7f7-8a49-4a1d-82e1-0fe4dd0ce468]
* 📊 Jira: [https://dstatuibenso.atlassian.net/jira/software/projects/PC/boards/2?atlOrigin=eyJpIjoiM2Y3ZDM4NGYwZWExNDdmY2I5Nzg3NmYxYjJmYjVjZmYiLCJwIjoiaiJ9]
* 🚩 Caso De Teste: [https://trello.com/invite/b/68d3c7e37f0c4de478c6c8cf/ATTI04b52685a1f2e0512619eb551dd9d5c5C93E995B/caso-de-teste]

## 👨‍💻 Autores

Kauã S. Rodrigues E Kauan V. Bonome Da Silva

