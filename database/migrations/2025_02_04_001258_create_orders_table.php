<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration {

    public function up() {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('address');
            $table->decimal('total_price', 10, 2);
            $table->foreignId('coupon_id')->constrained()->nullable();
            $table->decimal('discount', 10, 2)->default('0');
            $table->decimal('final_price', 10, 2);
            $table->timestamps();
        });
    }

    public function down() {
        Schema::drop('orders');
    }
}
