<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration {

    public function up() {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->text('description')->nullable();
            $table->decimal('base_price', 8, 2);
            $table->foreignId('category_id')->constrained('product_categories', 'id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::drop('products');
    }
}
