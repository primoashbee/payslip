<?php

namespace App\Http\Controllers;

use App\Payroll;
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

    }
    
    public function resendPayroll($payroll_id){

        $payslip = Payroll::find($payroll_id);

        $payslip->sendToEmail();

    }
}
