<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drop_offs', function (Blueprint $table) {
            $table->id();
            $table->string('dropoff_loc_name')->nullable();
            $table->float('dropoff_lat')->nullable();
            $table->float('dropoff_lng')->nullable();
            $table->bigInteger('delivery_id')->unsigned();
            $table->string('dropoff_msisdn')->nullable();
            // $table->foreign('delivery_id')->references('id')->on('deliveries');
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
        Schema::dropIfExists('drop_offs');
    }
};