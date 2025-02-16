<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductDetailsTable extends Migration {

    public function up() {
        Schema::create('product_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('size_id')->constrained()->onDelete('cascade')->nullable();
            $table->foreignId('color_id')->constrained()->onDelete('cascade')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('stock_quantity')->unsigned()->default(0);
            $table->timestamps();
        });
    }

    public function down() {
        Schema::drop('product_details');
    }
}
