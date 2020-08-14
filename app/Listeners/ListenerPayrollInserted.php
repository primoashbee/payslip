<?php

namespace App\Listeners;

use App\Payroll;
use PDF;
use App\Mail\SendPayslipMail;
use Illuminate\Support\Facades\Log;
use App\Events\EventPayrollInserted;
use App\Events\PayrollUploadSuccess;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ListenerPayrollInserted implements ShouldQueue
{
    
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public $timeout=0;

    public function handle($event)
    {
        
        // set_time_limit(300);
        $logo = public_path('logo.png');
        $signature = public_path('signature.png');
        $payslips = Payroll::where('batch_id', $event->batch_id)->get();
        
        $ctr=0;
        $total = $payslips->count();
        foreach ($payslips as $key => $value) {

            $logo = public_path('logo.png');
            $signature = public_path('signature.png');
            $pdf = PDF::loadView('payslip', compact('value','logo','signature'));
            $customPaper = array(0,0,360,1090);
            $pdf->setPaper($customPaper);
            
            $password = str_shuffle(uniqid());

            $pdf->setEncryption($password);
            $name = $value->name.' - '.$value->applicable.'.pdf';
            $filepath = Storage::disk('public')->path($name);
            $pdf->save($filepath);
            
            Mail::to($value->email)->send(new SendPayslipMail($value,$filepath,$password));
            $ctr++;
            Storage::disk('public')->delete($name);
        }
        
        $msg = 'Succesffully sent email '.$ctr.' of '.$total.'.';
        // $msg = 'Succesffully sent emails';
        Log::info($msg);
        event(new PayrollUploadSuccess($msg));
    }

    public function failed(){
        Log::info('failed sir');
    }
}
