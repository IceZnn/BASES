<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('doce_id');
            $table->integer('quantidade');
            $table->integer('total');
            $table->string('tracking_status');
            $table->string('tracking_code');
            $table->timestamps();

            // sem FK para não exigir alterações em cascata/keys agora
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('compras');
    }
};

