<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Auth;
use App\User;
use App\Events\triggerEvent;
use App\Ticket;

class TicketAssigned extends Notification
{
    use Queueable;

    protected $ticket_id;
    protected $uname;
    protected $type;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($tid,$uname,$type)
    {        
        $this->ticket_id = $tid;
        $this->name = $uname;
        $this->type = $type;
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
        $t = Ticket::where('id',$this->ticket_id)->first();
        if($this->type == 'user'){
            $url = url('/it/vt/'.$this->ticket_id);
            $turl = '/1_atms/public/it/vt/'.$this->ticket_id;
            return (new MailMessage)
                    ->greeting('Hello! ' .$this->name)
                    ->line('Your ticket #'.$t->ticket_id.' is now on queue.')
                    ->action('View Ticket', $url)
                    ->line('Thank you for using our application!');
        }
        else{
            $url = url('/it/htv/'.$this->ticket_id);
            $turl = '/1_atms/public/it/htv/'.$this->ticket_id;
            return (new MailMessage)
                    ->greeting('Hello! ' . $this->name)
                    ->line('Ticket #' . $t->ticket_id . ' is assigned to you.')
                    ->action('View Ticket', $url)
                    ->line('Your immediate response is highly appreciated.');
        }
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
        if($this->type == 'user'){
            $url = url('/it/vt/'.$this->ticket_id);
            return [
                'message' => 'New ticket assigned.',
                'mod' => 'user',
                'tid' => $this->ticket_id
            ];
        }
        else{
            $url = url('/it/htv/'.$this->ticket_id);
            return [
                'message' => 'New ticket assigned.',
                'mod' => 'assign_admin',
                'tid' => $this->ticket_id
            ];            
        }
    }
}