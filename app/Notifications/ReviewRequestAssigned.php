<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Auth;
use App\User;
use App\Events\triggerEvent;
use App\CctvReview;

class ReviewRequestAssigned extends Notification implements ShouldQueue
{
    use Queueable;

    protected $request_id;
    protected $name;
    protected $type;
    protected $assigner;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($tid,$uname,$type,$assigner = '')
    {
        $this->request_id = $tid;
        $this->name = $uname;
        $this->type = $type;
        $this->assigner = $assigner;
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
        $t = CctvReview::where('id',$this->request_id)->first();
        $url = url('/cr/crv/'.$this->request_id);
        if($this->type == 'user'){
            return (new MailMessage)
                    ->greeting('Hello! ' .$this->name)
                    ->line('Your CCTV Review Request #'.$t->request_id.' is now on queue.')
                    ->action('View Request', $url)
                    ->line('Thank you for using our application!');
        }
        else{
            return (new MailMessage)
                    ->greeting('Hello! ' . $this->name)
                    ->line('CCTV Review Request #' . $t->request_id . ' is assigned to you  by <b>'.$this->assigner.'</b>.')
                    ->action('View Request', $url)
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
        $t = CctvReview::where('id',$this->request_id)->first();
        if($this->type == 'user'){            
            return [
                'message' => 'CCTV Review Request assigned.',
                'mod' => 'request',
                'tid' => $this->request_id,
                'series' => $t->request_id
            ];
        }
        else{
            return [
                'message' => 'CCTV Review Request assigned.',
                'mod' => 'request',
                'tid' => $this->request_id,
                'series' => $t->request_id
            ];            
        }
    }
}
