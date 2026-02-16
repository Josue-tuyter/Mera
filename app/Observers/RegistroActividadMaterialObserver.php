<?php

namespace App\Observers;

use App\Models\RegistroActividadMaterial;
use App\Models\User;
use App\Mail\StockBajoMailable;
use Illuminate\Support\Facades\Mail;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class RegistroActividadMaterialObserver
{
    /**
     * Handle the "created" event: se ejecuta cuando se crea un nuevo registro en la tabla pivote
     */
    public function created(RegistroActividadMaterial $pivot): void
    {
        $material = $pivot->material;

        if ($material) {
            $material->decrement('stock', $pivot->cantidad);
            $this->verificarYNotificar($material);
        }
    }

    /**
     * Handle the "updated" event: solo si cambió la cantidad
     */
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

    /**
     * Verifica si el stock está por debajo del mínimo y envía notificaciones
     */
    protected function verificarYNotificar($material): void
    {
        // Refrescamos el modelo para tener el stock actualizado
        $material->refresh();

        if ($material->stock <= $material->stock_minimo) {
            // 1. Notificación en Filament (para el usuario que hizo la acción)
            Notification::make()
                ->danger()
                ->title('¡Stock crítico detectado!')
                ->body("El insumo **{$material->nombre}** ha bajado a {$material->stock} unidades (mínimo: {$material->stock_minimo}).")
                ->duration(15000)
                ->send();

            // 2. Envío de correo a TODOS los usuarios registrados
            $emails = User::pluck('email')->toArray();

            // Solo enviamos si hay al menos un correo
            if (!empty($emails)) {
                try {
                    // Opción A: Enviar a todos visiblemente (to)
                    // Mail::to($emails)->send(new StockBajoMailable($material));

                    // Opción B: Recomendada - enviar en BCC para que nadie vea los correos de los demás
                    Mail::bcc($emails)
                        ->send(new StockBajoMailable($material));

                    // Opcional: Log de éxito
                    Log::info("Correo de stock bajo enviado a " . count($emails) . " usuarios para el material: {$material->nombre}");
                } catch (\Exception $e) {
                    Log::error("Error al enviar correo masivo de stock bajo: " . $e->getMessage());
                }
            } else {
                Log::warning("No se encontraron usuarios para enviar notificación de stock bajo.");
            }
        }
    }
}