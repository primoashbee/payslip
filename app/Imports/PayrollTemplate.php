<?php

namespace App\Imports;

use App\Payroll;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\ToModel;

class PayrollTemplate implements ToArray
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function __construct()
    {
        
    }
    public function array(array $row)
    {
        // return new Payroll([
        //     //
        // ]);
    }
}
