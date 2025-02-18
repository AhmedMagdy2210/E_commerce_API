<?php

namespace App\Http\Resources\Cart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemsResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'product_details' => [
                'product_name' => $this->product_details->product->name,
                'description' => $this->product_details->product->description,
                'category_name' => $this->product_details->product->category->name,
                'id' => $this->product_details->id,
                'size' => $this->product_details->size->name ?? null,
                'color_name' => $this->product_details->color->name ?? null,
                'color_hex' => $this->product_details->color->hex ?? null,
                'price' => $this->product_details->price,
            ]

        ];
    }
}
