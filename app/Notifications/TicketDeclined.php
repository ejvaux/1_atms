<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Events\triggerEvent;
use App\DeclinedTicket;
use App\User;

class TicketDeclined extends Notification implements ShouldQueue
{
    use Queueable;

    protected $ticket;
    protected $user;
    protected $url;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(DeclinedTicket $ticket, User $user)
    {
        $this->ticket = $ticket;
        $this->user = $user;
        $this->url = url('/it/dtv/'.$ticket->id);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database','broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                ->greeting('Hello! ' .$this->user->name)
                ->line('Ticket #'.$this->ticket->ticket_id.' is declined by the admin.')
                ->line('Reason: '.$this->ticket->reason.'.')
                ->action('View Ticket', $this->url)
                ->line('Thank you for using our application!');
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
            'header' => 'Ticket Declined',
            'msg' => 'Ticket #'.$this->ticket->ticket_id.' is declined by the admin.',
            'url' => $this->url,
            'message' => 'Ticket #'.$this->ticket->ticket_id.' declined.',
            'mod' => 'decline',
            'tid' => $this->ticket->id,
            'series' => $this->ticket->ticket_id
        ];
    }
}
