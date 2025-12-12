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
        Schema::create('registro_actividad_equipo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registro_id')->constrained('registro_de_atividades')->cascadeOnDelete();
            $table->foreignId('equipo_id')->constrained('equipos_y_herramientas')->cascadeOnDelete();
            $table->string('nota')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_actividad_equipo');
    }
};
