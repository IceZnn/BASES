<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('locais', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('bloco')->nullable();
            $table->string('andar')->nullable();
            $table->text('descricao')->nullable();
            $table->timestamps();
        });

        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->timestamps();
        });

        Schema::create('prioridades', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('cor', 20);
            $table->boolean('led')->default(false);
            $table->timestamps();
        });

        Schema::create('chamados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users');
            $table->foreignId('local_id')->constrained('locais');
            $table->foreignId('categoria_id')->constrained('categorias');
            $table->foreignId('prioridade_id')->constrained('prioridades');
            $table->string('titulo');
            $table->text('descricao');
            $table->string('foto')->nullable();
            $table->enum('status', ['Pendente', 'Em atendimento', 'Resolvido'])->default('Pendente');
            $table->timestamp('data_abertura')->useCurrent();
            $table->timestamp('data_conclusao')->nullable();
            $table->timestamps();
        });

        Schema::create('historicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chamado_id')->constrained('chamados')->cascadeOnDelete();
            $table->foreignId('usuario_id')->constrained('users');
            $table->text('observacao');
            $table->timestamp('data')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historicos');
        Schema::dropIfExists('chamados');
        Schema::dropIfExists('prioridades');
        Schema::dropIfExists('categorias');
        Schema::dropIfExists('locais');
    }
};