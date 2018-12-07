<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Events\triggerEvent;
use App\CctvReview;
use App\User;

class ReviewRequestApproved extends Notification implements ShouldQueue
{
    use Queueable;

    protected $request;
    protected $user;
    protected $type;
    protected $url;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(CctvReview $request, User $user,$type)
    {
        $this->request = $request;
        $this->user = $user;
        $this->type = $type;
        $this->url = url('/cr/crv/'.$request->id);
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
                ->line('Your CCTV Review Request #'.$this->request->request_id.' has been approved.')
                ->action('View Request', $this->url)
                ->line('Thank you for using our application!');
        }
        else{
            return (new MailMessage)
                ->greeting('Hello! ' .$this->user->name)
                ->line('CCTV Review Request #'.$this->request->request_id.' has been approved.')
                ->line('Click the link below for more information.')
                ->action('View Request', $this->url)
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
        return [
            'header' => 'CCTV Review Request Approved',
            'msg' => 'CCTV Review Request #'.$this->request->request_id.' has been approved.',
            'url' => $this->url,
            'message' => 'CCTV Review Request Approved.',
            'mod' => 'request',
            'tid' => $this->request->id,
            'series' => $this->request->request_id
        ];
    }
}