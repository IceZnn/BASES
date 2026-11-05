<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Order> */
class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'client_id' => Client::factory(),
            'user_id' => User::factory(),
            'status' => fake()->randomElement(['pending', 'processing', 'completed', 'cancelled']),
            'total' => fake()->randomFloat(2, 0, 5000),
            'notes' => fake()->optional()->sentence(),
            'ordered_at' => fake()->dateTimeBetween('-6 months'),
        ];
    }
}
