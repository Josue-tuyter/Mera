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
        Schema::create('registro_de_atividades', function (Blueprint $table) {
            $table->id();
            // Fecha y hora de la actividad
            $table->date('fecha');
            $table->time('hora')->nullable();

            // Tipo de actividad: poda, fertilización, riego, control de plagas, etc.
            $table->string('tipo_actividad');

            // Descripción detallada de la tarea realizada
            $table->text('descripcion')->nullable();

            // Duración en minutos (si aplica)
            $table->integer('duracion_minutos')->nullable();

            // Materiales o insumos usados (texto libre)
            $table->text('materiales_usados')->nullable();

            // Producto aplicado (ej. fertilizante, plaguicida) y cantidad
            $table->string('producto_aplicado')->nullable();
            $table->decimal('cantidad_producto', 10, 2)->nullable();
            $table->string('unidad')->nullable();

            // Costo estimado o real de la actividad
            $table->decimal('costo', 10, 2)->nullable();

            // Referencia al usuario/operario responsable (opcional)
            $table->foreignId('encargado_id')->nullable()->constrained('users')->nullOnDelete();

            // Identificador de la parcela, lote o ubicación dentro de la finca
            $table->string('parcela')->nullable();

            // Fecha prevista para la próxima actividad relacionada (si aplica)
            $table->date('proxima_fecha')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Índices para búsquedas frecuentes
            $table->index('fecha');
            $table->index('tipo_actividad');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_de_atividades');
    }
};
