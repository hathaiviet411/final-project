<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('room_number')->required();
            $table->unsignedBigInteger('building_id')->required();
            $table->unsignedBigInteger('room_type')->required();
            $table->unsignedBigInteger('room_capacity')->required();
            $table->unsignedBigInteger('level')->required();
            $table->string('room_information')->nullable();
            $table->unsignedBigInteger('room_status')->required();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rooms');
    }
}
