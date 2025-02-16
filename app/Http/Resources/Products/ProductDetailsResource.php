<?php

namespace App\Http\Resources\Products;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailsResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,
            'size' => $this->size ? [
                'id' => $this->size_id,
                'name' => $this->size->name,
            ] : null,
            'color' => $this->color ? [
                'id' => $this->color_id,
                'name' => $this->color->name,
                'hex_code' => $this->color->hex,
            ] : null,
            'quantity' => $this->stock_quantity,
            'price' => $this->price,
        ];
    }
}
