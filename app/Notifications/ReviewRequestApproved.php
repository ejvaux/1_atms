<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Events\triggerEvent;
use App\CctvReview;

class ReviewRequestApproved extends Notification implements ShouldQueue
{
    use Queueable;

    protected $request_id;
    protected $name;
    protected $type;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($tid,$uname,$type)
    {
        $this->request_id = $tid;
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
        $url = url('/cr/crv/'.$this->request_id);
        $t = CctvReview::where('id',$this->request_id)->first();
        if($this->type == 'user'){
            return (new MailMessage)
                ->greeting('Hello! ' .$this->name)
                ->line('Your CCTV Review Request #'.$t->request_id.' has been approved..')
                ->action('View Request', $url)
                ->line('Thank you for using our application!');
        }
        else{
            return (new MailMessage)
                ->greeting('Hello! ' .$this->name)
                ->line('CCTV Review Request #'.$t->request_id.' has been approved..')
                ->line('Click the link below for more information.')
                ->action('View Request', $url)
                ->line('Thank you for using our application!');
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
        $url = url('/cr/crv/'.$this->request_id);
        $t = CctvReview::where('id',$this->request_id)->first();
        return [
            'message' => 'CCTV Review Request Approved.',
            'mod' => 'request',
            'tid' => $this->request_id,
            'series' => $t->request_id
        ];
    }
}
