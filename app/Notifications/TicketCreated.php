<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Ticket;
use App\User;
use App\Events\triggerEvent;
use App\Custom\CustomFunctions;

class TicketCreated extends Notification implements ShouldQueue
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
    public function __construct(Ticket $ticket, User $user)
    {
        $this->ticket = $ticket;
        $this->user = $user;
        $this->url = url('/it/av/'.$ticket->id);
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
                ->line('New Ticket <b>#'.$this->ticket->ticket_id.'</b> was created by <b>'.$this->ticket->user->name.'</b>.')
                /* ->line('<table class="table table-bordered"><thead><tr><th scope="col" colspan="4">TICKET DETAILS</th></tr></thead><tbody><tr><th scope="row" >Priority</th><td>' . CustomFunctions::priority_format($t->priority_id) . '</td></tr><tr><th scope="row">Department</th><td>' . $t->department->name) . '</td></tr><tr><th scope="row">Category</th><td>' . $t->category->name . '</td></tr><tr><th scope="row">Subject</th><td>' . $t->subject . '</td></tr></tbody></table>') */
                ->line('<b>TICKET DETAILS</b>')
                ->line('Priority: '.CustomFunctions::priority_format($this->ticket->priority_id))
                ->line('Department: '.$this->ticket->department->name)
                ->line('Category: '.$this->ticket->category->name)
                ->line('Subject: '.$this->ticket->subject)
                ->line('Description: '.$this->ticket->message)
                ->line('For more info click on the link below.')              
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
            'message' => 'Ticket #'.$this->ticket->ticket_id.' Created.',
            'mod' => 'create',
            'tid' => $this->ticket->id,
            'series' => $this->ticket->ticket_id
        ];
    }
}