<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Events\triggerEvent;
use App\CctvReview;
use App\User;

class ReviewRequestCreated extends Notification implements ShouldQueue
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
                ->line('CCTV Review Request #'.$this->request->request_id.' is created and needs approval.')
                ->line('<table style="width: 100%; border: 2px solid black; border-collapse: collapse;">
                <tbody>
                <tr>
                <th style="width: 100%; border: 1px solid black; text-align: center; padding: 10px;" colspan="2">CCTV REVIEW DETAILS</th>
                </tr>
                <tr>
                <th style="width: 25%; border: 1px solid black; vertical-align:top; text-align:left; padding: 5px;">PRIORITY</th>
                <td style="width: 75%; border: 1px solid black; padding: 10px;">'.$this->request->priority->name.'</td>
                </tr>
                <tr>
                <th style="width: 25%; border: 1px solid black; vertical-align:top; text-align:left; padding: 5px;">DEPARTMENT</th>
                <td style="width: 75%; border: 1px solid black; padding: 10px;">'.$this->request->department->name.'</td>
                </tr>
                <tr>
                <th style="width: 25%; border: 1px solid black; vertical-align:top; text-align:left; padding: 5px;">SUBJECT</th>
                <td style="width: 75%; border: 1px solid black; padding: 10px;">'.$this->request->subject.'</td>
                </tr>
                <tr>
                <th style="width: 25%; border: 1px solid black; vertical-align:top; text-align:left; padding: 5px;">DESCRIPTION</th>
                <td style="width: 75%; border: 1px solid black; padding: 10px;">'.$this->request->message.'</td>
                </tr>
                </tbody>
                </table>')
                ->line('Click the link below for more details.')
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
            'header' => 'New CCTV Review Request Created',
            'msg' => 'CCTV Review Request #'.$this->request->request_id.'. Created by '.$this->request->user->name.'.',
            'url' => $this->url,
            'message' => 'New CCTV Review Request Created.',
            'mod' => 'request',
            'tid' => $this->request->id,
            'series' => $this->request->request_id
        ];
    }
}