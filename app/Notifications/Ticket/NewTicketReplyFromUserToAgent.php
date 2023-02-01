<?php

namespace App\Notifications\Ticket;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Str;

class NewTicketReplyFromUserToAgent extends Notification
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
            ->subject(__('Nuevo comentario').': '.Str::limit($this->ticket->subject, 35))
            ->greeting(__('Hola').' '.$this->agent->name.',')
            ->line(__('Has recibido un nuevo comentario en tu ticket').':')
            ->action(__('See ticket'), url('/dashboard/tickets/'.$this->ticket->uuid.'/manage'));
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
