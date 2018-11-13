<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Events\triggerEvent;
use App\CctvReview;

class ReviewRequestCreated extends Notification implements ShouldQueue
{
    use Queueable;
    
    protected $request_id;
    protected $name;
    protected $rid;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($tid,$uname,$rid)
    {
        $this->request_id = $tid;
        $this->name = $uname;
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
        $url = url('/cr/crv/'.$this->request_id);
        $t = CctvReview::where('id',$this->request_id)->first();
        return (new MailMessage)
                ->greeting('Hello! ' .$this->name)
                ->line('CCTV Review Request #'.$this->rid.' is created and needs approval.')
                ->line('Click the link below for more details.')
                ->action('View Request', $url);
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
        $url = url('/cr/crv/'.$this->request_id);
        $t = CctvReview::where('id',$this->request_id)->first();
        return [
            'message' => 'New CCTV Review Request Created.',
            'mod' => 'request',
            'tid' => $this->request_id,
            'series' => $t->request_id
        ];
    }
}