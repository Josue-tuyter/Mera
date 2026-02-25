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
        Schema::create('equipos_y_herramientas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('descripcion')->nullable();
            $table->string('serial')->nullable();
            $table->boolean('disponible')->default(true);
            $table->date('fecha_ultimo_mantenimiento')->nullable();
            //$table->date('proximo_mantenimiento')->nullable();
            $table->unsignedInteger('intervalo_mantenimiento_dias')->nullable();
            $table->string('ubicacion')->nullable();
            $table->foreignId('responsable_id')->nullable()->constrained('users')->nullOnDelete();
            $table->decimal('costo_mantenimiento_estimado', 10, 2)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipos_y_herramientas');
    }
};
