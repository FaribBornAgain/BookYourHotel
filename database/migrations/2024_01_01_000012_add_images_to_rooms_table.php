<?php
// File: database/migrations/2024_01_01_000012_add_images_to_rooms_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImagesToRoomsTable extends Migration
{
    public function up()
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->string('featured_image')->nullable()->after('image');
            $table->text('gallery_images')->nullable()->after('featured_image'); // JSON array
        });
    }

    public function down()
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn(['featured_image', 'gallery_images']);
        });
    }
}