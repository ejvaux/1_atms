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
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($tid,$uname,$tech)
    {
        $this->ticket_id = $tid;
        $this->name = $uname;
        $this->tech = $tech;
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
                ->line('Your ticket <b>#'.$t->ticket_id.'</b> is accepted by <b>'.$this->tech.'</b>.')
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
        $t = Ticket::where('id',$this->ticket_id)->first();
        event(new triggerEvent('refresh'));
        return [
            'message' => 'Ticket #'.$t->ticket_id.' Accepted.',
            'mod' => 'user',
            'tid' => $this->ticket_id
        ];
    }
}
