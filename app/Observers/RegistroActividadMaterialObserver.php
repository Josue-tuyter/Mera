<?php

namespace App\Observers;

use App\Models\RegistroActividadMaterial;
use App\Mail\StockBajoMailable;
use Illuminate\Support\Facades\Mail;
use Filament\Notifications\Notification;

class RegistroActividadMaterialObserver
{
    public function created(RegistroActividadMaterial $pivot): void
    {
        $material = $pivot->material;
        if ($material) {
            $material->decrement('stock', $pivot->cantidad);
            
            // ¡ESTA LÍNEA ES LA QUE FALTA!
            $this->verificarYNotificar($material);
        }
    }

    public function updated(RegistroActividadMaterial $pivot): void
    {
        if ($pivot->isDirty('cantidad')) {
            $diferencia = $pivot->cantidad - $pivot->getOriginal('cantidad');
            $material = $pivot->material;
            
            if ($material) {
                $material->decrement('stock', $diferencia);
                
                // ¡ESTA LÍNEA TAMBIÉN ES NECESARIA AQUÍ!
                $this->verificarYNotificar($material);
            }
        }
    }

    protected function verificarYNotificar($material): void
    {
        $material->refresh();

        if ($material->stock <= $material->stock_minimo) {
            Notification::make()
                ->danger()
                ->title('Stock Crítico Detectado')
                ->body("El insumo {$material->nombre} ha bajado a {$material->stock}.")
                // 15000 milisegundos = 15 segundos. Tiempo suficiente para leer.
                ->duration(15000) 
                ->send();

            // El resto del código del Mail...
            $destinatarios = ['josuerogelym@gmail.com'];
            if (auth()->check()) { $destinatarios[] = auth()->user()->email; }

            try {
                Mail::to($destinatarios)->send(new StockBajoMailable($material));
            } catch (\Exception $e) {
                \Log::error("Error de correo: " . $e->getMessage());
            }
        }
    }
}