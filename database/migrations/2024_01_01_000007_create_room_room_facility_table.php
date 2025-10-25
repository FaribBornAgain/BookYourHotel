<?php
// File: database/migrations/2024_01_01_000007_create_room_room_facility_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomRoomFacilityTable extends Migration
{
    public function up(): void
{
    Schema::create('room_room_facility', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('room_id');
        $table->unsignedBigInteger('room_facility_id');
        $table->timestamps();

        $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
        $table->foreign('room_facility_id')->references('id')->on('room_facilities')->onDelete('cascade');
    });
}


    public function down()
    {
        Schema::dropIfExists('room_room_facility');
    }
}