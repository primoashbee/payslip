<?php

namespace App\Imports;

use App\Payroll;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithMappedCells;

class PayrollImport implements ToModel, WithHeadingRow,WithCalculatedFormulas, WithValidation
{
    use Importable;

    public $start_date;
    public $end_date;
    public $ctr = 0;
    public $batch_id;

    public function __construct($batch_id){
        $this->batch_id = $batch_id;
    }

    public function model(array $row)
    {
        
        if($this->ctr == 0){
            
            $this->start_date = Carbon::parse(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['start_date']));
            $this->end_date = Carbon::parse(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['end_date']));
            
        }
        
        $this->ctr++;
        
        return new Payroll([
            'email' => $row['e_mail_address'],
            'name' => $row['employee_name'],
            'position' => $row['title'],
            'employement' => $row['status'],
            'applicable' => $row['month'],
            'monthly_rate' => $row['salary'],
            'daily_rate' => $row['rate'],
            'days_worked' => $row['days_worked'],
            'earned' => $row['earned'],

            'days_absent' => $row['days_absent'],
            'days_absent_amount' => $row['absent_amount'],

            'minutes_tardiness' => $row['in_mins'],
            'minutes_tardiness_amount' => $row['tardiness_amount'],

            'retro' => $row['retro'],
            'gross_compensation' => $row['gross_compensation'],

            'addtional_holiday' => $row['no_of_days'],
            'addtional_holiday_amount' => $row['holiday_amount'],

            'overtime_amount' => $row['overtime_pay'],
            'taxable_compensation' => $row['taxable_compensation'],
            'rice_subsidy' => $row['rice_subsidy'],
            'account_payable' => $row['ap'],
            
            'other_additions_amount' => $row['othersremarks_addition_amount'],
            'total_additions' => $row['additions'],
            'gross_pay' => $row['gross_pay'],
            
            'withholding_tax' => $row['wtax'],
            'sss_contribution' => $row['sss_contribution'],
            'phic_contribution' => $row['phic_contribution'],
            'hdmf_contribution' => $row['hdmf_contribution'],

            'coop_scc' => $row['coop_scc'],
            'coop_loans' => $row['coop_loans'],
            

            'sss_loan' => $row['sss_loan'],
            'hdmf_loan' => $row['hdmf_loan'],
            'hdmf_mp2' => $row['hdmf_mp2'],
            
            'ar'=>$row['ar'],

            'total_deductions' => $row['total_deductions'],
            'net_pay' => $row['net_pay'],
            'date_received' => null,

            'start_date' => $this->start_date,
            'cut_off_date' =>$this->end_date,
            'batch_id' => $this->batch_id,
        ]);
        
    }

    public function headingRow(): int
    {
        return 4;
    }
    public function rules(): array
    {
       
        return [
             'e_mail_address' => 'required|email',
             'employee_name' => 'required',
             'title' => 'required',
             'status' => 'required',
             'salary' => 'required|gt:0',
             'days_worked' => 'required|gte:0',
             'earned' => 'required|gte:0',
             'days_absent' => 'sometimes|gte:0',
             'absent_amount' => 'sometimes|gte:0',
             'in_mins' => 'sometimes|gte:0',
             'tardiness_amount' => 'sometimes|gte:0',

             'retro' => 'sometimes|gte:0',

             'gross_compensation' => 'required|gte:0',

             'no_of_days' => 'sometimes|gte:0',
             'holiday_amount' => 'sometimes|gte:0',

             'overtime_pay' => 'sometimes|gte:0',
             'taxable_compensation' => 'required|gte:0',
             'rice_subsidy' => 'sometimes|gte:0',
             'ap' => 'sometimes|gte:0',

             'othersremarks_addition_amount' => 'sometimes|gte:0',

             'additions' => 'sometimes|gte:0',

             'gross_pay' => 'required|gte:0',

             'wtax' => 'sometimes|gte:0',

             'sss_contribution' => 'sometimes|gte:0',
             'phic_contribution' => 'sometimes|gte:0',
             'hdmf_contribution' => 'sometimes|gte:0',

                          
             'coop_scc' => 'sometimes|gte:0',
             'coop_loans' => 'sometimes|gte:0',

             'sss_loan' => 'sometimes|gte:0',
             'hdmf_loan' => 'sometimes|gte:0',
             
             'hdmf_mp2' => 'sometimes|gte:0',
             
             'ar' => 'sometimes|gte:0',
             'total_deductions' => 'sometimes|gte:0',
             'net_pay' => 'required|gte:0',

            
        ];
    }
    public function customValidationMessages()
    {
        return [
            'e_mail_address.email' => 'Must be a valid E-mail address',
            'e_mail_address.required' => 'Must be a valid E-mail address',

            'employee_name.required' => 'Employee name is required',
            'title.required' => 'Employe position/title is required',
            'salary.required' => 'Monthly Salary is required',
            'salary.gt' => 'Monthly Salary must be greater than 0',

            'days_worked.required' => 'Days work is required',
            'days_worked.gte' => 'Days work must be greater than or equal to 0',

            'earned.required' => 'Salaries Earned is required',
            'earned.gte' => 'Salaries Earned must be greater than or equal to 0',

            'days_absent.gte' => 'Days Absent must be greater than or equal to 0',

            'absent_amount.gte' => 'Days Amount must be greater than or equal to 0',

            'in_mins.gte' => 'Tardiness in minutes Amount must be greater than or equal to 0',

            
            'retro.gte' => 'Retro Adjustment  must be greater than or equal to 0',


            'gross_compensation.required' => 'Gross Compensation is required',
            'gross_compensation.gte' => 'Gross Compensation must be greater than or equal to 0',


            'no_of_days.gte' => 'Additional Holiday No. of days must be greater than or equal to 0',
            
            'holiday_amount.gte' => 'Holiday amount pay  must be greater than or equal to 0',
            
            'overtime_pay.gte' => 'Overtime Pay must be greater than or equal to 0',
            

            'taxable_compensation.required' => 'Taxable Compensation is required',
            'taxable_compensation.gte' => 'Taxable Compensation must be greater than or equal to 0',


            'rice_subsidy.gte' => 'Rice subsidy must be greater than or equal to 0',

            'ap.gte' => 'Account Payable must be greater than or equal to 0',

            
            'othersremarks_addition_amount.gte' => 'Others/Remarks Addition amount must be greater than or equal to 0',

            'additions.gte' => 'Additions must be greater than or equal to 0',
            
            'gross_pay.required' => 'Gross Pay is required',
            'gross_pay.gte' => 'Gross Pay must be greater than or equal to 0',
            
            'wtax.gte' => 'Witholding Tax must be greater than or equal to 0',
            'sss_loan.gte' => 'SSS Loan must be greater than or equal to 0',
            'hdmf_loan.gte' => 'HDMF Loan must be greater than or equal to 0',
            'hdmf_mp2.gte' => 'HDMF MP2 must be greater than or equal to 0',
            'coop_scc.gte' => 'Coop SCC must be greater than or equal to 0',
            'coop_savings.gte' => 'Coop Savings must be greater than or equal to 0',
            'coop_loans.gte' => 'Coop Loans must be greater than or equal to 0',
            'otherremarks_deduction_amount.gte' => 'Others/Remarks Deductions must be greater than or equal to 0',
            'total_deductions.gte' => 'Total Deductions must be greater than or equal to 0',
            'net_pay.required' => 'Net pay is required',
            'net_pay.gte' => 'Net pay must be greater than or equal to 0',
            







            
    

           
        ];
    }


    
}
