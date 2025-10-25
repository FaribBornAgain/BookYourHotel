<?php
// File: database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;
use App\Models\HotelFacility;
use App\Models\RoomFacility;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create Standard Room
        Room::create([
            'name' => 'Standard Room',
            'type' => 'standard',
            'description' => 'Biasanya, kamar tipe ini berdekorasi dengan harga yang relatif murah. Fasilitas yang ditawarkan pun standar seperti kasur ukuran king size atau dua queen size. Namun, penawaran yang diberikan tergantung pada masing-masing hotel. Standard room hotel bintang 1 dan bintang 5 tentu berbeda.',
            'price' => 200000,
            'capacity' => 2,
            'amenities' => 'AC, TV',
            'available_rooms' => 10,
            'image' => null
        ]);

        // Create Superior Room
        Room::create([
            'name' => 'Superior Room',
            'type' => 'superior',
            'description' => 'Kamar superior biasanya lebih luas dan memiliki fasilitas yang lebih lengkap dibanding standard room. Dilengkapi dengan pemandangan yang lebih baik dan furniture berkualitas.',
            'price' => 300000,
            'capacity' => 2,
            'amenities' => 'AC, TV, Mini Bar',
            'available_rooms' => 8,
            'image' => null
        ]);

        // Create Deluxe Room
        Room::create([
            'name' => 'Deluxe Room',
            'type' => 'deluxe',
            'description' => 'Kamar deluxe menawarkan kemewahan dan kenyamanan maksimal. Dilengkapi dengan fasilitas premium, area duduk yang luas, dan pemandangan terbaik dari hotel.',
            'price' => 400000,
            'capacity' => 3,
            'amenities' => 'AC, TV, Mini Bar, Bathtub',
            'available_rooms' => 5,
            'image' => null
        ]);

        // Create Hotel Facilities
        HotelFacility::create([
            'name' => 'Kolam Renang',
            'description' => 'Kolam renang dengan ukuran besar dan nyaman',
            'icon' => 'swimming-pool'
        ]);

        HotelFacility::create([
            'name' => 'Gym',
            'description' => 'Gym dengan nuansa asik modern',
            'icon' => 'dumbbell'
        ]);

        HotelFacility::create([
            'name' => 'Sauna',
            'description' => 'bagus pokainya',
            'icon' => 'hot-tub'
        ]);

        HotelFacility::create([
            'name' => 'Caffe in Hotel',
            'description' => 'bagus pokainya',
            'icon' => 'coffee'
        ]);

        HotelFacility::create([
            'name' => 'Toy Museum',
            'description' => 'bagus pokainya',
            'icon' => 'gamepad'
        ]);

        HotelFacility::create([
            'name' => 'Sport Area',
            'description' => 'bagus pokainya',
            'icon' => 'futbol'
        ]);

        // Create Room Facilities
        RoomFacility::create([
            'name' => 'AC',
            'description' => 'Air Conditioning'
        ]);

        RoomFacility::create([
            'name' => 'TV',
            'description' => 'Television'
        ]);

        RoomFacility::create([
            'name' => 'Mini Bar',
            'description' => 'Refrigerator with drinks'
        ]);

        RoomFacility::create([
            'name' => 'WiFi',
            'description' => 'Free high-speed internet'
        ]);

        RoomFacility::create([
            'name' => 'Bathtub',
            'description' => 'Luxury bathtub'
        ]);
    }
}