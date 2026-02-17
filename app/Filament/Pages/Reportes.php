<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use BackedEnum;
use UnitEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema; 
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Maatwebsite\Excel\Facades\Excel;

// Exports
use App\Exports\RegistroActividadesExport;
use App\Exports\EquiposYHerramientasExport;
use App\Exports\MaterialesEInsumosExport;
use App\Exports\UsuariosExport;

class Reportes extends Page implements HasForms
{
    use InteractsWithForms;

    // --- Configuración de Navegación ---
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-arrow-down';
    protected static ?string $navigationLabel = 'Reportes';
    protected static string|UnitEnum|null $navigationGroup = 'Reportes';
    protected static ?string $title = 'Reportes';
    protected string $view = 'filament.pages.reportes';

    /** Estado del formulario */
    public array $data = [];

    /**
     * Fuerza a la página a ocupar todo el ancho disponible (Full Width)
     */
    public function getMaxContentWidth(): string
    {
        return 'full';
    }

    public function mount(): void
    {
        $this->form->fill();
    }

    /**
     * Definición del Formulario usando Schema
     */
    public function form(Schema $form): Schema
    {
        return $form
            ->components([
                
                Section::make('Configuración del Reporte')
                    ->description('Seleccione el recurso y el formato para exportar la información.')
                    ->icon('heroicon-o-document-magnifying-glass')
                    ->extraAttributes([
                        'class' => 'bg-[#4E2C0F]/5 border-t-4 border-[#4E2C0F] rounded-xl shadow-sm',
                    ])
                    ->columns(2)
                    ->schema([
                        
                        Select::make('recurso')
                            ->label('Recurso a reportar')
                            ->prefixIcon('heroicon-m-rectangle-stack')
                            ->required()
                            ->options([
                                'actividades' => 'Registro de actividades',
                                'equipos'     => 'Equipos y herramientas',
                                'insumos'     => 'Materiales e insumos',
                                'usuarios'    => 'Usuarios',
                            ])
                            ->native(false)
                            ->reactive(),

                        Select::make('formato')
                            ->label('Formato de descarga')
                            ->prefixIcon('heroicon-m-arrow-down-tray')
                            ->required()
                            ->options([
                                'excel' => 'Microsoft Excel (.xlsx)',
                                'pdf'   => 'Documento PDF (.pdf)'
                            ])
                            ->native(false),

                        // Sección de fechas con estilo Verde Follaje
                        Section::make('Filtros de Período')
                            ->description('Opcional: Define un rango de fechas para el reporte.')
                            ->icon('heroicon-o-calendar-days')
                            ->visible(fn ($get) => $get('recurso') === 'actividades')
                            ->extraAttributes([
                                'class' => 'bg-[#606C38]/10 border border-[#606C38]/20 rounded-lg mt-2',
                            ])
                            ->columnSpanFull()
                            ->columns(2)
                            ->schema([
                                DatePicker::make('fecha_inicio')
                                    ->label('Desde')
                                    ->prefixIcon('heroicon-m-calendar')
                                    ->native(false),

                                DatePicker::make('fecha_fin')
                                    ->label('Hasta')
                                    ->prefixIcon('heroicon-m-calendar-days')
                                    ->native(false),
                            ]),
                    ]),
            ])
            ->statePath('data');
    }

    /**
     * Lógica para procesar y descargar los archivos
     */
    public function generarReporte()
    {
        $data = $this->form->getState();

        if (! isset($data['formato'], $data['recurso'])) {
            return;
        }

        // ---------------------------
        // Lógica para EXCEL
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
        // Lógica para PDF (Redirección a Rutas)
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