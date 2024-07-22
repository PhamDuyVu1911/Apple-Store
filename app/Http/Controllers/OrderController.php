<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Str;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use Illuminate\Support\Facades\Validator;



class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index','show']]);
    }

    public function index(){
        $orders = Order::where('delete', false)->get();

        return response()->json([
            'message' => 'Get all order successfully',
            'orders' => $orders,
            'total'=>count($orders)
        ], 201);
    }

    public function show($id)
    {
        $order = Order::where('id', $id)->first();

        return new OrderResource($order);
    }

    public function store(OrderRequest $request)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'order_date'=>'required',
            'name_receive'=>'required|string',
            'phone_receive'=>'required|string',
            'address_receive'=>'required|string',
            'note'=>'required|string',
            'total_money'=>'required',
            'status_order'=>'required',
            'user_id'=>'required',
        ]);


        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }


        $order = Order::create(array_merge($validator->validated()));

        return new OrderResource($order);
    }

    public function update(OrderRequest $request, $id)
    {

        if (count($request->all())===0) {
            return response()->json(['message' => 'No data provided'], 400);
        }

        $order = Order::findOrFail($id);

        $order->update(array_merge($request->all()));


        return response()->json([
            'message' => 'Updated successfully!',
            'order_id' => $id
        ], 200);
    }

    public function destroy($id)
    {
        $affectedRows = Order::where('id', $id)->update(['delete'=>1]);

        if ($affectedRows > 0) {
            return response()->json([
                'message' => 'Delete successfully!',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Order not found or already deleted!',
            ], 404);
        }
    }
}
