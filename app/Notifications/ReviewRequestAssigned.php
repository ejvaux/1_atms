<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Auth;
use App\User;
use App\Events\triggerEvent;
use App\CctvReview;

class ReviewRequestAssigned extends Notification implements ShouldQueue
{
    use Queueable;

    protected $request;
    protected $user;
    protected $type;
    protected $assigner;
    protected $url;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(CctvReview $request, User $user,$type,$assigner = '')
    {
        $this->request = $request;
        $this->user = $user;
        $this->type = $type;
        $this->assigner = $assigner;
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
                    ->line('Your CCTV Review Request #'.$this->request->request_id.' is now on queue.')
                    ->action('View Request', $this->url)
                    ->line('Thank you for using our application!');
        }
        else{
            return (new MailMessage)
                    ->greeting('Hello! ' . $this->user->name)
                    ->line('CCTV Review Request #' . $this->request->request_id . ' is assigned to you  by <b>'.$this->assigner.'</b>.')
                    ->action('View Request', $this->url)
                    ->line('Your immediate response is highly appreciated.');
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
        if($this->type == 'user'){            
            return [
                'header' => 'CCTV Review Request Assigned',
                'msg' => 'CCTV Review Request #'.$this->request->request_id.' is now on queue.',
                'url' => $this->url,
                'message' => 'CCTV Review Request assigned.',
                'mod' => 'request',
                'tid' => $this->request->id,
                'series' => $this->request->request_id
            ];
        }
        else{
            return [
                'header' => 'CCTV Review Request Accepted',
                'msg' => 'CCTV Review Request #'.$this->request->request_id.' is assigned to you by '.$this->assigner.'.',
                'url' => $this->url,
                'message' => 'CCTV Review Request assigned.',
                'mod' => 'request',
                'tid' => $this->request->id,
                'series' => $this->request->request_id
            ];            
        }
    }
}
