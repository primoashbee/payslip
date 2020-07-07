<?php

namespace App\Exports;

use App\Payroll;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PayrollExport implements FromView
{
    use Exportable;

    public $batch_id;
    public function __construct(string $batch_id)
    {
        $this->batch_id = $batch_id;
    }
    // public function collection()
    // {
    //     return Payroll::all();
    // }
    public function view(): View
    {
        
        return view('exports.payrolls', [
            'payrolls' => Payroll::where('batch_id',$this->batch_id)->get()
        ]);
    }
    // public function query(){
    //     return Payroll::query()->where('batch_id',$this->batch_id);
    // }
}
