<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Events\triggerEvent;
use App\CctvReview;
use App\User;

class ReviewRequestStatusChanged extends Notification implements ShouldQueue
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
    public function __construct(CctvReview $request, User $user)
    {
        $this->request = $request;
        $this->user = $user;
        $this->url = $url = url('/cr/crv/'.$request->id);
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
        if ($this->request->status_id != 5) {
            return (new MailMessage)
                ->greeting('Hello! ' .$this->user->name)
                ->line('CCTV Review Request #'.$this->request->request_id.' Status changed to '. $this->request->status->name .'.')
                ->action('View Request', $this->url)
                ->line('Please wait for further updates.');
        } else {
            return (new MailMessage)
                ->greeting('Hello! ' .$this->user->name)
                ->line('CCTV Review Request #'.$this->request->request_id.' Status changed to '. $this->request->status->name .'.')
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
            'message' => 'CCTV Review Request status changed.',
            'mod' => 'request',
            'tid' => $this->request->id,
            'series' => $this->request->request_id
        ];
    }
}