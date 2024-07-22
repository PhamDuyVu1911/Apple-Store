<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use Illuminate\Support\Facades\Validator;


class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index']]);
    }

    public function index(){
        $categories = Category::where('delete', false)->get();

        return response()->json([
            'message' => 'Get all category successfully',
            'categories' => $categories,
            'total'=>count($categories)
        ], 201);
    }

    public function store(CategoryRequest $request)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|unique:categories',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $category = Category::create(array_merge(
            $validator->validated(),
            ['slug' => Str::slug($request->title)]
        ));

        return new CategoryResource($category);
    }

    public function update(CategoryRequest $request, $id){
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $category_id = Category::where('id', $id)->update(array_merge(
            $validator->validated(),
            ['slug' => Str::slug($request->title)]
        ));

        return response()->json([
            'message'=>'Updated successfully!',
            'category_id'=>$category_id
        ], 200);
    }

    public function destroy($id)
    {
        $affectedRows = Category::where('id', $id)->update(['delete'=>1]);

        if ($affectedRows > 0) {
            return response()->json([
                'message' => 'Delete successfully!',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Category not found or already deleted!',
            ], 404);
        }
    }
}
