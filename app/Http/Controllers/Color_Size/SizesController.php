<?php

namespace App\Http\Controllers\Color_Size;

use App\ApiTrait;
use App\Models\Size;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SizesController extends Controller {
    use ApiTrait;
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $sizes = Size::all();
        return $this->successResponse($sizes, 'All sizes', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:1|max:20'
        ]);
        if ($validator->fails()) {
            return $this->failedValidationResponse($validator->errors());
        }
        $size = Size::create($validator->validated());
        return $this->successResponse($size, 'Size Created successfully', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        $size = Size::find($id);
        if (!$size) {
            return $this->errorResponse('Size not found', 404);
        }
        return $this->successResponse($size, "Show the size");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'sometimes|string|min:1|max:20'
            ]);
            if ($validator->fails()) {
                return $this->failedValidationResponse($validator->errors());
            }
            $size = Size::findOrFail($id);
            if ($request->has('name')) {
                $size->update(['name' => $request->name]);
            }
            return $this->successResponse($size, 'Size updated successfully');
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse('Size not found', 404);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        $size = Size::find($id);
        if (!$size) {
            return $this->errorResponse('Size not found', 404);
        }
        $size->delete();
        return $this->successResponse([], "Delete the size");
    }
}
