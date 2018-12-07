<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\CctvReview;
use App\Events\triggerEvent;
use App\User;

class ReviewRequestPriorityChanged extends Notification implements ShouldQueue
{
    use Queueable;

    protected $request;
    protected $user;
    protected $url;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(CctvReview $request,User $user)
    {
        $this->request = $request;
        $this->user = $user;
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
        return (new MailMessage)
                ->greeting('Hello! ' .$this->user->name)
                ->line('CCTV Review Request #'.$this->request->request_id.' Priority changed to '. $this->request->priority->name .'.')
                ->action('View Request', $this->url)
                ->line('Please wait for further updates.');
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
            'header' => 'CCTV Review Request Priority Changed',
            'msg' => 'CCTV Review Request #'.$this->request->request_id.' changed priority to '.$this->request->priority->name.'.',
            'url' => $this->url,
            'message' => 'CCTV Review Request priority changed.',
            'mod' => 'request',
            'tid' => $this->request->id,
            'series' => $this->request->request_id
        ];
    }
}