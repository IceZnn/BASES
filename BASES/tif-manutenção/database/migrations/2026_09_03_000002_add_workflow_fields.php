<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('ativo')->default(true)->after('tipo');
            $table->softDeletes();
        });
        Schema::table('chamados', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('historicos', function (Blueprint $table) {
            $table->string('status_anterior')->nullable()->after('observacao');
            $table->string('novo_status')->nullable()->after('status_anterior');
        });
    }

    public function down(): void
    {
        Schema::table('historicos', fn (Blueprint $table) => $table->dropColumn(['status_anterior', 'novo_status']));
        Schema::table('chamados', fn (Blueprint $table) => $table->dropSoftDeletes());
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn('ativo');
        });
    }
};