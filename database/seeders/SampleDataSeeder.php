<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class SampleDataSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Organizacions
        $orgId = DB::table('organizacions')->insertGetId([
            'nombre' => 'Finca Los Mera',
            'descripcion' => 'Finca experimental',
            'responsable_id' => 1,
            'fecha_inicio' => Carbon::now()->subYears(1),
            'fecha_fin' => null,
            'objetivo' => 'Produccion sostenible',
            'activo' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Estados
        $estadoPendiente = DB::table('estados')->insertGetId([
            'nombre' => 'Pendiente', 'descripcion' => 'No iniciado', 'porcentaje_avance' => 0, 'color' => '#f59e0b', 'organizacion_id' => $orgId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
        ]);
        $estadoEnCurso = DB::table('estados')->insertGetId([
            'nombre' => 'En curso', 'descripcion' => 'En ejecucion', 'porcentaje_avance' => 50, 'color' => '#3b82f6', 'organizacion_id' => $orgId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
        ]);
        $estadoCompleto = DB::table('estados')->insertGetId([
            'nombre' => 'Completado', 'descripcion' => 'Finalizado', 'porcentaje_avance' => 100, 'color' => '#10b981', 'organizacion_id' => $orgId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
        ]);

        // Materiales
        $m1 = DB::table('materiales_e_insumos')->insertGetId([
            'nombre' => 'Fertilizante A', 'descripcion' => 'NPK 10-10-10', 'stock' => 100, 'unidad' => 'kg', 'stock_minimo' => 10, 'proveedor' => 'Proveedor X', 'lote' => 'L001', 'fecha_vencimiento' => Carbon::now()->addYears(1), 'responsable_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
        ]);
        $m2 = DB::table('materiales_e_insumos')->insertGetId([
            'nombre' => 'Insecticida B', 'descripcion' => 'Formulado', 'stock' => 50, 'unidad' => 'L', 'stock_minimo' => 5, 'proveedor' => 'Proveedor Y', 'lote' => 'L002', 'fecha_vencimiento' => Carbon::now()->addMonths(6), 'responsable_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
        ]);

        // Equipos
        $e1 = DB::table('equipos_y_herramientas')->insertGetId([
            'nombre' => 'Machete', 'descripcion' => 'Machete de mano', 'serial' => 'MH-001', 'disponible' => true, 'fecha_ultimo_mantenimiento' => Carbon::now()->subMonths(3), 'proximo_mantenimiento' => Carbon::now()->addMonths(9), 'intervalo_mantenimiento_dias' => 365, 'ubicacion' => 'Bodega', 'responsable_id' => 1, 'costo_mantenimiento_estimado' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
        ]);

        $e2 = DB::table('equipos_y_herramientas')->insertGetId([
            'nombre' => 'Pulverizador', 'descripcion' => 'Pulverizador motorizado', 'serial' => 'PM-010', 'disponible' => true, 'fecha_ultimo_mantenimiento' => Carbon::now()->subMonths(1), 'proximo_mantenimiento' => Carbon::now()->addMonths(11), 'intervalo_mantenimiento_dias' => 365, 'ubicacion' => 'Taller', 'responsable_id' => 1, 'costo_mantenimiento_estimado' => 50, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
        ]);

        // Registros (actividades)
        $r1 = DB::table('registro_de_atividades')->insertGetId([
            'fecha' => Carbon::now()->subDays(10), 'hora' => '08:00:00', 'tipo_actividad' => 'riego', 'descripcion' => 'Riego del huerto A', 'duracion_minutos' => 60, 'materiales_usados' => null, 'producto_aplicado' => null, 'cantidad_producto' => null, 'unidad' => null, 'encargado_id' => 1, 'organizacion_id' => $orgId, 'estado_id' => $estadoCompleto, 'parcela' => 'A', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
        ]);

        $r2 = DB::table('registro_de_atividades')->insertGetId([
            'fecha' => Carbon::now()->subDays(5), 'hora' => '09:30:00', 'tipo_actividad' => 'control_plagas', 'descripcion' => 'Aplicacion de insecticida', 'duracion_minutos' => 90, 'materiales_usados' => null, 'producto_aplicado' => 'Insecticida B', 'cantidad_producto' => 2, 'unidad' => 'L', 'encargado_id' => 1, 'organizacion_id' => $orgId, 'estado_id' => $estadoEnCurso, 'parcela' => 'B', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
        ]);

        $r3 = DB::table('registro_de_atividades')->insertGetId([
            'fecha' => Carbon::now()->subDays(2), 'hora' => '07:30:00', 'tipo_actividad' => 'poda', 'descripcion' => 'Poda ligera', 'duracion_minutos' => 45, 'materiales_usados' => null, 'producto_aplicado' => null, 'cantidad_producto' => null, 'unidad' => null, 'encargado_id' => 1, 'organizacion_id' => $orgId, 'estado_id' => $estadoPendiente, 'parcela' => 'C', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
        ]);

        // Pivot: registro_actividad_material
        DB::table('registro_actividad_material')->insert([
            ['registro_id' => $r2, 'material_id' => $m2, 'cantidad_usada' => 2, 'unidad' => 'L', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);

        // Pivot: registro_actividad_equipo
        DB::table('registro_actividad_equipo')->insert([
            ['registro_id' => $r1, 'equipo_id' => $e1, 'nota' => 'Uso manual', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['registro_id' => $r2, 'equipo_id' => $e2, 'nota' => 'Usado en aplicacion', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
