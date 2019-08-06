<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePendingBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pending_bookings', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('client_id')->unsigned();
          $table->integer('pet_id')->unsigned();
          $table->datetime('start_time');
          $table->datetime('end_time');
          $table->string('status');
          $table->timestampsTz();

          $table->foreign('client_id')->references('id')->on('clients');
          $table->foreign('pet_id')->references('id')->on('pets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pending_bookings');
    }
}
