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
        Schema::create('organizacions', function (Blueprint $table) {
            $table->id();
            // Nombre de la organización / unidad de gestión
            $table->string('nombre');

            // Descripción u objetivo de la organización
            $table->text('descripcion')->nullable();

            // Responsable o administrador de la organización
            $table->foreignId('responsable_id')->nullable()->constrained('users')->nullOnDelete();

            // Fecha de inicio y fin de la planificación/periodo
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();

            // Campo para metas u objetivos de las actividades planificadas
            $table->text('objetivo')->nullable();

            // Indicador de activo/inactivo para la organización
            $table->boolean('activo')->default(true);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizacions');
    }
};
