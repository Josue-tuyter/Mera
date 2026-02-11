<?php

namespace App\Observers;

use App\Models\RegistroActividadMaterial;
use App\Models\User; // <--- Importamos el modelo User
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
                $this->verificarYNotificar($material);
            }
        }
    }

    protected function verificarYNotificar($material): void
    {
        $material->refresh();

        if ($material->stock <= $material->stock_minimo) {
            // Notificación en la interfaz de Filament
            Notification::make()
                ->danger()
                ->title('Stock Crítico Detectado')
                ->body("El insumo {$material->nombre} ha bajado a {$material->stock}.")
                ->duration(15000) 
                ->send();

            // --- LÓGICA PARA ENVIAR A TODOS LOS USUARIOS ---
            
            // Obtenemos solo los emails de todos los usuarios activos
            $destinatarios = User::pluck('email')->toArray();

            // Si por alguna razón no hay usuarios, evitamos el error
            if (count($destinatarios) > 0) {
                try {
                    // Usamos bcc() si no quieres que los usuarios vean los correos de los demás,
                    // o to() si no hay problema con ello.
                    Mail::to($destinatarios)->send(new StockBajoMailable($material));
                } catch (\Exception $e) {
                    \Log::error("Error de correo masivo: " . $e->getMessage());
                }
            }
        }
    }
}