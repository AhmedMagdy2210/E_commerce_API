<?php

namespace App\Http\Controllers\API\Admin\Categories;

use App\ApiTrait;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Categories\AddCategoryRequest;
use App\Http\Requests\Categories\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;

class CategoriesController extends Controller {
    use ApiTrait;

    public function index() {
        $categories = ProductCategory::whereNull('parent_id')->with('childrenRecursive')->get();
        return $this->successResponse(CategoryResource::collection($categories), 'All categories', 200);
    }


    public function store(AddCategoryRequest $request) {
        $category = ProductCategory::create($request->validated());
        return $this->successResponse(new CategoryResource($category), 'Category created successfully', 201);
    }


    public function show($id) {
        $category = ProductCategory::findOrFail($id);
        return $this->successResponse(new CategoryResource($category), 'Showing category', 200);
    }

    public function update(UpdateCategoryRequest $request, $id) {
        $category = ProductCategory::findOrFail($id);
        $category->update($request->validated());
        return $this->successResponse(new CategoryResource($category), 'Category updated successfully', 200);
    }


    public function destroy($id) {
        $category = ProductCategory::findOrFail($id);
        $category->delete();
        return $this->successResponse([], 'Category deleted successfully', 200);
    }
}
