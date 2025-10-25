<?php
// File: database/migrations/2024_01_01_000007_create_room_room_facility_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomRoomFacilityTable extends Migration
{
    public function up()
    {
        Schema::create('room_room_facility', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained()->onDelete('cascade');
            $table->foreignId('room_facility_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('room_room_facility');
    }
}