<?php

namespace App\Notifications\Ticket;

use App\Models\Setting;
use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use stdClass;
use Str;

class NewTicketFromAgent extends Notification
{
    use Queueable;

    private $ticket;

    /**
     * Create a new notification instance.
     *
     * @param  Ticket  $ticket
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(__('Nuevo Ticket creado').': '.Str::limit($this->ticket->subject, 35))
            ->greeting(__('Hola').' '.$this->ticket->user->name.',')
            ->line(__('Hemos creado un nuevo ticket, puedes ver los detalles y contestar en el siguiente link').':')
            ->action(__('Para ver el ticket'), url('/tickets/'.$this->ticket->uuid))
            ->line(__('Para poder completo tu ticket deberas entrar al portal de tickets para ello deberas iniciar sesion con tu usuario y contraseña').'.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
