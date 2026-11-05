<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            'administrator' => 'Administrador',
            'manager' => 'Gerente',
            'employee' => 'Funcionário',
            'client' => 'Cliente',
            'operator' => 'Operador',
        ] as $name => $label) {
            Role::query()->updateOrCreate(['name' => $name], ['label' => $label]);
        }
    }
}
