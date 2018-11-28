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

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(DeclinedTicket $ticket, User $user)
    {
        $this->ticket = $ticket;
        $this->user = $user;
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
        /* $url = url('/it/ctlv/'.$this->ticket_id); */
        /* $t = DeclinedTicket::where('id',$this->ticket_id)->first(); */
        return (new MailMessage)
                ->greeting('Hello! ' .$this->user->name)
                ->line('Ticket #'.$this->ticket->ticket_id.' is been declined by the admin.')
                ->line('Reason: '.$this->ticket->reason.'.')
                /* ->action('View Ticket', $url) */
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
            'message' => 'Ticket #'.$this->ticket->ticket_id.' declined.',
            'mod' => 'decline',
            'tid' => $this->ticket->id,
            'series' => $this->ticket->ticket_id
        ];
    }
}
