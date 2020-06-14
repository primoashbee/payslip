<?php

namespace App;

use App\Events\EventResendPayslip;
use App\Events\PayrollSendPayslip;
use App\Mail\SendPayslipMail;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $fillable = [
            'email',
            'name',
            'position',
            'employement',
            'applicable',
            'monthly_rate',
            'daily_rate',
            'days_worked',
            'earned',

            'days_absent',
            'days_absent_amount',

            'minutes_tardiness',
            'minutes_tardiness_amount',

            'gross_compensation',
            'retro',
                

            'addtional_holiday',
            'addtional_holiday_amount',

            'overtime_amount',
            'taxable_compensation',
            'rice_subsidy',
            'account_payable',
   
            'other_additions_amount',
            'total_additions',
            'gross_pay',

            'withholding_tax',
            'sss_contribution',
            'phic_contribution',
            'hdmf_contribution',


            'coop_scc',
            'coop_loans',
            
            'sss_loan',
            'hdmf_loan',
            'hdmf_mp2',

            'ar',
            
            'total_deductions',
            'net_pay',
            'date_received',
            'batch_id'
    ];

    public function format($value){
        return '' . $value;
    }

    public function getMonthlyRateAttribute($value){
       
        return $this->format(number_format($value,2));  
    }

    public function getDailyRateAttribute($value){
        return $this->format(number_format($value,2));
    }

    public function getEarnedAttribute($value){
        return $this->format(number_format($value,2));
    }
    
    public function getDaysAbsentAmountAttribute($value){
        return $this->format(number_format($value,2));
    }

    public function getMinutesTardinessAmountAttribute($value){
        return $this->format(number_format($value,2));
    }

    public function getRetroAttribute($value){
        return $this->format(number_format($value,2));
    }

    public function getGrossCompensationAttribute($value){
        return $this->format(number_format($value,2));
    }

    public function getAdditionalHolidayAmountAttribute($value){
        return $this->format(number_format($value,2));
    }

    public function getOvertimeAmountAttribute($value){
        return $this->format(number_format($value,2));
    }

    public function getTaxableCompensationAttribute($value){
        return $this->format(number_format($value,2));
    }

    public function getAccountPayableAttribute($value){
        return $this->format(number_format($value,2));
    }

    public function getGrossPayAttribute($value){
        return $this->format(number_format($value,2));
    }
    public function getRiceSubsidyAttribute($value){
        return $this->format(number_format($value,2));
    }

    public function getSssContributionAttribute($value){
        return $this->format(number_format($value,2));
    }

    public function getPhicContributionAttribute($value){
        return $this->format(number_format($value,2));
    }

    public function getHdmfContributionAttribute($value){
        return $this->format(number_format($value,2));
    }

    public function getCoopSccAttribute($value){
        return $this->format(number_format($value,2));
    }

    public function getCoopLoansAttribute($value){
        return $this->format(number_format($value,2));
    }

    public function getHdmfLoanAttribute($value){
        return $this->format(number_format($value,2));
    }

    public function getHdmfMp2Attribute($value){
        return $this->format(number_format($value,2));
    }

    public function getArAttribute($value){
        return $this->format(number_format($value,2));
    }

    public function getTotalDeductionsAttribute($value){
        return $this->format(number_format($value,2));
    }

    public function getNetPayAttribute($value){
        return $this->format(number_format($value,2));
    }
    public function getOtherAdditionsAmountAttribute($value){
        return $this->format(number_format($value,2));
    }

    public static function batches(){
        $me = new static;
        return $me->select('batch_id','created_at','applicable')->distinct()->get();
    }

    public function sendToEmail(){
        $payroll = $this;
        
        event(new EventResendPayslip($payroll));
        
    }


}
