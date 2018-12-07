<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Events\triggerEvent;
use App\Ticket;
use App\User;

class TicketAccepted extends Notification implements ShouldQueue
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
    public function __construct(Ticket $ticket,User $user)
    {
        $this->ticket = $ticket;
        $this->user = $user;
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
                ->greeting('Hello! ' .$this->user->name. ',')
                ->line('Your ticket <b>#'.$this->ticket->ticket_id.'</b> is now being processed by <b>'.$this->ticket->assign->name.'</b>.')
                ->action('View Ticket', $this->url)
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
        return [
            'header' => 'Ticket Accepted',
            'msg' => 'Your ticket #'.$this->ticket->ticket_id.' is now being processed by '.$this->ticket->assign->name.'.',
            'url' => $this->url,
            'message' => 'Ticket #'.$this->ticket->ticket_id.' Accepted.',
            'mod' => 'user',
            'tid' => $this->ticket->id,
            'series' => $this->ticket->ticket_id
        ];
    }
}
