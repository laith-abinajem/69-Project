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
        $pdf = PDF::loadView('dashboard.invoice',compact('data','companyLogo','companyName'));
       
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
