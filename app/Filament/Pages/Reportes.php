<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Schemas\Schema;
use Filament\Forms\Contracts\HasForms; // 1. Importar contrato
use Filament\Forms\Concerns\InteractsWithForms; // 2. Importar trait
use UnitEnum;
// 3. AGREGAR "implements HasForms"
class Reportes extends Page implements HasForms 
{
    // 4. AGREGAR el trait dentro de la clase
    use InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-arrow-down';
    protected static ?string $navigationLabel = 'Reportes';
    protected static string | UnitEnum | null $navigationGroup = 'Reportes';
    protected static ?string $title = 'Reportes';
    protected string $view = 'filament.pages.reportes';

    /** Estado del formulario */
    public array $data = [];

    // Este método ahora sí será reconocido
    public function form(Schema $form): Schema
    {
        return $form
            ->components([
                Select::make('recurso')
                    ->label('Recurso a reportar')
                    ->required()
                    ->options([
                        'actividades' => 'Registro de actividades',
                        'equipos' => 'Equipos y herramientas',
                        'insumos' => 'Materiales e insumos',
                        'usuarios' => 'Usuarios',
                        'organizacion' => 'Organización',
                        'datos_generales' => 'Datos generales',
                    ]),

                Select::make('formato')
                    ->label('Formato')
                    ->required()
                    ->options([
                        'pdf' => 'PDF',
                        'excel' => 'Excel',
                    ]),
            ])
            ->statePath('data');
    }

    public function generarReporte(): void
    {
        // Validar y obtener los datos del formulario
        $state = $this->form->getState(); 
        dd($state);
    }
}