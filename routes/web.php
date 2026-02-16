<?php

use Illuminate\Support\Facades\Route;
use App\Pdf\RegistroAtividadesPdf;
use App\Pdf\EquiposYHerramientasPdf;
use App\Pdf\MaterialesEInsumosPdf;
use App\Pdf\UsuariosPdf;
use Illuminate\Support\Facades\Artisan;




    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/historia', function () {
        return view('historia');
    });

    Route::get('/metodos', function () {
        return view('metodos');
    });

        // PDF Routes
        //actividades pdf
        Route::get('/pdf/actividades', function () {
            return (new RegistroAtividadesPdf(
                request('inicio'),
                request('fin')
            ))->download('reporte_actividades.pdf');
        })->name('pdf.actividades');
        //equipos pdf
        Route::get('/pdf/equipos', function () {
            return (new EquiposYHerramientasPdf())
                ->download('reporte_equipos.pdf');
        })->name('pdf.equipos');
        //insumos pdf
        Route::get('/pdf/insumos', function () {
            return (new MaterialesEInsumosPdf())
                ->download('reporte_insumos.pdf');
        })->name('pdf.insumos');
        //usuarios pdf
        Route::get('/pdf/usuarios', function () {
            return (new UsuariosPdf())
                ->download('reporte_usuarios.pdf');
        })->name('pdf.usuarios');

// Ruta para forzar la ejecución del comando de mantenimiento manualmente
        Route::get('/forzar-mantenimiento', function () {
            // Esto ejecuta manualmente lo que el Cron Job haría automáticamente
            Artisan::call('schedule:run');
            return "✅ Se ha ejecutado el comando de mantenimiento. Revisa tu correo y el log.";
        });
        
        
