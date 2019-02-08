<?php

namespace App\Notifications\hr;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class VehicleRequestApproval extends Notification implements ShouldQueue
{
    use Queueable;

    protected $vrequest;
    protected $user;
    protected $url;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($vrequest,$user)
    {
        $this->vrequest = $vrequest;
        $this->user = $user;
        $this->url = url('/hr/vrv/'.$vrequest->id);
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
                    ->line('Vehicle Request #'.$this->vrequest->vehicle_request_serial.' needs your approval.')
                    ->line('Click the link below for more information.')
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
            'msg' => 'Vehicle Request #'.$this->vrequest->vehicle_request_serial.' needs your approval.',
            'url' => $this->url,
            'message' => 'Vehicle Request Approval',
            'mod' => 'vrequest',
            'tid' => $this->vrequest->id,
            'series' => $this->vrequest->vehicle_request_serial
        ];
    }
}