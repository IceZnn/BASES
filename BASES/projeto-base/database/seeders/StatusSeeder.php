<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            'user' => ['active' => 'Ativo', 'inactive' => 'Inativo'],
            'product' => ['active' => 'Ativo', 'inactive' => 'Inativo'],
            'client' => ['active' => 'Ativo', 'inactive' => 'Inativo'],
            'supplier' => ['active' => 'Ativo', 'inactive' => 'Inativo'],
            'department' => ['active' => 'Ativo', 'inactive' => 'Inativo'],
            'employee' => ['active' => 'Ativo', 'inactive' => 'Inativo'],
            'order' => [
                'pending' => 'Pendente',
                'processing' => 'Em processamento',
                'completed' => 'Concluído',
                'cancelled' => 'Cancelado',
            ],
            'category' => ['1' => 'Ativa', '0' => 'Inativa'],
        ];

        foreach ($statuses as $group => $options) {
            foreach ($options as $name => $label) {
                Status::query()->updateOrCreate(
                    ['group' => $group, 'name' => (string) $name],
                    ['label' => $label],
                );
            }
        }
    }
}
