<?php

namespace App\Http\Controllers\Color_color;

use App\ApiTrait;
use App\Models\Color;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ColorsController extends Controller {
    use ApiTrait;
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $colors = Color::all();
        return $this->successResponse($colors, "All colors");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:50',
            'hex' => 'sometimes|regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'
        ]);
        if ($validator->fails()) {
            return $this->failedValidationResponse($validator->errors());
        }
        $color = Color::create($validator->validated());
        return $this->successResponse($color, 'Color Created successfully', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        $color = Color::find($id);
        if (!$color) {
            return $this->errorResponse('Color not found', 404);
        }
        return $this->successResponse($color, "Show the color");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'sometimes|string|min:3|max:50',
                'hex' => 'sometimes|regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'
            ]);
            if ($validator->fails()) {
                return $this->failedValidationResponse($validator->errors());
            }
            $color = Color::findOrFail($id);
            $color->update([
                'name' => $request->name ?? $color->name,
                'hex' => $request->hex ?? $color->hex
            ]);
            return $this->successResponse($color, 'Color updated successfully');
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse('Color not found', 404);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        $color = Color::find($id);
        if (!$color) {
            return $this->errorResponse('Color not found', 404);
        }
        $color->delete();
        return $this->successResponse([], "Delete the color");
    }
}
