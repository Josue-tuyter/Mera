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
        Schema::create('datos_generales', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_finca')->nullable();
            $table->string('propietario')->nullable();
            $table->decimal('area_hectareas', 8, 2)->nullable();
            $table->string('ubicacion')->nullable();
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();
            $table->string('tipo_suelo')->nullable();
            $table->string('variedad_cacao')->nullable();
            $table->integer('altitud_m')->nullable();
            $table->decimal('lluvia_media_mm', 8, 2)->nullable();
            $table->boolean('certificado_organico')->default(false);
            $table->string('contacto_email')->nullable();
            $table->string('telefono')->nullable();
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datos_generales');
    }
};
