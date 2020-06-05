<?php

use App\Mail\SendPayslipMail;
use App\Mail\TestEmail;
use App\Payroll;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/mail', function () {
    Mail::to('ashbeemorgado11@gmail.com')->send(new TestEmail);
});

Route::get('/td', function () {
    return view('test');
});

Route::get('/payslip',function(){
    $value = Payroll::first();
    
    $pdf = app()->make('dompdf.wrapper');    
    $pdf->loadHTML('
        <html>
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        </head>
        <style>
            h3{
                margin: 0 0 0 0
            }
            table.no-border tbody tr td{
                border:1px solid transparent
            }

            .with-border{
            }

        </style>
        <body>
        <div class="container">
        <h5>LIGHT Microfinance Incorporated</h5>
        <h5>MAIN OFFICE</h5>
        <h5>'.$value->applicable.'</h5>
            <p class="h4 font-weight-bolder text-center"> '.$value->name.' </p>
            <table class="table no-border">
                <tbody>
                <tr style="border-top: none !important;">
                    <td class="no-border text-left"><p>'.$value->position.'</p></td>
                    <td class="text-right"><p>'.$value->employement.'</p></td>
                </tr>
                <tr style="margin-top:25px">
                    <td class="text-left"> <b>BASIC SALARY (Monthly)</b></td>
                    <td class="text-right"> <b>'.$value->monthly_rate.'</b></td>
                </tr>
                
                <tr class="noBorder">
                    <td class="text-left">Daily Rate</td>
                    <td class="text-right">'.$value->monthly_rate.'</td>
                </tr>
                <tr>
                    <td class="text-left"><b>ACTUAL NO. OF WEEK DAYS PAID</b></td>
                    <td class="text-right"><b>'.$value->earned.'</b></td>
                </tr>
                <tr>
                    <td class="text-left">Less: Absences</td>
                    <td class="text-right">'.$value->days_absent_amount.'</b></td>
                </tr>
                <tr>
                    <td class="text-left">Less: Tardiness</td>
                    <td class="text-right">'.$value->minutes_tardiness_amount.'</b></td>
                </tr>
                <tr>
                    <td class="text-left">Add/Less: Rate Adjustments</td>
                    <td class="text-right">'.$value->retro.'</b></td>
                </tr>
                <tr>
                    <td class="text-left"><b>GROSS COMPENSATION</b></td>
                    <td class="text-right">'.$value->gross_compensation.'</b></td>
                </tr>
                <tr>
                    <td class="text-left">Add: Holiday Pay</td>
                    <td class="text-right">'.$value->additional_holiday_amount.'</b></td>
                </tr>
                <tr>
                    <td class="text-left">Add: Overtime Pay</td>
                    <td class="text-right">'.$value->overtime_amount.'</b></td>
                </tr>


                <tr>
                    <td class="text-left"><b> TAXABLE COMPENSATION INCOME</b></td>
                    <td class="text-right">'.$value->taxable_compensation.'</b></td>
                </tr>

                <tr>
                    <td class="text-left">ADD: OTHER ADJUSTMENTS</td>
                    <td class="text-right">'.$value->additional_holiday_amount.'</td>
                </tr>
                
                <tr>
                    <td class="text-left">EB: RICE SUBSIDY</td>
                    <td class="text-right">'.$value->rice_subsidy.'</td>
                </tr>

                <tr>
                    <td class="text-left">ACCOUNTS PAYABLE</td>
                    <td class="text-right">'.$value->account_payable.'</td>
                </tr>

                <tr>
                    <td class="text-left"><b> GROSS PAY</b></td>
                    <td class="text-right">'.$value->gross_pay.'</b></td>
                </tr>

                <tr>
                    <td class="text-left"><b>LESS: DEDUCTIONS</b></td>
                    <td class="text-right"></td>
                </tr>

                <tr>
                    <td class="text-left">A/P: Witholding Tax</td>
                    <td class="text-right">'.$value->withholding_tax.'</td>
                </tr>
                <tr>
                    <td class="text-left">A/P: SSS Contribution</td>
                    <td class="text-right">'.$value->sss_contribution.'</td>
                </tr>
                <tr>
                    <td class="text-left">A/P: PHIC Contribution</td>
                    <td class="text-right">'.$value->phic_contribution.'</td>
                </tr>
                <tr>
                    <td class="text-left">A/P: HDMF Contribution</td>
                    <td class="text-right">'.$value->hdmf_contribution.'</td>
                </tr>
                <tr>
                    <td class="text-left">A/P: Coop Share Capital</td>
                    <td class="text-right">'.$value->coop_scc.'</td>
                </tr>
                <tr>
                    <td class="text-left">A/P: Coop Loans</td>
                    <td class="text-right">'.$value->coop_loan.'</td>
                </tr>
                <tr>
                    <td class="text-left">A/P: SSS Loans</td>
                    <td class="text-right">'.$value->sss_loan.'</td>
                </tr>
                <tr>
                    <td class="text-left">A/P: HDMF Loans</td>
                    <td class="text-right">'.$value->hdmf_loan.'</td>
                </tr>
                <tr>
                    <td class="text-left">A/P: HDMF MP2</td>
                    <td class="text-right">'.$value->hdmf_mp2.'</td>
                </tr>
                </tr>
                <tr>
                    <td class="text-left">AR</td>
                    <td class="text-right">'.$value->ar.'</td>
                </tr>
                <tr>
                    <td class="text-left"><b>Total Deductions</b></td>
                    <td class="text-right"><b>'.$value->total_deductions.'</b></td>
                </tr>
                <tr>
                    <td class="text-left"><b>Net Pay</b></td>
                    <td class="text-right"><b>'.$value->net_pay.'</b></td>
                </tr>
                </tbody>
            </table>
            <p> Prepared By: </p>
            <img src="css/signature.png" style="max-width:150px;max-height:75px;margin-bottom:-50px">
            <p> Annalie D. Concepcion </p>
        </div>
        </body>
        </html>
    ');
    return $pdf->stream();
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/home', 'UploadController@upload')->name('upload.payroll');

Route::get('/dl', 'UploadController@downloadTemplate')->name('download.template');

