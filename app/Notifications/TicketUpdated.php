<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Ticket;
use App\User;
use App\Events\triggerEvent;

class TicketUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $ticket;
    protected $user;
    protected $aname;
    protected $url;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Ticket $ticket,User $user ,$aname)
    {
        $this->ticket = $ticket;
        $this->user = $user;
        $this->aname = $aname;
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
                ->line('Ticket <b>#'.$this->ticket->ticket_id.'</b> has a new message from <b>'.$this->aname.'</b>.')
                ->line('Click on the button link to view the message.')
                ->action('View Ticket', $this->url)
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
            'message' => 'New Update on Ticket #'.$this->ticket->ticket_id,
            'mod' => 'user',
            'tid' => $this->ticket->id,
            'series' => $this->ticket->ticket_id
        ];
    }
}
