<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use PDF;

class InvoiceController extends Controller
{
    public function downloadPDF($id){
        $data = Invoice::where('id',$id)->first();
        $work_sheet = 'work-sheet.pdf';
        $companyLogo = $data->user->getFirstMediaUrl('company_logo');
        $pdf = PDF::loadView('dashboard.invoice',compact('data','companyLogo'));
       
        return $pdf->stream($work_sheet);
    }

    public function index(Request $request){
        $data = Invoice::where('user_id',auth()->user()->id)->get();
      
        return view('dashboard.pages.invoice.index',compact('data'));
    }
}
