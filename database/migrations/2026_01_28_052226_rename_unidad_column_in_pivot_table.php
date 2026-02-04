<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Verificamos si existe la columna antes de renombrarla para evitar errores
        if (Schema::hasColumn('registro_actividad_material', 'unidad')) {
            Schema::table('registro_actividad_material', function (Blueprint $table) {
                $table->renameColumn('unidad', 'unidad_aplicada');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('registro_actividad_material', 'unidad_aplicada')) {
            Schema::table('registro_actividad_material', function (Blueprint $table) {
                $table->renameColumn('unidad_aplicada', 'unidad');
            });
        }
    }
};