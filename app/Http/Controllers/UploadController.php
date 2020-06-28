<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\PayrollImport;
use Illuminate\Support\Facades\App;
use App\Events\EventPayrollInserted;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function downloadTemplate(){
        $headers = array(
            'Content-Type: application/pdf',
          );
        
        
        return response()->download(public_path('Template V2.xlsx'));
    }

    public function upload(Request $request){
        $request->validate([
            'uploadFile' => 'required|mimes:xlsx'
        ],[
            'uploadFile.required' => 'Please upload file.',
            'uploadFile.mimes' => 'Invalid file type.',
        ]); 
        if($request->hasFile('uploadFile')){
            

            $batch_id = uniqid();
            Excel::import(new PayrollImport($batch_id), $request->file('uploadFile'));
            
            event(new EventPayrollInserted($batch_id));
            return redirect()->back()->with('status','Successfully Uploaded. Payslips will be sent to the respective e-mails');
        }
    }
}
