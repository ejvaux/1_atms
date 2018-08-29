<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Ticket;
use App\Events\triggerEvent;

class PriorityChanged extends Notification
{
    use Queueable;

    protected $ticket_id;
    protected $uname;
    protected $prio;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($tid,$uname,$prio)
    {
        $this->ticket_id = $tid;
        $this->name = $uname;
        $this->prio = $prio;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','broadcast','database'];
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
                ->line('Ticket #'.$t->ticket_id.' Priority changed to '. $this->prio .'.')
                ->action('View Ticket', $url)
                ->line('Please wait for further updates.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $url = url('/it/vt/'.$this->ticket_id);
        event(new triggerEvent('refresh'));
        return [
            'message' => 'Ticket priority changed.',
            'mod' => 'user',
            'tid' => $this->ticket_id
        ];
    }    
}