<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cambios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ordenador_id')->constrained('ordenadores');
            $table->foreignId('origen_id')->constrained('aulas');
            $table->foreignId('destino_id')->constrained('aulas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cambios');
    }
};
