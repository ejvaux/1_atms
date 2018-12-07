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

class TicketAssigned extends Notification implements ShouldQueue
{
    use Queueable;

    protected $ticket;
    protected $user;
    protected $type;
    protected $assigner;
    protected $url;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Ticket $ticket,User $user,$type,$assigner = '')
    {        
        $this->ticket = $ticket;
        $this->user = $user;
        $this->type = $type;
        $this->assigner = $assigner;
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
        if($this->type == 'user'){
            return (new MailMessage)
                    ->greeting('Hello! ' .$this->user->name)
                    ->line('Your ticket <b>#'.$this->ticket->ticket_id.'</b> is now on queue.')
                    ->line('Ticket is assigned to <b>'.$this->ticket->assign->name.'</b>.')
                    ->action('View Ticket', $this->url)
                    ->line('Thank you for using our application!');
        }
        else{
            return (new MailMessage)
                    ->greeting('Hello! ' . $this->user->name)
                    ->line('Ticket <b>#' . $this->ticket->ticket_id . '</b> is assigned to you by <b>'.$this->assigner.'</b>.')
                    ->action('View Ticket', $this->url)
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
        if($this->type == 'user'){
            return [
                'header' => 'Ticket Assigned',
                'msg' => 'Your ticket #'.$this->ticket->ticket_id.' is assigned to '.$this->ticket->assign->name.'.',
                'url' => $this->url,
                'message' => 'Ticket #'.$this->ticket->ticket_id.' Assigned.',
                'mod' => 'user',
                'tid' => $this->ticket->id,
                'series' => $this->ticket->ticket_id
            ];
        }
        else{
            return [
                'header' => 'New Ticket Assignment',
                'msg' => 'Ticket #'.$this->ticket->ticket_id.' is assigned to you by '.$this->assigner.'.',
                'url' => $this->url,
                'message' => 'New Ticket Assignment.',
                'mod' => 'assign_admin',
                'tid' => $this->ticket->id,
                'series' => $this->ticket->ticket_id
            ];            
        }
    }
}
