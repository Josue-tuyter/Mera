<?php

use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\EquiposYHerramienta;
use App\Mail\MantenimientoEquipoMail;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| Este archivo es donde defines todas tus tareas programadas y comandos
| de consola personalizados. Laravel los ejecuta automáticamente según
| el horario definido aquí.
|
*/

/**
 * 1. CHEQUEO DIARIO DE MANTENIMIENTO DE EQUIPOS
 * Se ejecuta todos los días a las 07:00 AM.
 * Busca equipos cuya fecha de próximo mantenimiento sea hoy.
 */
Schedule::call(function () {
    $hoy = Carbon::today();
    $equiposParaMantenimiento = EquiposYHerramienta::whereDate('proximo_mantenimiento', $hoy)->get();

    Log::info("Chequeo de mantenimiento: Se encontraron " . $equiposParaMantenimiento->count() . " equipos para la fecha " . $hoy->toDateString());

    foreach ($equiposParaMantenimiento as $equipo) {
        $destinatarios = [
            'josuerogelym@gmail.com', 
            'laboresculturales@fincalosmera.sistemaweb.me'
        ];
        
        try {
            // Usamos queue() para que Laravel lo guarde en la tabla 'jobs'
            // Esto evita que el proceso se cuelgue si el servidor de correo es lento.
            Mail::to($destinatarios)->queue(new MantenimientoEquipoMail($equipo));
            Log::info("Correo encolado para el equipo: " . $equipo->nombre);
        } catch (\Exception $e) {
            Log::error("Error al encolar mantenimiento para {$equipo->nombre}: " . $e->getMessage());
        }
    }
})->dailyAt('07:00');

/**
 * 2. PROCESADOR DE COLAS (QUEUE WORKER)
 * Imprescindible para que funcione QUEUE_CONNECTION=database en Hostinger.
 * Se ejecuta cada minuto para enviar los correos que estén en la tabla 'jobs'.
 */
Schedule::command('queue:work --stop-when-empty')
    ->everyMinute()
    ->withoutOverlapping(); // Evita que se ejecuten dos procesos iguales al mismo tiempo