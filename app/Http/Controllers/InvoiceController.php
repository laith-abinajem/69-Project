<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class InvoiceController extends Controller
{
    public function downloadPDF(){
        $data = [];
        $work_sheet = 'work-sheet.pdf';
        //  if($data  && $data->customers){
        //     $work_sheet = $data->customers->name . '-' . date('m-d-Y', strtotime($data->date)) . '.pdf';
        // }
        $pdf = PDF::loadView('dashboard.invoice',compact('data'));
       
        return $pdf->stream($work_sheet);
    }
}
