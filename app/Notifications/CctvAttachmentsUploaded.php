<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Events\triggerEvent;
use App\CctvReview;
use App\User;

class CctvAttachmentsUploaded extends Notification implements ShouldQueue
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
                ->line('Attachment/s has been uploaded/added on CCTV Review Request #'.$this->request->request_id.'.')
                ->line('Follow the link below if you want to allow the requestor to view the attachments.')
                ->action('View Request', $this->url);
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
            'header' => 'CCTV Request Attachment Uploaded.',
            'msg' => 'Attachment/s has been uploaded/added on CCTV Review Request #'.$this->request->request_id.'.',
            'url' => $this->url,
            'message' => 'CCTV Request Attachment Uploaded.',
            'mod' => 'request',
            'tid' => $this->request->id,
            'series' => $this->request->request_id
        ];
    }
}
