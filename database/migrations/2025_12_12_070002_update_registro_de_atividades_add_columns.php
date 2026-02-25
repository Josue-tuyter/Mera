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
        if (! Schema::hasTable('registro_de_atividades')) {
            return;
        }

        Schema::table('registro_de_atividades', function (Blueprint $table) {
            if (! Schema::hasColumn('registro_de_atividades', 'fecha')) {
                $table->date('fecha')->nullable();
            }
            if (! Schema::hasColumn('registro_de_atividades', 'hora')) {
                $table->time('hora')->nullable();
            }
            if (! Schema::hasColumn('registro_de_atividades', 'tipo_actividad')) {
                $table->string('tipo_actividad')->nullable();
            }
            if (! Schema::hasColumn('registro_de_atividades', 'descripcion')) {
                $table->text('descripcion')->nullable();
            }
            // if (! Schema::hasColumn('registro_de_atividades', 'duracion_minutos')) {
            //     $table->integer('duracion_minutos')->nullable();
            // }
            $table->time('hora_inicio')->default('07:00');
            $table->time('hora_fin')->default('08:00');
            if (! Schema::hasColumn('registro_de_atividades', 'materiales_usados')) {
                $table->text('materiales_usados')->nullable();
            }
            if (! Schema::hasColumn('registro_de_atividades', 'producto_aplicado')) {
                $table->string('producto_aplicado')->nullable();
            }
            if (! Schema::hasColumn('registro_de_atividades', 'cantidad_producto')) {
                $table->decimal('cantidad_producto', 10, 2)->nullable();
            }
            if (! Schema::hasColumn('registro_de_atividades', 'unidad')) {
                $table->string('unidad')->nullable();
            }
            if (! Schema::hasColumn('registro_de_atividades', 'encargado_id')) {
                $table->foreignId('encargado_id')->nullable()->constrained('users')->nullOnDelete();
            }
            if (! Schema::hasColumn('registro_de_atividades', 'organizacion_id')) {
                $table->unsignedBigInteger('organizacion_id')->nullable();
            }
            if (! Schema::hasColumn('registro_de_atividades', 'estado_id')) {
                $table->unsignedBigInteger('estado_id')->nullable();
            }
            if (! Schema::hasColumn('registro_de_atividades', 'parcela')) {
                $table->string('parcela')->nullable();
            }
            if (! Schema::hasColumn('registro_de_atividades', 'deleted_at')) {
                $table->softDeletes();
            }
            // Indexes handled in the main create migration
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('registro_de_atividades')) {
            return;
        }

        Schema::table('registro_de_atividades', function (Blueprint $table) {
            // We won't drop columns on rollback to avoid data loss; optional to implement.
        });
    }
};
