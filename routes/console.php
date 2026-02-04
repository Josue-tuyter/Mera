<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\EquiposYHerramienta;
use App\Mail\MantenimientoEquipoMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Schedule::call(function () {
    $hoy = \Carbon\Carbon::today();
    $equiposParaMantenimiento = \App\Models\EquiposYHerramienta::whereDate('proximo_mantenimiento', $hoy)->get();

    // Esto escribirá en tu laravel.log para que sepas qué pasó
    \Log::info("Chequeo de mantenimiento: Se encontraron " . $equiposParaMantenimiento->count() . " equipos para la fecha " . $hoy->toDateString());

    foreach ($equiposParaMantenimiento as $equipo) {
        $destinatarios = ['josuerogelym@gmail.com', 'laboresculturales@fincalosmera.sistemaweb.me'];
        
        try {
            \Illuminate\Support\Facades\Mail::to($destinatarios)->send(new \App\Mail\MantenimientoEquipoMail($equipo));
            \Log::info("Correo enviado para el equipo: " . $equipo->nombre);
        } catch (\Exception $e) {
            \Log::error("Fallo envío mantenimiento: " . $e->getMessage());
        }
    }
})->dailyAt('07:00');