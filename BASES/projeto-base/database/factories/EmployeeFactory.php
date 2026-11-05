<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Employee> */
class EmployeeFactory extends Factory
{
    public function definition(): array
    {
        return ['department_id' => Department::factory(), 'name' => fake()->name(), 'email' => fake()->unique()->safeEmail(), 'phone' => fake()->phoneNumber(), 'position' => fake()->jobTitle(), 'hired_at' => fake()->date(), 'status' => 'active'];
    }
}
