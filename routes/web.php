<?php

use App\Payroll;
use Carbon\Carbon;
use App\Mail\TestEmail;
use App\Events\TestEvent;
use App\Jobs\JobSendPayslip;
use App\Mail\SendPayslipMail;
use App\Events\PayrollUploadSuccess;
use Illuminate\Support\Facades\Redis;
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


// Route::get('/mail',function(){
//    $payroll = Payroll::first();
//    return new SendPayslipMail($payroll,'heyy','ashbee',1);
// });

Route::get('/get/logo',function(){
    // Log::info('email read by '. $payroll_id);
    $payroll_id = request()->get('id');
    if($payroll_id!=null){
        Log::info('Loaded: '.$payroll_id);
        
        $p = Payroll::find($payroll_id);
        $p->seen_at = Carbon::now()->setTimezone('Asia/Singapore');
        $p->save();
        return response()->file(public_path('logo.png'));
    }
    
})->name('view.logo');
Auth::routes();


Route::group(['middleware' => ['auth']], function () {
    Route::get('/', function () {
        // dd(env('BROADCAST_DRIVER'));
        // Log::info('message');
        // event(new TestEvent('sup niggas'));
        return redirect()->route('home');
    });
    
    Route::get('/home', 'HomeController@index')->name('home');
    Route::post('/home', 'UploadController@upload')->name('upload.payroll');
    // Route::post('/logo.png', function(Request $request){
    //     dd($request->all());
    // });
    Route::get('/dl', 'UploadController@downloadTemplate')->name('download.template');
    Route::get('/user', 'UserController@changePassword')->name('changepass');
    Route::post('/user', 'UserController@updatePassword')->name('update.password');
    
    Route::get('/payrolls', 'PayrollController@list')->name('payroll.list');
    Route::get('/payrolls/{batch_id}', 'PayrollController@listByBatchId')->name('payrolls.batch_id');
    
    Route::get('/payrolls/view/{payroll_id}', 'PayrollController@viewPayroll')->name('view.payslip');
    Route::get('/payrolls/resend/{payroll_id}', 'PayrollController@resendPayroll')->name('view.resend-payslip');
        
});