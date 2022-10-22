<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation', function (Blueprint $table) {
            $table->id();
            $table->string('reservation_number')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('full_name')->nullable();
            $table->string('mobile_number')->nullable();
            $table->double('total')->nullable();
            $table->integer('number_of_person')->nullable();
            $table->date('reservation_date')->nullable();
            $table->time('reservation_time')->nullable();
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
        Schema::dropIfExists('reservation');
    }
}
