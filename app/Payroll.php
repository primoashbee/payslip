<?php

namespace App;

use App\User;
use Carbon\Carbon;
use App\Mail\SendPayslipMail;
use App\Events\EventResendPayslip;
use App\Events\PayrollSendPayslip;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $appends = ['percentage'];
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
                

            'additional_holiday',
            'additional_holiday_amount',

            'overtime_amount',
            'taxable_compensation',
            'rice_subsidy',
            'account_payable',
            'account_payable_remarks',
   
            'other_additions_amount',
            'total_additions',
            'gross_pay',

            'withholding_tax',
            'sss_contribution',
            'phic_contribution',
            'hdmf_contribution',


            'coop_scc',
            'coop_savings',
            'coop_loans',
            
            'sss_loan',
            'hdmf_loan',
            'hdmf_mp2',

            'ar',
            'ar_remarks',
            
            'total_deductions',
            'net_pay',
            'date_received',
            'batch_id',
            'user_id'
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
    public function getWithholdingTaxAttribute($value){
        return $this->format(number_format($value,2));
    }

    public function getAccountPayableAttribute($value){
        return $this->format(number_format($value,2));
    }
    public function getAccountPayableRemarksAttribute($value){
        if($value==null || $value=="" || $value=="0"){
            return '-';
        }
        return $value;
    
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

    public function getSssLoanAttribute($value){
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
    public function getCoopSavingsAttribute($value){
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
    public function getArRemarksAttribute($value){
        
        if($value==null || $value=="" || $value=="0"){
            
            return '-';
        }
        return $value;
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
        return $me->select('batch_id','applicable','user_id')->distinct()->get();
    }
    public function getSeenAtAttribute($value){
        if($value==null){
            return 'Not yet viewed';
        }
        return Carbon::parse($value)->isoFormat('MMMM D, YYYY, h:mm:ss a');
    }
    public function getPercentageAttribute(){
        return round($this->getRawOriginal('net_pay') / $this->getRawOriginal('gross_pay'),2) * 100  .'%';
    }

    public function sendToEmail(){
        $payroll = $this;   
        event(new EventResendPayslip($payroll));
        
    }
    public function user(){
        return $this->belongsTo(User::class);
        
    }


}
