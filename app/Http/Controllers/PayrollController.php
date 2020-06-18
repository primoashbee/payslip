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
        $logo = public_path('logo.png');
        $value = Payroll::find($payroll_id);
        $signature = public_path('signature.png');
        $pdf = app()->make('dompdf.wrapper');    
        $pdf->loadHTML('
                <!DOCTYPE html>
                <html>
                <head>
                    <title>'.$value->name.' - '.$value->applicable.'</title>
                </head>

                <style type="text/css">
                    div.slip-container{
                    max-width: 400px;
                    width: 100%;
                    border: 1px solid black;
                    height: 1080px;
                    border-style: dashed;
                    }
                    div.slip-body{
                        display: flex;
                    }
                    div.slip-header{
                        width: 100%;
                        border-bottom: 2px solid black;
                        border-bottom-style: dashed;
                    }
                    div.slip-footer{
                        margin-top: -30px;
                        margin-left: 5px;
                    }
                    .m-0{
                        margin: 0;
                        
                    }
                    .bb{
                        border-bottom:1.5px solid black;
                    }
                    .mx-0{
                        margin: auto 0;
                    }
                    .text-left{
                        text-align: left;
                    }
                    .float-right{
                        float: right;
                    }
                    .text-center{
                        text-align: center;
                    }
                    .title{
                        font-weight: 600;
                    }
                    .pt-10{
                        padding-top: 10px;
                    }
                    table tbody tr td:nth-child(even){
                        text-align: center;
                    }
                    table{
                        width: 100%;
                    }
                </style>
                <body>

                    <div class="slip-container">
                        <div class="slip-header">
                            <img src="'.$logo.'" style="max-width:50%;max-height:50%">
                            <h4 class="mx-0">LIGHT Microfinance Incorporated</h4>
                            <p class="mx-0">MAIN OFFICE</p>
                            <p class="mx-0">'.$value->applicable.'</p>
                            <h4 class="mx-0 text-center">'.$value->name.'</h4>
                            <div>
                                <span class="text-left" style="margin-left:25px">'.$value->position.'</span>
                                <span class="float-right m0" style="margin-right:25px" >'.$value->employement.'</span>
                            </div>
                        </div>

                        <div class="slip-body">
                            <table>
                                <tbody>
                                    <tr>
                                        <td>
                                            <p class="title m-0">Basic Salary (Monthly)</p>
                                        </td>
                                        <td>
                                            <p class="title m-0" >'.$value->monthly_rate.'</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Daily Rate (Monthly)</td>
                                        <td>'.$value->daily_rate.'</td>
                                    </tr>
                                    <tr>
                                        <td>ACTUAL NO. OF WEEK DAYS PAID</td>
                                        <td>'.$value->earned.'</td>
                                    </tr>
                                    <tr>
                                        <td>Less: Absences</td>
                                        <td>'.$value->days_absent_amount.'</td>
                                    </tr>
                                    <tr>
                                        <td>Less: Tardiness</td>
                                        <td>'.$value->minutes_tardiness_amount.'</td>
                                    </tr>
                                    <tr>
                                        <td>Add/Less: Rate Adjustments</td>
                                        <td class="bb">'.$value->retro.'</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="title">GROSS COMPENSATION</p>
                                        </td>
                                        <td>
                                            <p class="title">'.$value->gross_compensation.'</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Add: Holiday Pay
                                        </td>
                                        <td>
                                        '.$value->additional_holiday_amount.'
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Add:Overtime Pay
                                        </td>
                                        <td class="bb">
                                        '.$value->overtime_amount.'
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="title">TAXABLE COMPENSATION INCOME</p>
                                        </td>
                                        <td>
                                            <p class="title">'.$value->taxable_compensation.'</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            ADD: OTHER ADJUSTMENTS
                                        </td>
                                        <td>
                                            '.$value->other_additions_amount.'
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>EB: RICE SUBSIDY</td>
                                        <td>'.$value->rice_subsidy.'</td>
                                    </tr>
                                    <tr>
                                        <td>ACCOUNTS PAYABLE</td>
                                        <td class="bb">'.$value->account_payable.'</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="title">GROSS PAY</p>
                                        </td>	
                                        <td>
                                            <p class="title">'.$value->gross_pay.'</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <p class="title m-0">LESS: DEDUCTIONS</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>A/P: Withholding Tax</td>
                                        <td>'.$value->withholding_tax.'</td>
                                    </tr>
                                    <tr>
                                        <td>A/P: SSS Contribution</td>
                                        <td>'.$value->sss_contribution.'</td>
                                    </tr>
                                    <tr>
                                        <td>A/P: PHIC Contribution</td>
                                        <td>'.$value->phic_contribution.'</td>
                                    </tr>
                                    <tr>
                                        <td>A/P: HDMF Contribition</td>
                                        <td>'.$value->hdmf_contribution.'</td>
                                    </tr>
                                    <tr>
                                        <td>A/P: Coop Share Capital</td>
                                        <td>'.$value->coop_scc.'</td>
                                    </tr>
                                    <tr>
                                        <td>A/P: Coop Loans</td>
                                        <td>'.$value->coop_loans.'</td>
                                    </tr>
                                    <tr>
                                        <td>A/P: SSS Loans</td>
                                        <td>'.$value->sss_loan.'</td>
                                    </tr>
                                    <tr>
                                        <td>A/P: HDMF Loan</td>
                                        <td>'.$value->hdmf_loan.'</td>
                                    </tr>
                                    <tr>
                                        <td>A/P: HDMF(MP2)</td>
                                        <td>'.$value->hdmf_mp2.'</td>
                                    </tr>
                                    <tr>
                                        <td>Account Receivable</td>
                                        <td>'.$value->ar.'</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="title m-0">TOTAL DEDUCTIONS</p>
                                        </td>
                                        <td class="bb">
                                            <p class="title m-0">'.$value->total_deductions.'</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="title">NET PAY</p>
                                        </td>
                                        <td>
                                            <p class="title bb">'.$value->net_pay.'</p>
                                        </td>
                                    </tr>
                                </tbody>
                                    
                            </table>
                        </div>

                        <div class="slip-footer">
                            <h4 class="m0">Prepared by:</h4>
                            <img src="'.$signature.'" style="max-width:50%;max-height:50%;padding-bottom:-20px">
                            <p><b>Annalie D. Conception</b></p>
                        </div>
                    </div>

                </body>
                </html>'
        );
        $customPaper = array(0,0,360,900);
        $pdf->setPaper($customPaper);
        return $pdf->stream();

    }
    
    public function resendPayroll($payroll_id){

        $payslip = Payroll::find($payroll_id);

        $payslip->sendToEmail();

        return redirect()->back()->with('status','Payslip succesfully sent to '. $payslip->email);

    }

  
    
}
