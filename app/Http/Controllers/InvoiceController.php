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
        $back_half = $data->invoiceDetails->filter(function($detail) {
            return stripos($detail->item, 'BACK HALF') !== false;
        })->first();
        $front_ws = $data->invoiceDetails->filter(function($detail) {
            return stripos($detail->item, 'FRONT W.S') !== false;
        })->first();
        $front_two = $data->invoiceDetails->filter(function($detail) {
            return stripos($detail->item, 'FRONT TWO') !== false;
        })->first();
        $stripe = $data->invoiceDetails->filter(function($detail) {
            return stripos($detail->item, 'STRIPE') !== false; 
        })->first();
        $roof = $data->invoiceDetails->filter(function($detail) {
            return stripos($detail->item, 'SUN ROOF') !== false;
        })->first();
        $ppf ;
        if ($data->invoiceDetails->filter(function($detail) {
            return stripos($detail->item, 'TRACK PACK') !== false;
        })->first()) {
            $ppf = 'TRACK PACK';
        } elseif ($data->invoiceDetails->filter(function($detail) {
            return stripos($detail->item, 'PARTIAL FRONT') !== false;
        })->first()) {
            $ppf = 'PARTIAL FRONT';
        } elseif ($data->invoiceDetails->filter(function($detail) {
            return stripos($detail->item, 'FULL FRONT') !== false;
        })->first()) {
            $ppf = 'FULL FRONT';
        } elseif ($data->invoiceDetails->filter(function($detail) {
            return stripos($detail->item, 'FULL KIT') !== false;
        })->first()) {
            $ppf = 'FULL KIT';
        } else {
            $ppf = '';
        }
        $paint = $data->invoiceDetails->filter(function($detail) {
            return stripos($detail->item, 'Detail Paint Correction') !== false;
        })->first();
        
        $stepNumber = null;
        
        if ($paint) {
            // Assuming the step number is the second-to-last element in the string
            // Example: "Detail Paint Correction - Tintix - 4 Step"
            $parts = explode(' ', $paint->item);
            
            // Find the step number (e.g., the number before the word 'Step')
            $stepKey = array_search('Step', $parts);
            if ($stepKey !== false && isset($parts[$stepKey - 1])) {
                $stepNumber = $parts[$stepKey - 1]; // This should be the step number (e.g., '4')
            }
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
