<?php

namespace App\Listeners;

use App\Mail\SendPayslipMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use PDF;


class PayrollSendPayslipListen implements ShouldQueue
{
    
    public function handle($event)
    {
        $value = $event->payroll;
     
        $logo = public_path('logo.png');
        $signature = public_path('signature.png');
        
        $pdf = PDF::loadView('payslip', compact('value','logo','signature'));
        
        $customPaper = array(0,0,360,1030);
        $pdf->setPaper($customPaper);
        
        $password = uniqid();

        $pdf->setEncryption($password);
        $name = 'PAYSLIP - '.$value->name.' - '.$value->applicable.'.pdf';
        $filepath = Storage::disk('public')->path($name);
        $pdf->save($filepath);
            
        Mail::to($value->email)->send(new SendPayslipMail($value,$filepath,$password));
        Storage::disk('public')->delete($name);
    }
}
