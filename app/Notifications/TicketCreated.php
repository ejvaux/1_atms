<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Ticket;
use App\Events\triggerEvent;
use App\Custom\CustomFunctions;

class TicketCreated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $ticket_id;
    protected $name;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($tid,$uname)
    {
        $this->ticket_id = $tid;
        $this->name = $uname;
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
        $url = url('/it/av/'.$this->ticket_id);
        $t = Ticket::where('id',$this->ticket_id)->first();
        return (new MailMessage)
                ->greeting('Hello! ' .$this->name)
                ->line('Ticket <b>#'.$t->ticket_id.'</b> is by '.$t->user->name.'.')
                /* ->line('<table class="table table-bordered"><thead><tr><th scope="col" colspan="4">TICKET DETAILS</th></tr></thead><tbody><tr><th scope="row" >Priority</th><td>' . CustomFunctions::priority_format($t->priority_id) . '</td></tr><tr><th scope="row">Department</th><td>' . $t->department->name) . '</td></tr><tr><th scope="row">Category</th><td>' . $t->category->name . '</td></tr><tr><th scope="row">Subject</th><td>' . $t->subject . '</td></tr></tbody></table>') */
                ->line('<b>TICKET DETAILS</b>')
                ->line('Priority: '.CustomFunctions::priority_format($t->priority_id))
                ->line('Department: '.$t->department->name)
                ->line('Category: '.$t->category->name)
                ->line('Subject: '.$t->subject)
                ->line('Description: '.$t->message)
                ->line('For more info click on the link below.')              
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
        $url = url('/it/av/'.$this->ticket_id);
        $t = Ticket::where('id',$this->ticket_id)->first();
        return [
            'message' => 'Ticket #'.$t->ticket_id.' Created.',
            'mod' => 'create',
            'tid' => $this->ticket_id
        ];
    }
}
