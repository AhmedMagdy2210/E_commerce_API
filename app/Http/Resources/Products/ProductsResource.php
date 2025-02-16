<?php

namespace App\Http\Resources\Products;

use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Products\ProductDetailsResource;

class ProductsResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array {

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'base_price' => $this->base_price,
            'category' => new CategoryResource($this->category),
            'total_quantity' => $this->details->sum('stock_quantity'),
            'details' => ProductDetailsResource::collection($this->details),
        ];
    }
}
