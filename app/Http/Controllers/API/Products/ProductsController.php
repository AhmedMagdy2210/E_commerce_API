<?php

namespace App\Http\Controllers\API\Products;

use App\ApiTrait;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Products\AddProductRequest;
use App\Http\Requests\Products\UpdateProductsRequest;
use App\Http\Resources\Products\ProductsResource;
use App\Models\ProductDetail;

use function PHPUnit\Framework\isArray;

class ProductsController extends Controller {
    use ApiTrait;

    public function index() {
        $products = Product::with([
            'category.childrenRecursive',
            'details.size',
            'details.color'
        ])->get();
        return $this->successResponse(ProductsResource::collection($products), 'All products', 200);
    }

    public function store(AddProductRequest $request) {
        $product = Product::create($request->validated());
        foreach ($request->details as $detail) {
            ProductDetail::create([
                'product_id' => $product->id,
                'size_id' => $detail['size_id'],
                'color_id' => $detail['color_id'],
                'stock_quantity' => $detail['quantity'],
                'price' => $detail['price']
            ]);
        }
        return $this->successResponse(new ProductsResource($product), 'Product created successfully', 201);
    }

    public function show($id) {
        $product = Product::with([
            'category.childrenRecursive',
            'details.size',
            'details.color'
        ])->find($id);
        if (!$product) {
            return $this->errorResponse('Product not found', 404);
        }
        return $this->successResponse(new ProductsResource($product), 'Get the product', 200);
    }

    public function update(UpdateProductsRequest $request, $id) {
        $product = Product::find($id);
        if (!$product) {
            return $this->errorResponse('Product not found', 404);
        }
        $product->update($request->only(['name', 'description', 'base_price', 'category_id']));
        if ($request->has('details') && isArray($request->details)) {
            foreach ($request->details as $detail) {
                if (isset($detail['id'])) {
                    $productDetail = ProductDetail::find($detail['id']);
                    if ($productDetail) {
                        // dd($productDetail, $request->details);
                        $productDetail->update([
                            'size_id' => $detail['size_id'] ?? $productDetail->size_id,
                            'color_id' => $detail['color_id'] ?? $productDetail->color_id,
                            'stock_quantity' => $detail['stock_quantity'] ?? $productDetail->stock_quantity,
                            'price' => $detail['price'] ?? $productDetail->price,
                        ]);
                    } else {
                        return $this->errorResponse('The details is not found', 400);
                    }
                } else {
                    ProductDetail::create([
                        'product_id' => $product->id,
                        'size_id' => $detail['size_id'],
                        'color_id' => $detail['color_id'],
                        'stock_quantity' => $detail['quantity'],
                        'price' => $detail['price']
                    ]);
                }
            }
        }
        return $this->successResponse(new ProductsResource($product->load(['details.size', 'details.color'])), 'Product updated successfully', 200);
    }

    public function destroy($id) {
        $product = Product::find($id);
        if (!$product) {
            return $this->errorResponse('Product not found', 404);
        }
        $product->delete();
        return $this->successResponse([], 'Product deleted successfully', 200);
    }
}
