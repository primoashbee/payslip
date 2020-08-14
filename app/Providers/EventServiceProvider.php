<?php

namespace App\Providers;

use App\Events\EventPayrollInserted;
use App\Events\EventResendPayslip;
use App\Events\PayrollSendPayslip;
use App\Events\ResendBatchPayroll;
use App\Listeners\ListenerPayrollInserted;
use App\Listeners\ListenerResendBatchPayslip;
use App\Listeners\ListenerResendPayslip;
use App\Listeners\PayrollSendPayslipListen;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        EventPayrollInserted::class => [
            ListenerPayrollInserted::class,
        ],
        PayrollSendPayslip::class => [
            PayrollSendPayslipListen::class,
        ],
        EventResendPayslip::class => [
            ListenerResendPayslip::class,
        ],
        ResendBatchPayroll::class => [
            ListenerResendBatchPayslip::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
