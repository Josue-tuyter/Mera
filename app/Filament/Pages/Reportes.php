<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use BackedEnum;
use UnitEnum;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Schema;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;


use Maatwebsite\Excel\Facades\Excel;

// Exports
use App\Exports\RegistroActividadesExport;
use App\Exports\EquiposYHerramientasExport;
use App\Exports\MaterialesEInsumosExport;
use App\Exports\UsuariosExport;


//pdf

use App\Pdf\{
    RegistroAtividadesPdf,
    EquiposYHerramientasPdf,
    MaterialesEInsumosPdf,
    UsuariosPdf
};  

class Reportes extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-arrow-down';
    protected static ?string $navigationLabel = 'Reportes';
    protected static string|UnitEnum|null $navigationGroup = 'Reportes';
    protected static ?string $title = 'Reportes';
    protected string $view = 'filament.pages.reportes';

    /** Estado del formulario */
    public array $data = [];

    /**
     * Formulario
     */
    public function form(Schema $form): Schema
    {
        return $form
            ->components([
                Select::make('recurso')
                    ->label('Recurso a reportar')
                    ->required()
                    ->options([
                        'actividades' => 'Registro de actividades',
                        'equipos'     => 'Equipos y herramientas',
                        'insumos'     => 'Materiales e insumos',
                        'usuarios'    => 'Usuarios',
                    ])
                    ->reactive(),

                Select::make('formato')
                    ->label('Formato')
                    ->required()
                    ->options([
                        'excel' => 'Excel',
                         'pdf' => 'PDF'
                    ]),

                DatePicker::make('fecha_inicio')
                    ->label('Desde')
                    ->visible(fn ($get) => $get('recurso') === 'actividades'),

                DatePicker::make('fecha_fin')
                    ->label('Hasta')
                    ->visible(fn ($get) => $get('recurso') === 'actividades'),
            ])
            ->statePath('data');     
                
    }
    public function generarReporte()
    {
        $data = $this->form->getState();

        if (! isset($data['formato'], $data['recurso'])) {
            return;
        }

        // ---------------------------
        // EXCEL
        // ---------------------------
        if ($data['formato'] === 'excel') {

            return match ($data['recurso']) {

                'actividades' => Excel::download(
                    new RegistroActividadesExport(
                        'Reporte de Registro de Actividades',
                        $data['fecha_inicio'] ?? null,
                        $data['fecha_fin'] ?? null
                    ),
                    'reporte_actividades.xlsx'
                ),

                'equipos' => Excel::download(
                    new EquiposYHerramientasExport(),
                    'reporte_equipos.xlsx'
                ),

                'insumos' => Excel::download(
                    new MaterialesEInsumosExport(),
                    'reporte_insumos.xlsx'
                ),

                'usuarios' => Excel::download(
                    new UsuariosExport(),
                    'reporte_usuarios.xlsx'
                ),

                default => null,
            };
        }

        // ---------------------------
        // PDF
        // ---------------------------
        if ($data['formato'] === 'pdf') {

            return match ($data['recurso']) {

                'actividades' => $this->redirectRoute('pdf.actividades', [
                    'inicio' => $data['fecha_inicio'] ?? null,
                    'fin' => $data['fecha_fin'] ?? null,
                ]),

                'equipos' => $this->redirectRoute('pdf.equipos'),

                'insumos' => $this->redirectRoute('pdf.insumos'),

                'usuarios' => $this->redirectRoute('pdf.usuarios'),

                default => null,
            };
        }
    }
}