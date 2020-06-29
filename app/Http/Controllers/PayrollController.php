<?php

namespace App\Http\Controllers;

use App\Payroll;
use PDF;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    

    public function list(){
        $payrolls = Payroll::batches();

        return view('payrolls',compact('payrolls'));
    }
    public function listByBatchId($batch_id){
        $payrolls = Payroll::where('batch_id',$batch_id)->get();

        return view('payroll-list',compact('payrolls'));
    }
    public function viewPayroll($payroll_id){
        
        $value = Payroll::find($payroll_id);
        $percentage = round($value->getRawOriginal('net_pay') / $value->getRawOriginal('gross_compensation'),2) * 100;

        $logo = public_path('logo.png');
        $signature = public_path('signature.png');
        $pdf = PDF::loadView('payslip', compact('value','logo','signature'));
        $customPaper = array(0,0,360,1030);
        $pdf->setPaper($customPaper);
        
        $pdf->setPaper($customPaper);
        return $pdf->stream();

    }
    
    public function resendPayroll($payroll_id){

        $payslip = Payroll::find($payroll_id);

        $payslip->sendToEmail();

        return redirect()->back()->with('status','Payslip succesfully sent to '. $payslip->email);

    }

  
    
}
