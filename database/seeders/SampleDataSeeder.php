<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SampleDataSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Crear una organización central para los datos de ejemplo
        $startDate = Carbon::create(2025, 11, 1);
        $today = Carbon::today();

        $orgId = DB::table('organizacions')->insertGetId([
            'nombre' => 'Finca Los Mera',
            'descripcion' => 'Finca experimental',
            'responsable_id' => 1,
            'fecha_inicio' => $startDate,
            'fecha_fin' => null,
            'objetivo' => 'Produccion sostenible',
            'activo' => true,
            'created_at' => $startDate,
            'updated_at' => $startDate,
        ]);

        // Estados base
        $estadoPendiente = DB::table('estados')->insertGetId([
            'nombre' => 'Pendiente', 'descripcion' => 'No iniciado', 'porcentaje_avance' => 0, 'color' => '#f59e0b', 'organizacion_id' => $orgId, 'created_at' => $startDate, 'updated_at' => $startDate,
        ]);
        $estadoEnCurso = DB::table('estados')->insertGetId([
            'nombre' => 'En curso', 'descripcion' => 'En ejecucion', 'porcentaje_avance' => 50, 'color' => '#3b82f6', 'organizacion_id' => $orgId, 'created_at' => $startDate, 'updated_at' => $startDate,
        ]);
        $estadoCompleto = DB::table('estados')->insertGetId([
            'nombre' => 'Completado', 'descripcion' => 'Finalizado', 'porcentaje_avance' => 100, 'color' => '#10b981', 'organizacion_id' => $orgId, 'created_at' => $startDate, 'updated_at' => $startDate,
        ]);

        // Crear algunos materiales y equipos iniciales (más variedad)
        $materials = [];
        $materials[] = DB::table('materiales_e_insumos')->insertGetId([
            'nombre' => 'Fertilizante A', 'descripcion' => 'NPK 10-10-10', 'stock' => 200, 'unidad' => 'kg', 'stock_minimo' => 10, 'proveedor' => 'Proveedor X', 'lote' => 'L001', 'fecha_vencimiento' => $startDate->copy()->addYears(1), 'responsable_id' => 1, 'created_at' => $startDate, 'updated_at' => $startDate,
        ]);
        $materials[] = DB::table('materiales_e_insumos')->insertGetId([
            'nombre' => 'Insecticida B', 'descripcion' => 'Formulado', 'stock' => 80, 'unidad' => 'L', 'stock_minimo' => 5, 'proveedor' => 'Proveedor Y', 'lote' => 'L002', 'fecha_vencimiento' => $startDate->copy()->addMonths(9), 'responsable_id' => 1, 'created_at' => $startDate, 'updated_at' => $startDate,
        ]);
        $materials[] = DB::table('materiales_e_insumos')->insertGetId([
            'nombre' => 'Malla para sombra', 'descripcion' => 'Malla 50%', 'stock' => 30, 'unidad' => 'u', 'stock_minimo' => 1, 'proveedor' => 'Proveedor Z', 'lote' => 'L003', 'fecha_vencimiento' => null, 'responsable_id' => 1, 'created_at' => $startDate, 'updated_at' => $startDate,
        ]);
        $materials[] = DB::table('materiales_e_insumos')->insertGetId([
            'nombre' => 'Abono Orgánico', 'descripcion' => 'Compost estabilizado', 'stock' => 120, 'unidad' => 'kg', 'stock_minimo' => 5, 'proveedor' => 'Cooperativa Local', 'lote' => 'L004', 'fecha_vencimiento' => null, 'responsable_id' => 1, 'created_at' => $startDate, 'updated_at' => $startDate,
        ]);
        $materials[] = DB::table('materiales_e_insumos')->insertGetId([
            'nombre' => 'Herbicida C', 'descripcion' => 'Selectivo', 'stock' => 40, 'unidad' => 'L', 'stock_minimo' => 3, 'proveedor' => 'Proveedor Y', 'lote' => 'L005', 'fecha_vencimiento' => $startDate->copy()->addMonths(18), 'responsable_id' => 1, 'created_at' => $startDate, 'updated_at' => $startDate,
        ]);
        $materials[] = DB::table('materiales_e_insumos')->insertGetId([
            'nombre' => 'Cinta de riego', 'descripcion' => 'Cinta por goteo 100m', 'stock' => 25, 'unidad' => 'u', 'stock_minimo' => 1, 'proveedor' => 'Proveedor Z', 'lote' => 'L006', 'fecha_vencimiento' => null, 'responsable_id' => 1, 'created_at' => $startDate, 'updated_at' => $startDate,
        ]);
        $materials[] = DB::table('materiales_e_insumos')->insertGetId([
            'nombre' => 'Guantes de trabajo', 'descripcion' => 'Par de guantes reforzados', 'stock' => 60, 'unidad' => 'par', 'stock_minimo' => 5, 'proveedor' => 'Tienda Agro', 'lote' => 'L007', 'fecha_vencimiento' => null, 'responsable_id' => 1, 'created_at' => $startDate, 'updated_at' => $startDate,
        ]);

        $equipos = [];
        $equipos[] = DB::table('equipos_y_herramientas')->insertGetId([
            'nombre' => 'Machete', 'descripcion' => 'Machete de mano', 'serial' => 'MH-001', 'disponible' => true, 'fecha_ultimo_mantenimiento' => $startDate->copy()->subMonths(3), 'proximo_mantenimiento' => $startDate->copy()->addMonths(9), 'intervalo_mantenimiento_dias' => 365, 'ubicacion' => 'Bodega', 'responsable_id' => 1, 'costo_mantenimiento_estimado' => 0, 'created_at' => $startDate, 'updated_at' => $startDate,
        ]);
        $equipos[] = DB::table('equipos_y_herramientas')->insertGetId([
            'nombre' => 'Pulverizador', 'descripcion' => 'Pulverizador motorizado', 'serial' => 'PM-010', 'disponible' => true, 'fecha_ultimo_mantenimiento' => $startDate->copy()->subMonths(1), 'proximo_mantenimiento' => $startDate->copy()->addMonths(11), 'intervalo_mantenimiento_dias' => 365, 'ubicacion' => 'Taller', 'responsable_id' => 1, 'costo_mantenimiento_estimado' => 50, 'created_at' => $startDate, 'updated_at' => $startDate,
        ]);
        $equipos[] = DB::table('equipos_y_herramientas')->insertGetId([
            'nombre' => 'Carretilla', 'descripcion' => 'Carretilla de carga', 'serial' => 'CR-002', 'disponible' => true, 'fecha_ultimo_mantenimiento' => $startDate->copy()->subMonths(6), 'proximo_mantenimiento' => $startDate->copy()->addMonths(6), 'intervalo_mantenimiento_dias' => 180, 'ubicacion' => 'Bodega', 'responsable_id' => 1, 'costo_mantenimiento_estimado' => 10, 'created_at' => $startDate, 'updated_at' => $startDate,
        ]);
        $equipos[] = DB::table('equipos_y_herramientas')->insertGetId([
            'nombre' => 'Motosierra', 'descripcion' => 'Motosierra de poda', 'serial' => 'MS-005', 'disponible' => true, 'fecha_ultimo_mantenimiento' => $startDate->copy()->subMonths(2), 'proximo_mantenimiento' => $startDate->copy()->addMonths(10), 'intervalo_mantenimiento_dias' => 365, 'ubicacion' => 'Taller', 'responsable_id' => 1, 'costo_mantenimiento_estimado' => 75, 'created_at' => $startDate, 'updated_at' => $startDate,
        ]);
        $equipos[] = DB::table('equipos_y_herramientas')->insertGetId([
            'nombre' => 'Bomba de agua', 'descripcion' => 'Bomba centrífuga para riego', 'serial' => 'BW-011', 'disponible' => true, 'fecha_ultimo_mantenimiento' => $startDate->copy()->subMonths(4), 'proximo_mantenimiento' => $startDate->copy()->addMonths(8), 'intervalo_mantenimiento_dias' => 365, 'ubicacion' => 'Estación de riego', 'responsable_id' => 1, 'costo_mantenimiento_estimado' => 120, 'created_at' => $startDate, 'updated_at' => $startDate,
        ]);

        // Tipos y parcelas para generar registros de forma secuencial y lógica
        $tipos = ['riego', 'poda', 'fertilizacion', 'control_plagas', 'inspeccion'];
        $parcelas = ['A', 'B', 'C', 'D'];

        // Generar registros por día en el rango solicitado
        $cursor = $startDate->copy();
        $registroIndex = 0;
        while ($cursor->lte($today)) {
            // crear 1-2 registros por día de forma determinista (alternando)
            $perDay = ($registroIndex % 2) + 1; // 1,2,1,2...

            for ($j = 0; $j < $perDay; $j++) {
                $tipo = $tipos[($registroIndex + $j) % count($tipos)];
                $parcela = $parcelas[($registroIndex + $j) % count($parcelas)];

                // horarios ordenados: 07:00, 08:30, 10:00
                $horaMap = ['07:00:00', '08:30:00', '10:00:00'];
                $hora = $horaMap[$j % count($horaMap)];

                // duración por tipo (valores lógicos)
                $durMap = ['riego' => 60, 'poda' => 45, 'fertilizacion' => 120, 'control_plagas' => 90, 'inspeccion' => 30];
                $dur = $durMap[$tipo] ?? 30;

                $descripcion = ucfirst($tipo) . " programado en parcela {$parcela}";

                $registroId = DB::table('registro_de_atividades')->insertGetId([
                    'fecha' => $cursor->toDateString(),
                    'hora' => $hora,
                    'tipo_actividad' => $tipo,
                    'descripcion' => $descripcion,
                    'duracion_minutos' => $dur,
                    'materiales_usados' => null,
                    'producto_aplicado' => in_array($tipo, ['fertilizacion', 'control_plagas']) ? ($tipo === 'fertilizacion' ? 'Fertilizante A' : 'Insecticida B') : null,
                    'cantidad_producto' => in_array($tipo, ['fertilizacion', 'control_plagas']) ? ($tipo === 'fertilizacion' ? 5 : 2) : null,
                    'unidad' => in_array($tipo, ['fertilizacion', 'control_plagas']) ? ($tipo === 'fertilizacion' ? 'kg' : 'L') : null,
                    'encargado_id' => 1,
                    'organizacion_id' => $orgId,
                    'estado_id' => ($registroIndex % 3 == 0) ? $estadoPendiente : (($registroIndex % 3 == 1) ? $estadoEnCurso : $estadoCompleto),
                    'parcela' => $parcela,
                    'created_at' => $cursor->toDateString() . ' ' . $hora,
                    'updated_at' => $cursor->toDateString() . ' ' . $hora,
                ]);

                // Asociar material/equipo cuando aplique
                if (in_array($tipo, ['fertilizacion', 'control_plagas'])) {
                    $matId = $materials[($registroIndex + $j) % count($materials)];
                    DB::table('registro_actividad_material')->insert([
                        'registro_id' => $registroId,
                        'material_id' => $matId,
                        'cantidad_usada' => ($tipo === 'fertilizacion') ? 5 : 2,
                        'unidad' => ($tipo === 'fertilizacion') ? 'kg' : 'L',
                        'created_at' => $cursor->toDateString() . ' ' . $hora,
                        'updated_at' => $cursor->toDateString() . ' ' . $hora,
                    ]);
                }

                // Asociar un equipo (rotativo)
                $eqId = $equipos[($registroIndex + $j) % count($equipos)];
                DB::table('registro_actividad_equipo')->insert([
                    'registro_id' => $registroId,
                    'equipo_id' => $eqId,
                    'nota' => 'Uso en tarea',
                    'created_at' => $cursor->toDateString() . ' ' . $hora,
                    'updated_at' => $cursor->toDateString() . ' ' . $hora,
                ]);
            }

            $registroIndex++;
            $cursor->addDay();
        }
    }
}
