<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Client;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Order;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Role;
use App\Models\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BoilerplateTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RoleSeeder::class);
        $this->seed(\Database\Seeders\StatusSeeder::class);
    }

    public function test_landing_page_and_login_work(): void
    {
        $this->get(route('home'))->assertOk()->assertSee('Uma base sólida');

        $user = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make('secret-password'),
            'role' => 'administrator',
        ]);

        $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'secret-password',
        ])->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($user);
        $this->get(route('dashboard'))->assertOk()->assertSee('Dashboard');
    }

    public function test_inactive_accounts_cannot_log_in(): void
    {
        User::factory()->create([
            'email' => 'inactive@example.com',
            'password' => Hash::make('secret-password'),
            'status' => 'inactive',
        ]);

        $this->post(route('login.store'), [
            'email' => 'inactive@example.com',
            'password' => 'secret-password',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_registration_hashes_password_and_assigns_client_role(): void
    {
        $this->post(route('register.store'), [
            'name' => 'Nova Pessoa',
            'email' => 'nova@example.com',
            'password' => 'a-strong-password',
            'password_confirmation' => 'a-strong-password',
        ])->assertRedirect(route('dashboard'));

        $user = User::where('email', 'nova@example.com')->firstOrFail();
        $this->assertTrue(Hash::check('a-strong-password', $user->password));
        $this->assertSame('client', $user->role);
        $this->assertDatabaseHas('profiles', ['user_id' => $user->id]);
    }

    public function test_administrator_can_create_product_and_employee_cannot_access_admin(): void
    {
        $administrator = User::factory()->create(['role' => 'administrator']);
        $category = Category::factory()->create();
        $supplier = Supplier::factory()->create();

        $this->actingAs($administrator)->post(route('admin.products.store'), [
            'name' => 'Teclado de exemplo',
            'sku' => 'KEY-001',
            'category_id' => $category->id,
            'supplier_id' => $supplier->id,
            'price' => '149.90',
            'stock' => 12,
            'status' => 'active',
        ])->assertRedirect(route('admin.products.index'));

        $this->assertDatabaseHas('products', [
            'name' => 'Teclado de exemplo',
            'slug' => 'teclado-de-exemplo',
            'sku' => 'KEY-001',
        ]);
        $product = Product::where('sku', 'KEY-001')->firstOrFail();
        $this->actingAs($administrator)->put(route('admin.products.update', $product->id), [
            'name' => 'Teclado atualizado',
            'sku' => 'KEY-001',
            'category_id' => $category->id,
            'supplier_id' => $supplier->id,
            'price' => '159.90',
            'stock' => 14,
            'status' => 'active',
        ])->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', ['id' => $product->id, 'slug' => 'teclado-atualizado']);

        $employee = User::factory()->create(['role' => 'employee']);
        $this->actingAs($employee)->get(route('admin.products.index'))->assertForbidden();
    }

    public function test_sanctum_token_can_access_json_api(): void
    {
        $user = User::factory()->create(['role' => 'administrator']);
        $product = Product::factory()->create();

        $response = $this->postJson('/api/v1/login', [
            'email' => $user->email,
            'password' => 'password',
            'device_name' => 'feature-test',
        ])->assertOk()->assertJsonStructure(['data' => ['user', 'token'], 'message']);

        $token = $response->json('data.token');
        $this->withToken($token)->getJson('/api/v1/products')->assertOk()->assertJsonStructure([
            'data' => [['id', 'name', 'sku', 'category', 'supplier']],
            'meta' => ['current_page', 'last_page', 'total'],
        ]);
        $this->withToken($token)->getJson('/api/v1/users')->assertOk()->assertJsonStructure([
            'data' => [['role_definition', 'profile']],
            'meta' => ['current_page', 'last_page', 'total'],
        ]);
        $this->withToken($token)->patchJson('/api/v1/products/'.$product->id, [
            'name' => 'Produto pela API',
        ])->assertOk()->assertJsonPath('data.slug', 'produto-pela-api');
        $this->withToken($token)->postJson('/api/v1/orders', [
            'client_id' => Client::factory()->create()->id,
            'status' => 'pending',
            'products' => [$product->id],
        ])->assertCreated()->assertJsonPath('data.total', (string) $product->fresh()->price);
    }

    public function test_administrator_can_update_user_and_password(): void
    {
        $administrator = User::factory()->create(['role' => 'administrator']);
        $user = User::factory()->create();

        $this->actingAs($administrator)->put(route('admin.users.update', $user->id), [
            'name' => 'Nome Atualizado',
            'email' => $user->email,
            'password' => 'updated-password',
            'password_confirmation' => 'updated-password',
            'role' => 'employee',
            'status' => 'active',
        ])->assertRedirect(route('admin.users.index'));

        $this->assertSame('Nome Atualizado', $user->fresh()->name);
        $this->assertTrue(Hash::check('updated-password', $user->fresh()->password));
    }

    public function test_order_creation_syncs_products_and_stock_adjustments_cannot_go_negative(): void
    {
        $administrator = User::factory()->create(['role' => 'administrator']);
        $client = \App\Models\Client::factory()->create();
        $product = Product::factory()->create(['stock' => 2, 'price' => 125]);

        $this->actingAs($administrator)->post(route('admin.orders.store'), [
            'client_id' => $client->id,
            'status' => 'pending',
            'products' => [$product->id],
        ])->assertRedirect(route('admin.orders.index'));

        $this->assertDatabaseHas('orders', ['client_id' => $client->id, 'total' => 125]);
        $this->assertDatabaseHas('order_items', ['product_id' => $product->id, 'quantity' => 1]);

        $this->post(route('admin.stock.adjust', $product), [
            'direction' => 'decrease',
            'quantity' => 3,
        ])->assertSessionHasErrors('quantity');
        $this->assertSame(2, $product->fresh()->stock);

        $this->post(route('admin.stock.adjust', $product), [
            'direction' => 'increase',
            'quantity' => 3,
        ])->assertRedirect();
        $this->assertSame(5, $product->fresh()->stock);
    }

    public function test_product_image_is_stored_on_the_public_disk(): void
    {
        Storage::fake('public');
        $administrator = User::factory()->create(['role' => 'administrator']);

        $this->actingAs($administrator)->post(route('admin.products.store'), [
            'name' => 'Produto com foto',
            'sku' => 'IMG-001',
            'price' => 50,
            'stock' => 1,
            'status' => 'active',
            'image' => UploadedFile::fake()->create('produto.png', 10, 'image/png'),
        ])->assertRedirect(route('admin.products.index'));

        $product = Product::where('sku', 'IMG-001')->firstOrFail();
        Storage::disk('public')->assertExists($product->image);
    }

    public function test_administration_forms_dashboard_stock_notifications_and_reports_render(): void
    {
        $administrator = User::factory()->create(['role' => 'administrator']);
        Product::factory()->create();

        $this->actingAs($administrator);
        $this->get(route('dashboard'))->assertOk();
        $this->get(route('admin.products.index'))->assertOk();
        $this->get(route('admin.products.create'))->assertOk();
        $this->get(route('admin.stock.index'))->assertOk();
        $this->get(route('admin.reports.index'))->assertOk();
        $this->get(route('notifications.index'))->assertOk();
        $this->get(route('profile.edit'))->assertOk();
        $this->get(route('settings.edit'))->assertOk();
    }

    public function test_settings_are_saved_to_the_user_profile(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->put(route('settings.update'), [
            'language' => 'en',
            'theme' => 'dark',
        ])->assertRedirect();

        $this->assertSame(['language' => 'en', 'theme' => 'dark'], $user->fresh()->profile->preferences);
    }

    public function test_crud_search_filters_date_range_sort_and_relationship_details_are_database_backed(): void
    {
        $administrator = User::factory()->create(['role' => 'administrator']);
        $category = Category::factory()->create(['name' => 'Categoria dinâmica']);
        $supplier = Supplier::factory()->create();
        $product = Product::factory()->create([
            'name' => 'Produto pesquisável',
            'sku' => 'SEARCH-001',
            'category_id' => $category->id,
            'supplier_id' => $supplier->id,
            'status' => 'active',
        ]);
        $client = Client::factory()->create(['name' => 'Cliente relacionado']);
        Role::query()->where('name', 'administrator')->update(['label' => 'Administrador do banco']);
        Status::query()->where('group', 'product')->where('name', 'active')->update(['label' => 'Disponível no banco']);

        $this->actingAs($administrator);
        $this->get(route('admin.products.index', [
            'search' => 'pesquisável',
            'category_id' => $category->id,
            'status' => 'active',
            'date_from' => now()->toDateString(),
            'date_to' => now()->toDateString(),
            'sort' => 'price',
            'direction' => 'desc',
        ]))->assertOk()->assertSee('Produto pesquisável')->assertSee('Categoria dinâmica');

        $order = \App\Models\Order::factory()->create(['client_id' => $client->id, 'user_id' => $administrator->id]);
        $order->products()->attach($product, ['quantity' => 3, 'unit_price' => $product->price]);
        $order->update(['total' => 3 * $product->price]);

        $this->get(route('admin.orders.show', $order->id))
            ->assertOk()
            ->assertSee('Cliente relacionado')
            ->assertSee('Produto pesquisável')
            ->assertSee('3');

        $this->get(route('admin.clients.show', $client->id))
            ->assertOk()
            ->assertSee('Pedidos do cliente')
            ->assertSee((string) $order->id);

        $this->get(route('admin.users.create'))
            ->assertOk()
            ->assertSee('Administrador do banco');
        $this->get(route('admin.products.create'))
            ->assertOk()
            ->assertSee('Disponível no banco');
    }

    public function test_all_crud_modules_render_list_create_edit_and_detail_pages(): void
    {
        $administrator = User::factory()->create(['role' => 'administrator']);
        $category = Category::factory()->create();
        $supplier = Supplier::factory()->create();
        $client = Client::factory()->create();
        $department = Department::factory()->create();
        $employee = Employee::factory()->create(['department_id' => $department->id]);
        $product = Product::factory()->create(['category_id' => $category->id, 'supplier_id' => $supplier->id]);
        $order = Order::factory()->create(['client_id' => $client->id, 'user_id' => $administrator->id]);

        $records = [
            'users' => $administrator,
            'products' => $product,
            'categories' => $category,
            'clients' => $client,
            'suppliers' => $supplier,
            'employees' => $employee,
            'departments' => $department,
            'orders' => $order,
        ];

        $this->actingAs($administrator);
        foreach ($records as $resource => $record) {
            $this->get(route('admin.'.$resource.'.index'))->assertOk();
            $this->get(route('admin.'.$resource.'.create'))->assertOk();
            $this->get(route('admin.'.$resource.'.show', $record->id))->assertOk();
            $this->get(route('admin.'.$resource.'.edit', $record->id))->assertOk();
        }
    }
}
