<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\MaterialesEInsumos;

class StockBajoMailable extends Mailable
{
    use Queueable, SerializesModels;

    // Esta propiedad pública estará disponible automáticamente en la vista .blade
    public $material;

    /**
     * Crear una nueva instancia del mensaje.
     */
    public function __construct(MaterialesEInsumos $material)
    {
        $this->material = $material;
    }

    /**
     * Define el asunto y remitentes del correo.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "⚠️ ALERTA: Stock Crítico de {$this->material->nombre}",
        );
    }

    /**
     * Define la vista que se usará para el cuerpo del correo.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.stock_bajo', // Verifica que el archivo esté en resources/views/emails/stock_bajo.blade.php
        );
    }

    /**
     * Adjuntos (en este caso vacío).
     */
    public function attachments(): array
    {
        return [];
    }
}