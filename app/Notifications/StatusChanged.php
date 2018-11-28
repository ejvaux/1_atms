<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Events\triggerEvent;
use App\Ticket;
use App\User;

class StatusChanged extends Notification implements ShouldQueue
{
    use Queueable;

    protected $ticket;
    protected $user;
    protected $stat;
    protected $url;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($ticket,$user,$stat)
    {
        $this->ticket = $ticket;
        $this->user = $user;
        $this->stat = $stat;
        $this->url = url('/it/vt/'.$ticket->id);
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
                ->line('Ticket <b>#'.$this->ticket->ticket_id.'</b> Status changed to <b>'. $this->stat .'</b>.')
                ->action('View Ticket', $this->url)
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
        return [
            'message' => 'Ticket #'.$this->ticket->ticket_id.' status changed.',
            'mod' => 'user',
            'tid' => $this->ticket->id,
            'series' => $this->ticket->ticket_id
        ];
    }
}