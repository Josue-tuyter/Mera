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
        Schema::create('estados', function (Blueprint $table) {
            $table->id();
            // Nombre del estado (pendiente, en_proceso, completado, etc.)
            $table->string('nombre');

            // Descripción opcional del estado
            $table->text('descripcion')->nullable();

            // Porcentaje de avance típico o asociado al estado (0-100)
            $table->unsignedTinyInteger('porcentaje_avance')->default(0);

            // Color o etiqueta para UI
            $table->string('color')->nullable();

            // Relación con organización (puede ser global o específica por organización)
            $table->unsignedBigInteger('organizacion_id')->nullable();
            $table->index('organizacion_id');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estados');
    }
};
