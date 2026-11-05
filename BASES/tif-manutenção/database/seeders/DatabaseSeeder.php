<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Categoria;
use App\Models\Local;
use App\Models\Prioridade;
use Illuminate\Support\Facades\Hash;
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
        foreach (['Elétrica', 'Hidráulica', 'Estrutura', 'Equipamentos', 'Informática', 'Mobiliário', 'Limpeza', 'Outros'] as $nome) {
            Categoria::firstOrCreate(['nome' => $nome]);
        }
        foreach ([['Nível 1', '#198754', true], ['Nível 2', '#ffc107', true], ['Nível 3', '#dc3545', true]] as [$nome, $cor, $led]) {
            Prioridade::updateOrCreate(['nome' => $nome], ['cor' => $cor, 'led' => $led]);
        }
        foreach ([['Bloco A', 'A', 'Térreo'], ['Laboratório de Informática', 'B', '1º andar'], ['Oficina de Manutenção', 'C', 'Térreo']] as [$nome, $bloco, $andar]) {
            Local::firstOrCreate(['nome' => $nome], ['bloco' => $bloco, 'andar' => $andar]);
        }
        User::updateOrCreate(['email' => 'admin@sesi.local'], ['name' => 'Administrador', 'password' => Hash::make('password'), 'tipo' => 'Administrador']);
        User::updateOrCreate(['email' => 'manutencao@sesi.local'], ['name' => 'Equipe de Manutenção', 'password' => Hash::make('password'), 'tipo' => 'Manutenção']);
        User::updateOrCreate(['email' => 'aluno@sesi.local'], ['name' => 'Aluno Exemplo', 'password' => Hash::make('password'), 'tipo' => 'Aluno']);
    }
}
