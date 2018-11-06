<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Events\triggerEvent;
use App\Ticket;

class TicketAccepted extends Notification implements ShouldQueue
{
    use Queueable;

    protected $ticket_id;
    protected $name;
    protected $tech;
    protected $ticid;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($tid,$uname,$tech,$ticid)
    {
        $this->ticket_id = $tid;
        $this->name = $uname;
        $this->tech = $tech;
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
                ->line('Your ticket <b>#'.$this->ticid.'</b> is accepted by <b>'.$this->tech.'</b>.')
                ->action('View Ticket', $url)
                ->line('Please wait for the technician to process your ticket.');
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
            'message' => 'Ticket #'.$this->ticid.' Accepted.',
            'mod' => 'user',
            'tid' => $this->ticket_id
        ];
    }
}
