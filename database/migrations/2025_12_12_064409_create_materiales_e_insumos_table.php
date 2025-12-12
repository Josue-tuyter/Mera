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
        Schema::create('materiales_e_insumos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->decimal('stock', 10, 2)->default(0);
            $table->string('unidad')->nullable();
            $table->decimal('stock_minimo', 10, 2)->nullable();
            $table->string('proveedor')->nullable();
            $table->string('lote')->nullable();
            $table->date('fecha_vencimiento')->nullable();
            $table->foreignId('responsable_id')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materiales_e_insumos');
    }
};
