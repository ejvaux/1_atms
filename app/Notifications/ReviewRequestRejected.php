<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\RejectedRequest;
use App\Events\triggerEvent;
use App\CctvReview;

class ReviewRequestRejected extends Notification implements ShouldQueue
{
    use Queueable;

    protected $ticket_id;
    protected $name;
    protected $reason;
    protected $rid;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($tid,$uname,$reason,$rid)
    {
        $this->ticket_id = $tid;
        $this->name = $uname;
        $this->reason = $reason;
        $this->rid = $rid;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url('/cr/rcrv/'.$this->ticket_id);
        return (new MailMessage)
                ->greeting('Hello! ' .$this->name)
                ->line('Your CCTV Review Request #'.$this->rid.' is rejected.')
                ->line('REASON:')
                ->line($this->reason)
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
        return [
            'message' => 'CCTV Review Request rejected.',
            'mod' => 'request',
            'tid' => $this->ticket_id,
            'series' => ''
        ];
    }
}
