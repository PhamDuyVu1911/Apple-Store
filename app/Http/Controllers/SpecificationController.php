<?php

namespace App\Http\Controllers;

use App\Models\Specification;
use Illuminate\Support\Str;
use App\Http\Requests\SpecificationRequest;
use App\Http\Resources\SpecificationResource;
use Illuminate\Support\Facades\Validator;



class SpecificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index']]);
    }

    public function index(){
        $specifications = Specification::where('delete', false)->get();

        return response()->json([
            'message' => 'Get all specification successfully',
            'specifications' => $specifications,
            'total'=>count($specifications)
        ], 201);
    }


    public function store(SpecificationRequest $request)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'key' => 'required|string',
            'value' => 'required|string',
            'product_id' => 'required',
        ]);


        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }


        $specification = Specification::create(array_merge($validator->validated()));

        return new SpecificationResource($specification);
    }

    public function update(SpecificationRequest $request, $id)
    {

        if (count($request->all())===0) {
            return response()->json(['message' => 'No data provided'], 400);
        }

        $specification = Specification::findOrFail($id);

        $specification->update(array_merge($request->all()));


        return response()->json([
            'message' => 'Updated successfully!',
            'specification_id' => $id
        ], 200);
    }

    public function destroy($id)
    {
        $affectedRows = Specification::where('id', $id)->update(['delete'=>1]);

        if ($affectedRows > 0) {
            return response()->json([
                'message' => 'Delete successfully!',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Specification not found or already deleted!',
            ], 404);
        }
    }
}
