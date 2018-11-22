<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Events\triggerEvent;
use App\CctvReview;

class CctvAttachmentsUploaded extends Notification implements ShouldQueue
{
    use Queueable;

    protected $ticket_id;
    protected $name;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($tid,$uname)
    {
        $this->ticket_id = $tid;
        $this->name = $uname;
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
        $url = url('/cr/crv/'.$this->ticket_id);
        $t = CctvReview::where('id',$this->ticket_id)->first();
        return (new MailMessage)
                ->greeting('Hello! ' .$this->name)
                ->line('Attachment/s has been uploaded/added on CCTV Review Request #'.$t->request_id.'.')
                ->line('Follow the link below if you want to allow the requestor to view the attachments.')
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
        $t = CctvReview::where('id',$this->ticket_id)->first();
        return [
            'message' => 'CCTV Request Attachment Uploaded.',
            'mod' => 'request',
            'tid' => $this->ticket_id,
            'series' => $t->request_id
        ];
    }
}
