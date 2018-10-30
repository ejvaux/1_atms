<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class QueueErrorReport extends Notification
{
    use Queueable;

    protected $connectionName;
    protected $job;
    protected $exception;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($connectionName = '',$job = '',$exception = '')
    {
        $this->connectionName = $connectionName;
        $this->job = $job;
        $this->exception = $exception;
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
        /* return (new MailMessage)
                    ->line('An error occurred on ' . $this->connectionName . '.')
                    ->line('Job: ' . $this->job . '.')
                    ->line('Exception:')
                    ->line($this->exception); */
        return (new MailMessage)
                    ->line('An error occurred on the Production Server.');
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
            //
        ];
    }
}
