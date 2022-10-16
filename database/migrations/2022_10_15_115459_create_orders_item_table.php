<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_item', function (Blueprint $table) {
            $table->id();
            $table->text('image')->nullable();
            $table->integer('order_id')->nullable();
            $table->string('code')->nullable();
            $table->integer('product_id')->nullable();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->integer('quantity')->nullable();
            $table->double('price')->nullable();
            $table->integer('food_category_id')->nullable();
            $table->integer('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders_item');
    }
}
