<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\EquiposYHerramienta;

class MantenimientoEquipoMail extends Mailable
{
    use Queueable, SerializesModels;

    // Esta propiedad pública permite que los datos se vean en el Blade
    public $equipo;

    /**
     * Create a new message instance.
     */
    public function __construct(EquiposYHerramienta $equipo)
    {
        $this->equipo = $equipo;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "🛠️ Recordatorio: Mantenimiento de {$this->equipo->nombre}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.mantenimiento_equipo', // Ruta de la vista que creamos
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}