<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Ticket;
use App\Events\triggerEvent;

class TicketUpdated extends Notification
{
    use Queueable;

    protected $ticket_id;
    protected $name;
    protected $aname;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($tid,$uname,$aname)
    {
        $this->ticket_id = $tid;
        $this->name = $uname;
        $this->aname = $aname;
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
        $url = url('/it/vt/'.$this->ticket_id);
        $t = Ticket::where('id',$this->ticket_id)->first();
        return (new MailMessage)
                ->greeting('Hello! ' .$this->name)
                ->line('Ticket <b>#'.$t->ticket_id.'</b> has a new message from <b>'.$this->aname.'</b>.')
                ->line('Click on the button link to view the message.')
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
        event(new triggerEvent('refresh'));
        $t = Ticket::where('id',$this->ticket_id)->first();
        return [
            'message' => 'New Message on Ticket #'.$t->ticket_id,
            'mod' => 'user',
            'tid' => $this->ticket_id
        ];
    }
}
