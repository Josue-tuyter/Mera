<x-filament-panels::page>
    <form wire:submit.prevent="generarReporte" class="space-y-6">
        {{ $this->form }}

        <div class="flex justify-start">
            <x-filament::button 
                type="submit" 
                size="lg"
                class="bg-[#4E2C0F] hover:bg-[#606C38] shadow-md"
            >
                Generar reporte
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>