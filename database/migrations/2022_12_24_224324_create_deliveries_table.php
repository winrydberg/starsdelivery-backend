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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->string('pickup_loc_name')->nullable();
            $table->float('pickup_lat')->nullable();
            $table->float('pickup_lng')->nullable();
            $table->string('pickup_msisdn')->nullable();
            // $table->string('dropoff_loc_name')->nullable();
            // $table->float('dropoff_lat')->nullable();
            // $table->float('dropoff_lng')->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->bigInteger('delivery_mode_id')->unsigned();
            $table->foreign('delivery_mode_id')->references('id')->on('delivery_modes');
            $table->bigInteger('rider_id')->nullable();
            $table->bigInteger('package_type_id')->unsigned();
            $table->foreign('package_type_id')->references('id')->on('package_types');
            $table->bigInteger('payment_type_id')->unsigned();
            $table->foreign('payment_type_id')->references('id')->on('payment_types');
            $table->boolean('completed')->default(false);
            $table->longText('note')->nullable();
            $table->string('payment_no')->nullable();
            $table->decimal('delivery_fare')->nullable();
            $table->string('delivery_status')->nullable()->default('Pending');
            $table->boolean('is_return_trip')->default(false);
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
        Schema::dropIfExists('deliveries');
    }
};