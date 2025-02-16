<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model {
    protected $fillable = ['name', 'description', 'parent_id'];
    public function parent() {
        return $this->belongsTo(ProductCategory::class);
    }
    public function children() {
        return $this->hasMany(ProductCategory::class);
    }
    public function products() {
        return $this->hasMany(Product::class);
    }
    public function childrenRecursive() {
        return $this->hasMany(ProductCategory::class, 'parent_id')->with('childrenRecursive');
    }
}
