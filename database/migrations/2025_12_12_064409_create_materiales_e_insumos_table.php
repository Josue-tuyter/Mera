<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materiales_e_insumos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('categoria'); // Poda, Deshierba, Fertilización, etc.
            $table->string('tipo');      // Herramienta, Insumo Químico, EPP, etc.
            $table->text('descripcion')->nullable();
            
            // Inventario
            $table->decimal('stock', 10, 2)->default(0);
            $table->string('unidad'); // Unidad, Kg, Litros, etc.
            $table->decimal('stock_minimo', 10, 2)->default(0);
            
            // Logística
            $table->string('proveedor')->nullable();
            $table->date('fecha_vencimiento')->nullable();
            $table->foreignId('responsable_id')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materiales_e_insumos');
    }
};