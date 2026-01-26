<?php

namespace App\Pdf;

use App\Models\DatosGenerales;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;

abstract class BaseReportePdf
{
    protected string $titulo;
    protected ?DatosGenerales $datosGenerales;

    public function __construct(string $titulo)
    {
        $this->titulo = $titulo;
        $this->datosGenerales = DatosGenerales::first();
    }

    /**
     * Vista Blade obligatoria
     */
    abstract protected function view(): string;

    /**
     * Datos específicos del PDF
     */
    abstract protected function data(): array;

    /**
     * Datos comunes para todos los PDFs
     */
    protected function baseData(): array
    {
        return [
            'titulo' => $this->titulo,
            'nombreFinca' => $this->datosGenerales?->nombre_finca ?? 'FINCA',
            'propietario' => $this->datosGenerales?->propietario ?? '---',
            'fechaExportacion' => Carbon::now(config('app.timezone'))->format('d/m/Y'),
            'logoPath' => public_path('images/logo.png'),
        ];
    }

    /**
     * Descargar PDF
     */
    public function download(string $filename)
    {
        return Pdf::loadView(
            $this->view(),
            array_merge($this->data(), $this->baseData())
        )
        ->setPaper('a4', 'landscape')
        ->download($filename);
    }

    /**
     * Mostrar PDF en navegador
     */
    public function stream(string $filename)
    {
        return Pdf::loadView(
            $this->view(),
            array_merge($this->data(), $this->baseData())
        )
        ->setPaper('a4', 'landscape')
        ->stream($filename);
    }
}
