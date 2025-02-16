<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrederStatusTable extends Migration {

    public function up() {
        Schema::create('oreder_status', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->unsigned()->onDelete('cascade');
            $table->enum('status', ['pending', 'shipped', 'delivered', 'cancelled']);
            $table->timestamps();
        });
    }

    public function down() {
        Schema::drop('oreder_status');
    }
}
