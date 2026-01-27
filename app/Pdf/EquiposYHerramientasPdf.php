<?php

namespace App\Pdf;

use App\Models\EquiposYHerramienta;

class EquiposYHerramientasPdf extends BaseReportePdf
{
    public function __construct()
    {
        parent::__construct('Reporte de Equipos y Herramientas');
    }

    protected function view(): string
    {
        return 'pdf.equipos';
    }

    protected function data(): array
    {
        $equipos = EquiposYHerramienta::with('responsable')
            ->orderBy('nombre')
            ->get()
            ->map(function ($equipo) {

                $equipo->nombre = $this->utf8($equipo->nombre);
                $equipo->serial = $this->utf8($equipo->serial);
                $equipo->ubicacion = $this->utf8($equipo->ubicacion);
                $equipo->descripcion = $this->utf8($equipo->descripcion);

                if ($equipo->responsable) {
                    $equipo->responsable->name = $this->utf8($equipo->responsable->name);
                    $equipo->responsable->email = $this->utf8($equipo->responsable->email);
                }

                return $equipo;
            });

        return [
            'equipos' => $equipos,
        ];
    }
}
