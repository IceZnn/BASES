<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('prioridades')->where('nome', 'Nível 1')->update(['cor' => '#198754']);
        DB::table('prioridades')->where('nome', 'Nível 2')->update(['cor' => '#ffc107']);
        DB::table('prioridades')->where('nome', 'Nível 3')->update(['cor' => '#dc3545']);
    }

    public function down(): void
    {
        DB::table('prioridades')->where('nome', 'Nível 1')->update(['cor' => '#dc3545']);
        DB::table('prioridades')->where('nome', 'Nível 2')->update(['cor' => '#fd7e14']);
        DB::table('prioridades')->where('nome', 'Nível 3')->update(['cor' => '#198754']);
    }
};
