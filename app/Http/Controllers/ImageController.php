<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Http\Requests\ImageRequest;
use App\Http\Resources\ImageResource;
use Illuminate\Support\Facades\Validator;



class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index','show']]);
    }

    public function index(){
        $images = Image::where('delete', false)->get();

        return response()->json([
            'message' => 'Get all image successfully',
            'images' => $images,
            'total'=>count($images)
        ], 201);
    }

    public function store(ImageRequest $request)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'img' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'product_id'=>'required',
        ]);


        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $image_path = $request->file('img')->store('image', 'public');

        $image = Image::create(array_merge(
            $validator->validated(),
            [
                'path_name'=>$image_path
            ]
        ));

        return new ImageResource($image);
    }

    public function update(ImageRequest $request, $id)
    {

        if (count($request->all())===0) {
            return response()->json(['message' => 'No data provided'], 400);
        }

        $image = Image::findOrFail($id);

        $image->update(array_merge(
            $request->all(),
            [
                'img' => $request->hasFile('img') ? $request->file('img')->store('image', 'public') : $image->img,
            ]
        ));


        return response()->json([
            'message' => 'Updated successfully!',
            'image_id' => $id
        ], 200);
    }

    public function destroy($id)
    {
        $affectedRows = Image::where('id', $id)->update(['delete'=>1]);

        if ($affectedRows > 0) {
            return response()->json([
                'message' => 'Delete successfully!',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Image not found or already deleted!',
            ], 404);
        }
    }
}
