<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendPayslipMail extends Mailable
{
    use Queueable, SerializesModels;

    public $payroll;
    public $filepath;
    public $password;
    
    public $company_name = 'LIGHT Microfinance Inc.';

    public $logo;

    public function __construct($payroll, $filepath,$password)
    {
        $this->payroll = $payroll;
        $this->filepath = $filepath;
        $this->password = $password;
                
        $this->logo =  public_path('logo.png');;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Payslip for '.$this->payroll->applicable)
                ->markdown('email.send-payslip')
                ->attach($this->filepath);
    }
}
