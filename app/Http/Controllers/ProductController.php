<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Validator;



class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index','show']]);
    }

    public function index(){
        $products = Product::where('delete', false)->get();

        return response()->json([
            'message' => 'Get all product successfully',
            'products' => $products,
            'total'=>count($products)
        ], 201);
    }

    public function show($id)
    {
        $product = Product::where('id', $id)->first();

        return new ProductResource($product);
    }

    public function store(ProductRequest $request)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description'=>'required|string',
            'content'=>'required|string',
            'price'=>'required',
            'sale_price'=>'required',
            'hot'=>'required',
            'img' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'color'=>'required',
            'category_id'=>'required',
        ]);


        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $image_path = $request->file('img')->store('image', 'public');

        $product = Product::create(array_merge(
            $validator->validated(),
            [
                'slug' => Str::slug($request->title),
                'img'=>$image_path
            ]
        ));

        return new ProductResource($product);
    }

    public function update(ProductRequest $request, $id)
    {

        if (count($request->all())===0) {
            return response()->json(['message' => 'No data provided'], 400);
        }

        $product = Product::findOrFail($id);

        $product->update(array_merge(
            $request->all(),
            [
                'slug' => $request->title ? Str::slug($request->title) : $product->slug,
                'img' => $request->hasFile('img') ? $request->file('img')->store('image', 'public') : $product->img,
            ]
        ));


        return response()->json([
            'message' => 'Updated successfully!',
            'product_id' => $id
        ], 200);
    }

    public function destroy($id)
    {
        $affectedRows = Product::where('id', $id)->update(['delete'=>1]);

        if ($affectedRows > 0) {
            return response()->json([
                'message' => 'Delete successfully!',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Product not found or already deleted!',
            ], 404);
        }
    }
}
