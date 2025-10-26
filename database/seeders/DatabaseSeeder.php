<?php
// File: database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;
use App\Models\Hotel;
use App\Models\HotelFacility;
use App\Models\RoomFacility;
use App\Models\Destination;
use App\Models\PropertyType;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create Destinations
        Destination::create([
            'name' => 'Dhaka',
            'country' => 'Bangladesh',
            'description' => 'Capital city of Bangladesh',
            'image' => null,
            'is_featured' => true,
            'hotels_count' => 5
        ]);

        Destination::create([
            'name' => 'Cox\'s Bazar',
            'country' => 'Bangladesh',
            'description' => 'Longest natural sea beach',
            'image' => null,
            'is_featured' => true,
            'hotels_count' => 8
        ]);

        Destination::create([
            'name' => 'Sylhet',
            'country' => 'Bangladesh',
            'description' => 'Tea capital of Bangladesh',
            'image' => null,
            'is_featured' => true,
            'hotels_count' => 4
        ]);

        // Create Property Types
        PropertyType::create([
            'name' => 'Hotels',
            'description' => 'Comfortable stays with great amenities',
            'image' => null
        ]);

        PropertyType::create([
            'name' => 'Apartments',
            'description' => 'Spacious apartments for longer stays',
            'image' => null
        ]);

        PropertyType::create([
            'name' => 'Resorts',
            'description' => 'Luxury resorts with all facilities',
            'image' => null
        ]);

        PropertyType::create([
            'name' => 'Villas',
            'description' => 'Private villas for exclusive experience',
            'image' => null
        ]);

        // Create Default Rooms (without hotel - legacy)
        Room::create([
            'name' => 'Standard Room',
            'type' => 'standard',
            'description' => 'Biasanya, kamar tipe ini berdekorasi dengan harga yang relatif murah. Fasilitas yang ditawarkan pun standar seperti kasur ukuran king size atau dua queen size.',
            'price' => 200000,
            'capacity' => 2,
            'amenities' => 'AC, TV',
            'available_rooms' => 10,
            'image' => null,
            'featured_image' => null
        ]);

        Room::create([
            'name' => 'Superior Room',
            'type' => 'superior',
            'description' => 'Kamar superior biasanya lebih luas dan memiliki fasilitas yang lebih lengkap dibanding standard room.',
            'price' => 300000,
            'capacity' => 2,
            'amenities' => 'AC, TV, Mini Bar',
            'available_rooms' => 8,
            'image' => null,
            'featured_image' => null
        ]);

        Room::create([
            'name' => 'Deluxe Room',
            'type' => 'deluxe',
            'description' => 'Kamar deluxe menawarkan kemewahan dan kenyamanan maksimal. Dilengkapi dengan fasilitas premium.',
            'price' => 400000,
            'capacity' => 3,
            'amenities' => 'AC, TV, Mini Bar, Bathtub',
            'available_rooms' => 5,
            'image' => null,
            'featured_image' => null
        ]);

        // Create Hotel Facilities
        HotelFacility::create([
            'name' => 'Swimming Pool',
            'description' => 'Large outdoor swimming pool',
            'icon' => 'swimming-pool'
        ]);

        HotelFacility::create([
            'name' => 'Gym',
            'description' => 'Modern gym with latest equipment',
            'icon' => 'dumbbell'
        ]);

        HotelFacility::create([
            'name' => 'Sauna',
            'description' => 'Relaxing sauna facility',
            'icon' => 'hot-tub'
        ]);

        HotelFacility::create([
            'name' => 'Restaurant',
            'description' => 'In-house restaurant',
            'icon' => 'utensils'
        ]);

        HotelFacility::create([
            'name' => 'Spa',
            'description' => 'Full service spa',
            'icon' => 'spa'
        ]);

        // Create Room Facilities
        RoomFacility::create(['name' => 'AC', 'description' => 'Air Conditioning']);
        RoomFacility::create(['name' => 'TV', 'description' => 'Television']);
        RoomFacility::create(['name' => 'Mini Bar', 'description' => 'Refrigerator with drinks']);
        RoomFacility::create(['name' => 'WiFi', 'description' => 'Free high-speed internet']);
        RoomFacility::create(['name' => 'Bathtub', 'description' => 'Luxury bathtub']);

        $this->call(AdminSeeder::class);
        
        $this->call([
            AdminSeeder::class,
            DemoDataSeeder::class
        ]);
    }
}