<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Events\triggerEvent;
use App\DeclinedTicket;

class TicketDeclined extends Notification
{
    use Queueable;

    protected $ticket_id;
    protected $uname;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($tid,$uname)
    {
        $this->ticket_id = $tid;
        $this->name = $uname;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url('/it/ctlv/'.$this->ticket_id);
        $t = DeclinedTicket::where('id',$this->ticket_id)->first();
        return (new MailMessage)
                ->greeting('Hello! ' .$this->name)
                ->line('Ticket #'.$t->ticket_id.' is been declined by the admin.')
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
        $url = url('/it/ctlv/'.$this->ticket_id);
        event(new triggerEvent('refresh'));
        return [
            'message' => 'Ticket #'.$t->ticket_id.' declined.',
            'mod' => 'decline',
            'tid' => $this->ticket_id
        ];
    }
}
