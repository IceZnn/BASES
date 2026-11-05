# Projeto Base Laravel

Boilerplate didático para iniciar aplicações pequenas e médias com Laravel 12, PHP 8.3+, MySQL, Blade, Bootstrap 5, Eloquent e Sanctum. Os módulos deste projeto são exemplos reutilizáveis: adapte nomes, regras e políticas ao domínio da aplicação nova.

## Requisitos

- PHP 8.3 ou superior e Composer
- MySQL 8+ (ou SQLite para desenvolvimento/testes)
- Node.js/npm são opcionais; a interface usa Bootstrap 5 e Bootstrap Icons por CDN

## Instalação

1. Instale as dependências e crie o arquivo de ambiente:

   ```sh
   composer install
   copy .env.example .env
   php artisan key:generate
   ```

   No PowerShell, use `Copy-Item .env.example .env` no lugar de `copy`.

2. Crie o banco `projeto_base` no MySQL e ajuste `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME` e `DB_PASSWORD` no `.env`.
3. Execute as migrations e os dados de demonstração:

   ```sh
   php artisan migrate --seed
   php artisan storage:link
   php artisan serve
   ```

4. Acesse `http://127.0.0.1:8000`.

O seeder cria `admin@example.com` com a senha inicial `password`. Troque essa senha imediatamente fora de um ambiente local de demonstração. Configure SMTP no `.env` para enviar e-mails reais de recuperação de senha.

Para SQLite, altere `DB_CONNECTION=sqlite` e crie `database/database.sqlite` antes de migrar. Os testes usam SQLite em memória e não precisam do banco MySQL.

## O que está incluído

- Cadastro, login, logout, recuperação e redefinição de senha; alteração de senha e perfil.
- Hash de senha pelo hasher do Laravel (`Hash::make`, cast `hashed` e `Auth::attempt`).
- Middleware de papéis (`role:administrator,manager`) e rotas de administração.
- CRUDs web reutilizáveis de usuários, produtos, categorias, clientes, fornecedores, funcionários, departamentos e pedidos, com pesquisa, filtros, paginação, validação, mensagens e confirmação de exclusão.
- Gestão de estoque com ajuste de entrada/saída transacional e proteção contra saldo negativo; notificações, configurações pessoais e perfil.
- Upload de imagens no disco público, atualização e exclusão de imagens antigas.
- Dashboard com indicadores, tabelas recentes e gráficos; relatórios com exportação CSV.
- API JSON versionada em `/api/v1`, protegida com tokens pessoais Sanctum.
- Seeders/factories, repositories, services, requests e componentes Blade.
- Papéis e opções de status carregados das tabelas de referência `roles` e `statuses`.

## Acesso e API

As páginas administrativas exigem `administrator` ou `manager`. Cadastros públicos recebem o papel `client`; não aceite o papel enviado pelo navegador como autoridade.

Autentique-se na API para receber um token:

```http
POST /api/v1/login
Content-Type: application/json

{"email":"admin@example.com","password":"password","device_name":"meu-cliente"}
```

Envie `Authorization: Bearer <token>` para `/api/v1/users`, `/products`, `/categories`, `/clients`, `/suppliers`, `/employees`, `/departments` e `/orders`. Os recursos oferecem operações de listagem, detalhe, criação, atualização e exclusão. Encerre o token em `POST /api/v1/logout`.

## Como adicionar um CRUD

1. Crie a migration, o model e uma factory; defina `$fillable`, casts e relações no model.
2. Crie um `FormRequest` com autorização, regras e mensagens em português.
3. Crie um controller que estenda `App\Http\Controllers\Admin\CrudController` e configure `$modelClass`, `$resource`, `$title`, `$fields`, `$relations`, `$searchColumns` e `$filterColumns`. Consulte `ProductController` para campos com opções, relações e upload.
4. Registre o controller no mapa de recursos dentro do grupo autenticado de `routes/web.php`; a tabela e o formulário genéricos são reutilizados automaticamente.
5. Inclua a rota na navegação em `resources/views/partials/sidebar.blade.php`, adicione factory/seeder e escreva testes.

Para regras de domínio específicas, sobrescreva `createRecord`, `updateRecord` ou `syncRelations`, ou mova a operação para um Service. Não concentre regras de negócio complexas na view ou na rota.

## Eloquent e organização

Relacionamentos de exemplo: `Category::products()` / `Product::category()`, `Supplier::products()`, `Client::orders()`, `Department::employees()`, `User::profile()` e o muitos-para-muitos `Order::products()` usando `order_items`.

```php
Product::with(['category', 'supplier'])->where('status', 'active')->latest()->paginate(15);
Client::whereHas('orders', fn ($query) => $query->where('status', 'completed'))->get();
$order->load('client', 'products');
Order::whereBetween('ordered_at', [now()->startOfMonth(), now()])->sum('total');
```

- `app/Http/Controllers`: endpoints web e API.
- `app/Http/Requests`: validação de entrada.
- `app/Models`: Eloquent e relações.
- `app/Repositories`: consultas reutilizáveis por módulo.
- `app/Services`: autenticação, uploads, dashboard e operações de domínio.
- `app/Support/helpers.php`: helpers carregados pelo Composer.
- `database/migrations`, `database/factories`, `database/seeders`: estrutura e dados.
- `resources/views/components`: componentes Blade compartilhados.

Mantenha migrations pequenas, use `with()` para evitar N+1, autorize cada operação sensível e prefira Form Requests para regras específicas do módulo.

## Validação

```sh
php artisan test
php artisan route:list
php artisan migrate:fresh --seed
```
