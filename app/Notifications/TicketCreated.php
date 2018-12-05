<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\PusherPushNotifications\PusherChannel;
use NotificationChannels\PusherPushNotifications\PusherMessage;
use App\Ticket;
use App\User;
use App\Events\triggerEvent;
use App\Custom\CustomFunctions;

class TicketCreated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $ticket;
    protected $user;
    protected $url;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Ticket $ticket, User $user)
    {
        $this->ticket = $ticket;
        $this->user = $user;
        $this->url = url('/it/av/'.$ticket->id);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database','broadcast',PusherChannel::class];
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
                ->greeting('Hello! ' .$this->user->name. ',')
                ->line('New Ticket <b>#'.$this->ticket->ticket_id.'</b> was created by <b>'.$this->ticket->user->name.'</b>.')
                ->line('<table style="width: 100%; border: 2px solid black; border-collapse: collapse;">
                <tbody>
                <tr>
                <th style="width: 100%; border: 1px solid black; text-align: center; padding: 10px; padding: 5px;" colspan="2">TICKET DETAILS</th>
                </tr>
                <tr>
                <th style="width: 25%; border: 1px solid black; vertical-align:top; text-align:left; padding: 5px;">PRIORITY</th>
                <td style="width: 75%; border: 1px solid black; padding: 10px;">'.$this->ticket->priority->name.'</td>
                </tr>
                <tr>
                <th style="width: 25%; border: 1px solid black; vertical-align:top; text-align:left; padding: 5px;">DEPARTMENT</th>
                <td style="width: 75%; border: 1px solid black; padding: 10px;">'.$this->ticket->department->name.'</td>
                </tr>
                <tr>
                <th style="width: 25%; border: 1px solid black; vertical-align:top; text-align:left; padding: 5px;">CATEGORY</th>
                <td style="width: 75%; border: 1px solid black; padding: 10px;">'.$this->ticket->category->name.'</td>
                </tr>
                <tr>
                <th style="width: 25%; border: 1px solid black; vertical-align:top; text-align:left; padding: 5px;">SUBJECT</th>
                <td style="width: 75%; border: 1px solid black; padding: 10px;">'.$this->ticket->subject.'</td>
                </tr>
                <tr>
                <th style="width: 25%; border: 1px solid black; vertical-align:top; text-align:left; padding: 5px;">DESCRIPTION</th>
                <td style="width: 75%; border: 1px solid black; padding: 10px;">'.$this->ticket->message.'</td>
                </tr>
                </tbody>
                </table>')
                /* ->line('<b>TICKET DETAILS</b>')
                ->line('Priority: '.CustomFunctions::priority_format($this->ticket->priority_id))
                ->line('Department: '.$this->ticket->department->name)
                ->line('Category: '.$this->ticket->category->name)
                ->line('Subject: '.$this->ticket->subject)
                ->line('Description: '.$this->ticket->message) */
                ->line('For more info click on the link below.')              
                ->action('View Ticket', $this->url)
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
            'message' => 'Ticket #'.$this->ticket->ticket_id.' Created.',
            'mod' => 'create',
            'tid' => $this->ticket->id,
            'series' => $this->ticket->ticket_id
        ];
    }
    public function toPushNotification($notifiable)
    {
        return PusherMessage::create()
            ->android()
            ->badge(1)
            ->sound('success')
            ->body("Your account was approved!");
    }
}