<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Client;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Order;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(StatusSeeder::class);

        $admin = User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@example.com',
            'password' => 'password',
            'role' => 'administrator',
        ]);
        $admin->profile()->create(['bio' => 'Conta de demonstração do boilerplate.']);

        User::factory(12)->create();
        $categories = Category::factory(5)->create();
        $suppliers = Supplier::factory(4)->create();
        $clients = Client::factory(10)->create();
        $departments = Department::factory(4)->create();
        Employee::factory(12)->create(['department_id' => $departments->random()->id]);
        $products = Product::factory(30)->make(['category_id' => null, 'supplier_id' => null])->each(function (Product $product) use ($categories, $suppliers): void {
            $product->category()->associate($categories->random());
            $product->supplier()->associate($suppliers->random());
            $product->save();
        });

        foreach (range(1, 12) as $index) {
            $order = Order::create([
                'client_id' => $clients->random()->id,
                'user_id' => $admin->id,
                'status' => fake()->randomElement(['pending', 'processing', 'completed']),
                'notes' => fake()->optional()->sentence(),
            ]);
            $items = $products->random(fake()->numberBetween(1, 3));
            $order->products()->attach($items->mapWithKeys(fn (Product $product) => [
                $product->id => ['quantity' => 1, 'unit_price' => $product->price],
            ]));
            $order->update(['total' => $items->sum('price')]);
        }
    }
}
