<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoiceDetails;
use Validator;


class InvoiceController extends Controller
{
    public function createInvoice(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'phone' => 'required',
            'total' => 'required',
            'currency' => 'required',
            'year' => 'required',
            'make' => 'required',
            'model' => 'required',
            'api_key' => 'required',
            'business_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $user_id = 1;
        if(auth()->user()){
            $user_id = auth()->user()->id;
        }
        $invoice = Invoice::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'total' => $request->total,
            'currency' => $request->currency,
            'car_id' => 1,
            'year' => $request->year,
            'make' => $request->make,
            'model' => $request->model,
            'user_id' =>  $user_id,
        ]);
        foreach($request->services as $service){
            $details = InvoiceDetails::create([
                'item' => $service['name'],
                'price' => $service['price'],
                'item_type' => $service['item_type'],
                'invoice_id' => $invoice->id,
            ]);
        }
        return response()->json([
            'code' => 200,
            'message' => 'Data saved successfully'
        ], 200);
    }
}
