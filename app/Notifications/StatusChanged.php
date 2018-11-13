<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Events\triggerEvent;
use App\Ticket;

class StatusChanged extends Notification implements ShouldQueue
{
    use Queueable;

    protected $ticket_id;
    protected $name;
    protected $stat;
    protected $ticid;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($tid,$uname,$stat,$ticid)
    {
        $this->ticket_id = $tid;
        $this->name = $uname;
        $this->stat = $stat;
        $this->ticid = $ticid;
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
        return (new MailMessage)
                ->greeting('Hello! ' .$this->name)
                ->line('Ticket <b>#'.$this->ticid.'</b> Status changed to <b>'. $this->stat .'</b>.')
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
            'message' => 'Ticket #'.$this->ticid.' status changed.',
            'mod' => 'user',
            'tid' => $this->ticket_id,
            'series' => $this->ticid
        ];
    }
}