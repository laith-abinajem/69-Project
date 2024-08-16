<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use PDF;

class InvoiceController extends Controller
{
    public function downloadPDF($id){
        $data = Invoice::with('user')->where('id',$id)->first();
        $work_sheet = 'work-sheet.pdf';
        $companyLogo = $data->user->getFirstMediaUrl('company_logo');
        $companyName = $data->user()->first()->company_name;
        $back_half = $data->invoiceDetails->where('item','BACK HALF')->first();
        $front_ws = $data->invoiceDetails->where('item','FRONT W.S')->first();
        $front_two = $data->invoiceDetails->where('item','FRONT TWO')->first();
        $stripe = $data->invoiceDetails->where('item','STRPE')->first();
        $roof = $data->invoiceDetails->where('item','SUN ROOF')->first();
        $ppf ;
        if($data->invoiceDetails->where('item','TRACK PACK')->first()){
            $ppf = 'TRACK PACK';
        }else if($data->invoiceDetails->where('item','PARTIAL FRONT')->first()){
            $ppf = 'PARTIAL FRONT';
        }else if($data->invoiceDetails->where('item','FULL FRONT')->first()){
            $ppf = 'FULL FRONT';
        }else if($data->invoiceDetails->where('item','FULL KIT')->first()){
            $ppf = 'FULL KIT';
        }else{
            $ppf = '';
        }
        $paint = $data->invoiceDetails->where('item','DETAIL PAINT CORRECTION')->first();
        $stepNumber = null;
        if ($paint) {
            $parts = explode(' ', $paint->item_type); 
            $stepNumber = $parts[2] ?? ''; 
        }

        $detail ;
        if($data->invoiceDetails->where('item','DETAIL EXTIRIOR')->first()){
            $detail = 'EXTIRIOR';
        }else if($data->invoiceDetails->where('item','DETAIL INTIRIOR')->first()){
            $detail = 'INTIRIOR';
        }else if($data->invoiceDetails->where('item','INOUT')->first()){
            $detail = 'INOUT';
        }else{
            $detail = '';
        }
        $pdf = PDF::loadView('dashboard.invoice',compact('data','companyLogo','companyName','front_ws','back_half','front_two','stripe','roof','ppf','stepNumber','detail'));
        return $pdf->stream($work_sheet);
    }
    public function downloadPDFDirect($id){
        $data = Invoice::with('user')->where('id',$id)->first();
        $work_sheet = 'work-sheet.pdf';
        $companyLogo = $data->user->getFirstMediaUrl('company_logo');
        $companyName = $data->user()->first()->company_name;
        $pdf = PDF::loadView('dashboard.invoice',compact('data','companyLogo','companyName'));
       
        return $pdf->download($work_sheet);
    }

    public function index(Request $request){
        $query = Invoice::where('user_id', auth()->user()->id);

        if ($request->has('from') && $request->has('to')) {
            $from = $request->input('from');
            $to = $request->input('to');
            
            // Ensure the dates are formatted correctly
            $query->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59']);
        }
    
        $data = $query->get();
      
        return view('dashboard.pages.invoice.index',compact('data'));
    }
    public function delete(Request $request,$id){
        $data = Invoice::find($id);
        $data->delete();
        toast('Success','success');
        return redirect()->route('dashboard.invoices.index');
    }
}
