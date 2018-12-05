<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\RejectedRequest;
use App\Events\triggerEvent;
use App\CctvReview;
use App\User;

class ReviewRequestRejected extends Notification implements ShouldQueue
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
    public function __construct(RejectedRequest $request, User $user)
    {
        $this->request = $request;
        $this->user = $user;
        $this->url = url('/cr/rcrv/'.$request->id);
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
                ->line('Your CCTV Review Request #'.$this->request->request_id.' is rejected.')
                ->line('<b>REASON:</b>')
                ->line($this->request->reason)
                ->line('Click the link below for more details.')
                ->action('View Request', $this->url)
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
        return [
            'message' => 'CCTV Review Request rejected.',
            'mod' => 'reject',
            'tid' => $this->request->id,
            'series' => $this->request->request_id
        ];
    }
}
