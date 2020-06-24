<?php

namespace App\Listeners;

use App\Payroll;
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
            $pdf = app()->make('dompdf.wrapper');
            $percentage = round($value->getRawOriginal('net_pay') / $value->getRawOriginal('gross_compensation'),2) * 100;
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
                        height: 1150px;
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
                        table tbody tr td:nth-child(2) {
                            text-align:right;
                        }
                    </style>
                    <body>

                        <div class="slip-container">
                            <div class="slip-header">
                                <img src="'.$logo.'" style="max-width:50%;max-height:50%">
                                <p class="mx-0">MAIN OFFICE</p>
                                <p class="mx-0">'.$value->applicable.'</p>
                                <br>
                                <h4 class="mx-0 text-left">'.$value->name.'</h4>
                                <br>
                                <div>
                                
                                    <span class="text-left" style="margin-left:25px"><i>'.$value->position.'</i></span>
                                    <span class="float-right m0" style="margin-right:5px" ><i>'.$value->employement.'</i></span>
                                </div>
                            </div>

                            <div class="slip-body">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <p class="title m-0">BASIC SALARY (MONTHLY)</p>
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
                                            <td><b>Gross pay for the period </b><i>('.$value->days_worked.' days)</i></td>
                                            <td><b>'.$value->earned.'</b></td>
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
                                                Add: Other Adjustments
                                            </td>
                                            <td>
                                                '.$value->other_additions_amount.'
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>EB: Rice Subsidy</td>
                                            <td>'.$value->rice_subsidy.'</td>
                                        </tr>
                                        <tr>
                                            <td>Accounts Payable</td>
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
                                                <p class=" bb"><b>'.$value->net_pay.'</b><span style=" font-size:12px !important; padding-bottom: -50px !important">('.$percentage.'%)</span></p>
                                            </td>
                                        </tr>
                                    </tbody>
                                        
                                </table>
                            </div>

                            <div class="slip-footer">
                                <br>
                                <br>
                                <h4 class="m0">Prepared by:</h4>
                                <img src="'.$signature.'" style="max-width:50%;max-height:50%;padding-bottom:-20px">
                                <p><b>Annalie D. Conception</b></p>
                                <p style="margin-top:-15px"><i>Unit Head - General Accounting</i></p>
                            </div>
                        </div>

                    </body>
                    </html>'
            );
            $customPaper = array(0,0,360,950);
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
