<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeUserNotification extends Notification
{
    use Queueable;

    public function __construct(public string $password) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Tu cuenta ha sido creada')
            ->greeting('¡Hola, ' . $notifiable->name . '!')
            ->line('Se ha creado una cuenta para ti en el sistema de Estructura Organizacional.')
            ->line('Tus credenciales de acceso son:')
            ->line('**Usuario:** ' . $notifiable->email)
            ->line('**Contraseña:** ' . $this->password)
            ->action('Acceder al Sistema', url('/admin/login'))
            ->line('Por seguridad, te recomendamos cambiar tu contraseña una vez ingreses.');
    }
}