<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Events\triggerEvent;
use App\ClosedTicket;

class TicketClosed extends Notification implements ShouldQueue
{
    use Queueable;

    protected $ticket_id;
    protected $name;

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
        $t = ClosedTicket::where('id',$this->ticket_id)->first();
        return (new MailMessage)
                ->greeting('Hello! ' .$this->name)
                ->line('Ticket <b>#'.$t->ticket_id.'</b> is been closed.')
                ->action('View Ticket', $url)
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
        $t = ClosedTicket::where('id',$this->ticket_id)->first();
        event(new triggerEvent('refresh'));
        return [
            'message' => 'Ticket #'.$t->ticket_id.' closed.',
            'mod' => 'close',
            'tid' => $this->ticket_id
        ];
    }
}
