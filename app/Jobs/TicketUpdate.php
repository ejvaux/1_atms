<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\TicketUpdates;

class TicketUpdate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id;
    protected $user_id;
    protected $message;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id,$user_id,$message)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $tu = new TicketUpdates;
        $tu->ticket_id = $this->id;
        $tu->user_id = $this->user_id;
        $tu->message = $this->message;
        $tu->save();
    }
}
