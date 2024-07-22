<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use Illuminate\Support\Str;
use App\Http\Requests\OrderDetailRequest;
use App\Http\Resources\OrderDetailResource;
use Illuminate\Support\Facades\Validator;



class OrderDetailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index','show']]);
    }

    public function index(){
        $orderDetails = OrderDetail::all();

        return response()->json([
            'message' => 'Get all order successfully',
            'orderDetails' => $orderDetails,
            'total'=>count($orderDetails)
        ], 201);
    }

    public function store(OrderDetailRequest $request)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'order_id'=>'required',
            'product_id'=>'required',
            'quantity'=>'required',
            'price'=>'required',
        ]);


        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }


        $order = OrderDetail::create(array_merge($validator->validated()));

        return new OrderDetailResource($order);
    }
}
