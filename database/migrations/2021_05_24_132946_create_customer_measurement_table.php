<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerMeasurementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_measurements', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->UnsignedBigInteger('customer_id');
			$table->foreign('customer_id')->on('customers')->references('id')->onDelete('cascade');
			$table->string('length');
			$table->string('shoulder');
			$table->string('arms');
			$table->string('armput');
			$table->string('chest');
			$table->string('waist');
			$table->string('hip');
			$table->string('bottom');
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
        Schema::dropIfExists('customer_measurement');
    }
}
