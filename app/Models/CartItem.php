<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model {
    protected $fillable = ['cart_id', 'product_details_id', 'quantity', 'price'];
    public function cart() {
        return $this->belongsTo(Cart::class);
    }
    public function product_details() {
        return $this->belongsTo(ProductDetail::class, 'product_details_id');
    }
}
