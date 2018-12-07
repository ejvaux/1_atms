<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Ticket;
use App\User;
use App\Events\triggerEvent;

class PriorityChanged extends Notification implements ShouldQueue
{
    use Queueable;

    protected $ticket;
    protected $user;
    protected $prio;
    protected $url;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Ticket $ticket, User $user,$prio)
    {
        $this->ticket = $ticket;
        $this->user = $user;
        $this->prio = $prio;
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
                ->line('Ticket <b>#'.$this->ticket->ticket_id.'</b> Priority changed to <b>'. $this->prio .'</b>.')
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
        /* event(new triggerEvent('refresh')); */
        return [
            'header' => 'Ticket Priority Changed',
            'msg' => 'Ticket #'.$this->ticket->ticket_id.' changed priority to '.$this->prio.'.',
            'url' => $this->url,
            'message' => 'Ticket #'.$this->ticket->ticket_id.' priority changed.',
            'mod' => 'user',
            'tid' => $this->ticket->id,
            'series' => $this->ticket->ticket_id
        ];
    }    
}