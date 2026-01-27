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
     * Convierte valores a UTF-8 válido
     */
    protected function utf8($value): string
    {
        if ($value === null) {
            return '';
        }

        $value = (string) $value;

        // If empty, return empty
        if ($value === '') {
            return '';
        }

        // If already valid UTF-8, return as-is
        if (mb_check_encoding($value, 'UTF-8')) {
            return $value;
        }

        // Try ISO-8859-1 first (most common in older systems)
        $utf8 = @iconv('ISO-8859-1', 'UTF-8//IGNORE', $value);
        if ($utf8) {
            return $utf8;
        }

        // Try Windows-1252
        $utf8 = @iconv('Windows-1252', 'UTF-8//IGNORE', $value);
        if ($utf8) {
            return $utf8;
        }

        // Fallback: force UTF-8 with mb_convert_encoding
        return mb_convert_encoding($value, 'UTF-8', 'UTF-8, ISO-8859-1, Windows-1252');
    }

    /**
     * Datos comunes para todos los PDFs
     */
    protected function baseData(): array
    {
        return [
            'titulo' => $this->utf8($this->titulo),
            'nombreFinca' => $this->utf8($this->datosGenerales?->nombre_finca ?? 'FINCA'),
            'propietario' => $this->utf8($this->datosGenerales?->propietario ?? '---'),
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
