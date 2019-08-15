<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned();
            $table->integer('pet_id')->unsigned();
            $table->integer('employee_id')->nullable()->unsigned();
            $table->integer('service_id')->unsigned();
            $table->datetime('start_time');
            $table->datetime('end_time');
            $table->string('status');
            $table->timestampsTz();
            $table->softDeletesTz();

            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('pet_id')->references('id')->on('pets');
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('service_id')->references('id')->on('services');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
