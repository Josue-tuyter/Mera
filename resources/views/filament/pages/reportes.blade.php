<x-filament-panels::page>
     <div class="max-w-xl space-y-6">
        {{ $this->form }}

        <x-filament::button
            wire:click="generarReporte"
            color="primary"
        >
            Generar reporte
        </x-filament::button>
    </div>
</x-filament-panels::page>
