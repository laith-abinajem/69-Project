<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoiceDetails;

/**
 * @OA\Info(title="My First API", version="0.1")
 */
class InvoiceController extends Controller
{
/**
 * @OA\Post(
 *     path="/createInvoice",
 *     summary="Create a new invoice",
 *     tags={"Invoice"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name","amount"},
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="amount", type="number")
 *         )
 *     ),
 *     @OA\Response(response=200, description="Invoice created successfully"),
 *     @OA\Response(response=400, description="Invalid input")
 * )
 */
    public function createInvoice(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required',
            'total' => 'required',
            'currency' => 'required|string',
            'year' => 'required|string',
            'make' => 'required|string',
            'model' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $car = Car::where('Make',$request->make)->where('Year',$request->year)->where('Model',$request->model)->first();
        if(!$car){
            return response()->json($car->errors(), 400);
        }
        $invoice = Invoice::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'total' => $request->total,
            'currency' => $request->currency,
            'card_id' => $car->id,
            'user_id' => auth()->user()->id,
        ]);
        foreach($request->services as $service){
            $details = InvoiceDetails::create([
                'name' => $service->name,
                'price' => $service->price,
                'item_type' => $service->item_type,
                'invoice_id ' => $invoice->id ,
            ]);
        }
        return response()->json([
            'code' => 200,
            'message' => 'Data saved successfully'
        ], 200);
    }
}
