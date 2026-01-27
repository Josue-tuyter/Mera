<?php

use Illuminate\Support\Facades\Route;
use App\Pdf\RegistroAtividadesPdf;
use App\Pdf\EquiposYHerramientasPdf;
use App\Pdf\MaterialesEInsumosPdf;
use App\Pdf\UsuariosPdf;
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