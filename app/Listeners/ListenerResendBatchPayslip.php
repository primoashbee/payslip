<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ListenerResendBatchPayslip implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public $timeout=0;
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $lists  = $event->list;
        $ctr=0;
        foreach($lists as $list){
            $list->sendToEmail();
            $ctr++;
        }
        if($ctr == $lists->count()){
            Log::info('Success: ' . $ctr . ' / ' . $lists->count());
        }else{
            Log::error('Err');
        }
    }
}
