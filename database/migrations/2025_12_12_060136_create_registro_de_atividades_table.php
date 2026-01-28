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

            $table->date('fecha');
            $table->time('hora')->nullable();
            $table->string('tipo_actividad');
            $table->text('descripcion')->nullable();
            $table->integer('duracion_minutos')->nullable();

            $table->foreignId('encargado_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->unsignedBigInteger('organizacion_id')->nullable();
            $table->unsignedBigInteger('estado_id')->nullable();

            $table->string('parcela')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('fecha');
            $table->index('tipo_actividad');
            $table->index('organizacion_id');
            $table->index('estado_id');
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
