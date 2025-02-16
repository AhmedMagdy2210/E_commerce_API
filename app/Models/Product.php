<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    protected $fillable = ['name', 'description', 'base_price', 'category_id'];

    public function category() {
        return $this->belongsTo(ProductCategory::class);
    }
    public function details() {
        return $this->hasMany(ProductDetail::class);
    }
}
