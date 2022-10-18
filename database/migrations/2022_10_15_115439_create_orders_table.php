<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('full_name')->nullable();
            $table->string('mobile_number')->nullable();
            $table->text('delivery_address')->nullable();
            $table->double('amount')->nullable();
            $table->double('total')->nullable();
            $table->double('grand_total')->nullable();
            $table->double('delivery_fee')->nullable();
            $table->integer('payment_mode')->nullable();
            $table->integer('status')->nullable();
            $table->date('received_date')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
