<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoiceDetails;
use Validator;

/**
 * @OA\Info(title="My First API", version="0.1")
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
class InvoiceTestController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/createInvoiceTest",
     *     summary="Create a new invoice",
     *     tags={"Invoice"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","customer_id", "phone", "total", "currency", "year", "make", "model", "services"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="customer_id", type="number"),
     *             @OA\Property(property="phone", type="number"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="total", type="number"),
     *             @OA\Property(property="currency", type="string"),
     *             @OA\Property(property="year", type="number"),
     *             @OA\Property(property="make", type="string"),
     *             @OA\Property(property="model", type="string"),
     *             @OA\Property(property="business_id", type="string"),
     *             @OA\Property(property="api_key", type="string"),
     *             @OA\Property(
     *                 property="services",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     required={"name", "price", "item_type"},
     *                     @OA\Property(property="name", type="string"),
     *                     @OA\Property(property="price", type="number"),
     *                     @OA\Property(property="item_type", type="string")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Invoice created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="code", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Data saved successfully")
     *         )
     *     ),
     *     @OA\Response(response=400, description="Invalid input")
     * )
     */
    public function createInvoiceTest(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'customer_id' => 'required|max:255',
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
            'customer_id' => $request->customer_id,
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
        $invoice->delete();
        $details->delete();
        return response()->json([
            'code' => 200,
            'message' => 'Data saved successfully'
        ], 200);
    }
}
