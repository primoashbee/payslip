<?php

use App\Events\PayrollUploadSuccess;
use App\Payroll;
use App\Mail\TestEmail;
use App\Events\TestEvent;
use App\Mail\SendPayslipMail;
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
    // dd(env('BROADCAST_DRIVER'));
    Log::info('message');
    //event(new PayrollUploadSuccess('sup niggas'));
    //return redirect()->route('home');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/home', 'UploadController@upload')->name('upload.payroll');
Route::get('/dl', 'UploadController@downloadTemplate')->name('download.template');

Route::get('/payrolls', 'PayrollController@list')->name('payroll.list');
Route::get('/payrolls/{batch_id}', 'PayrollController@listByBatchId')->name('payrolls.batch_id');

Route::get('/payrolls/view/{payroll_id}', 'PayrollController@viewPayroll')->name('view.payslip');
Route::get('/payrolls/resend/{payroll_id}', 'PayrollController@resendPayroll')->name('view.resend-payslip');

