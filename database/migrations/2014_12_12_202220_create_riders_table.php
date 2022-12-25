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
        Schema::create('riders', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->nullable();
            $table->string('phoneno')->unique();
            $table->string('profile_photo')->nullable();
            $table->string('profile_bg')->nullable();
            $table->boolean('active_status')->default(true);
            $table->boolean('verified')->default(true);
            $table->string('password');
            $table->string('referalcode')->nullable();
            $table->string('registrationtoken')->nullable();
            $table->string('device_name')->nullable();
            $table->bigInteger('city_id')->unsigned();
            $table->foreign('city_id')->references('id')->on('cities');
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
        Schema::dropIfExists('riders');
    }
};