<?php

namespace App\Events;

use App\Payroll;
use Illuminate\Support\Facades\Log;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ResendBatchPayroll 
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $list;
    public function __construct($list)
    {
        $list = Payroll::whereBatchId($list)->where('seen_at',null)->get('id');
        // $list = Payroll::whereBatchId($list)->get('id');
        // $list = Payroll::limit(100)->get('id');
        $this->list = $list;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    // public function broadcastOn()
    // {
    //     return ('channel-notifcations');
    // }
    // public function broadcastAs()
    // {
    //     return 'event-resend-batch';
    // }
    // public function broadcastWith(){
    //     return ['clients'=>$this->list];
    // }
}
