<?php

namespace App\Http\Controllers;

use PDF;
use App\Payroll;
use Illuminate\Http\Request;
use App\Exports\PayrollExport;
use App\Imports\PayrollTemplate;
use Excel;

class PayrollController extends Controller
{
    

    public function list(){
        $payrolls = Payroll::batches();

        return view('payrolls',compact('payrolls'));
    }
    public function listByBatchId(Request $request, $batch_id){

        if($request->has('print')){
            
            
            $file = $this->makePayrollList($batch_id);
            return response()->download($file);

        }
        $payrolls = Payroll::where('batch_id',$batch_id)->get();
        return view('payroll-list',compact('payrolls'));
    }
    public function viewPayroll($payroll_id){
        
        $value = Payroll::find($payroll_id);
        $percentage = round($value->getRawOriginal('net_pay') / $value->getRawOriginal('gross_compensation'),2) * 100;

        $logo = public_path('logo.png');
        $signature = public_path('signature.png');
        $pdf = PDF::loadView('payslip', compact('value','logo','signature'));
        $customPaper = array(0,0,360,1030);
        $pdf->setPaper($customPaper);
        
        $pdf->setPaper($customPaper);
        return $pdf->stream();

    }
    
    public function resendPayroll($payroll_id){

        $payslip = Payroll::find($payroll_id);

        $payslip->sendToEmail();

        return redirect()->back()->with('status','Payslip succesfully sent to '. $payslip->email);

    }

    public function makePayrollList($batch_id){
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(public_path('templates/Payroll List.xlsx'));
        $worksheet = $spreadsheet->getActiveSheet();
        $lists = Payroll::where('batch_id',$batch_id)->get();
        if ($lists->count()>0) {
            $covers = $lists->first()->applicable;
            $worksheet->getCell('B6')->setValue($covers);

            //row
            $row = 9; //start row
            
            foreach($lists as $list){
                $worksheet->getCell('A'.$row)->setValue($list->email);
                $worksheet->getCell('B'.$row)->setValue($list->name);
                $worksheet->getCell('C'.$row)->setValue($list->gross_pay);
                $worksheet->getCell('D'.$row)->setValue($list->net_pay);
                $worksheet->getCell('E'.$row)->setValue($list->created_at->format('F d, Y'));
                $worksheet->getCell('F'.$row)->setValue($list->seen_at);
                $row++;
            }
            
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $filepath = storage_path('Payroll list for '.$covers.'.xlsx');
            $writer->save($filepath);
            return $filepath;
        }
    
    
        
    }
  
    
}
