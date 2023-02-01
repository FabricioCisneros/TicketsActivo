<?php

namespace App\Notifications\Ticket;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Str;

class AssignTicketToDepartment extends Notification
{
    use Queueable;

    private $ticket;
    private $agent;

    /**
     * Create a new notification instance.
     *
     * @param  Ticket  $ticket
     * @param  User  $agent
     */
    public function __construct(Ticket $ticket, User $agent)
    {
        $this->ticket = $ticket;
        $this->agent = $agent;
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
            ->subject(__('Un nuevo ticket fue asignado a tu departamento').': '.Str::limit($this->ticket->subject, 35))
            ->greeting(__('Hola').' '.$this->agent->name.',')
            ->line(__('Un nuevo ticket fue asignado a tu departamento').'.')
            ->line(__('Puedes ver los detalles de tu ticket en el siguiente ticket').':')
            ->action(__('Ver ticket'), url('/dashboard/tickets/'.$this->ticket->uuid.'/manage'));
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
