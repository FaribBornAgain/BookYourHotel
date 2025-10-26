<?php
// File: database/seeders/DemoDataSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Destination;
use App\Models\PropertyType;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    public function run()
    {
        // Create Demo Business User (if not exists)
        $businessUser = User::firstOrCreate(
            ['email' => 'demo@business.com'],
            [
                'name' => 'Demo Business Owner',
                'password' => Hash::make('demo123'),
                'user_type' => 'business',
                'is_admin' => false
            ]
        );

        // Create Destinations with demo data
        $destinations = [
            [
                'name' => 'Dhaka',
                'country' => 'Bangladesh',
                'description' => 'Capital city with vibrant culture and modern hotels',
                'image' => 'https://images.unsplash.com/photo-1568322445389-f64ac2515020?w=600',
                'is_featured' => true,
                'hotels_count' => 15
            ],
            [
                'name' => 'Cox\'s Bazar',
                'country' => 'Bangladesh',
                'description' => 'World\'s longest natural sea beach',
                'image' => 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=600',
                'is_featured' => true,
                'hotels_count' => 25
            ],
            [
                'name' => 'Sylhet',
                'country' => 'Bangladesh',
                'description' => 'Tea capital with beautiful landscapes',
                'image' => 'https://images.unsplash.com/photo-1566552881560-0be862a7c445?w=600',
                'is_featured' => true,
                'hotels_count' => 12
            ],
            [
                'name' => 'Chittagong',
                'country' => 'Bangladesh',
                'description' => 'Port city with scenic beaches',
                'image' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=600',
                'is_featured' => true,
                'hotels_count' => 18
            ],
            [
                'name' => 'Rangamati',
                'country' => 'Bangladesh',
                'description' => 'Hill district with beautiful lakes',
                'image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=600',
                'is_featured' => true,
                'hotels_count' => 8
            ],
            [
                'name' => 'Bandarban',
                'country' => 'Bangladesh',
                'description' => 'Mountainous region with stunning views',
                'image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=600',
                'is_featured' => true,
                'hotels_count' => 10
            ]
        ];

        foreach ($destinations as $destData) {
            Destination::create($destData);
        }

        // Create Property Types
        $propertyTypes = [
            [
                'name' => 'Hotels',
                'description' => 'Comfortable accommodations with great amenities',
                'image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=400'
            ],
            [
                'name' => 'Apartments',
                'description' => 'Spacious apartments perfect for longer stays',
                'image' => 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=400'
            ],
            [
                'name' => 'Resorts',
                'description' => 'Luxury resorts with full facilities',
                'image' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=400'
            ],
            [
                'name' => 'Villas',
                'description' => 'Private villas for exclusive experiences',
                'image' => 'https://images.unsplash.com/photo-1613490493576-7fde63acd811?w=400'
            ]
        ];

        foreach ($propertyTypes as $typeData) {
            PropertyType::create($typeData);
        }

        // Get created destinations and property types
        $dhakaDestination = Destination::where('name', 'Dhaka')->first();
        $coxDestination = Destination::where('name', 'Cox\'s Bazar')->first();
        $sylhetDestination = Destination::where('name', 'Sylhet')->first();
        
        $hotelType = PropertyType::where('name', 'Hotels')->first();
        $resortType = PropertyType::where('name', 'Resorts')->first();

        // Create Demo Hotels
        $hotels = [
            [
                'user_id' => $businessUser->id,
                'destination_id' => $dhakaDestination->id,
                'property_type_id' => $hotelType->id,
                'name' => 'Grand Palace Hotel Dhaka',
                'location' => 'Gulshan, Dhaka',
                'latitude' => 23.7808875,
                'longitude' => 90.4160494,
                'description' => 'Luxurious 5-star hotel in the heart of Dhaka with modern amenities, rooftop pool, spa, and fine dining restaurants.',
                'phone' => '+880 1712-345678',
                'email' => 'info@grandpalace.com',
                'featured_image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800',
                'status' => 'active'
            ],
            [
                'user_id' => $businessUser->id,
                'destination_id' => $coxDestination->id,
                'property_type_id' => $resortType->id,
                'name' => 'Ocean View Resort',
                'location' => 'Kolatoli Beach, Cox\'s Bazar',
                'latitude' => 21.4272,
                'longitude' => 92.0058,
                'description' => 'Beachfront resort with direct beach access, water sports, infinity pool, and stunning ocean views.',
                'phone' => '+880 1812-345678',
                'email' => 'info@oceanview.com',
                'featured_image' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=800',
                'status' => 'active'
            ],
            [
                'user_id' => $businessUser->id,
                'destination_id' => $sylhetDestination->id,
                'property_type_id' => $hotelType->id,
                'name' => 'Tea Garden Hotel',
                'location' => 'Srimangal, Sylhet',
                'latitude' => 24.3065,
                'longitude' => 91.7296,
                'description' => 'Charming hotel surrounded by tea gardens, offering peaceful retreats and nature walks.',
                'phone' => '+880 1912-345678',
                'email' => 'info@teagarden.com',
                'featured_image' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=800',
                'status' => 'active'
            ],
            [
                'user_id' => $businessUser->id,
                'destination_id' => $dhakaDestination->id,
                'property_type_id' => $hotelType->id,
                'name' => 'City Center Inn',
                'location' => 'Dhanmondi, Dhaka',
                'latitude' => 23.7461,
                'longitude' => 90.3742,
                'description' => 'Modern hotel in central Dhaka, perfect for business and leisure travelers.',
                'phone' => '+880 1612-345678',
                'email' => 'info@citycenter.com',
                'featured_image' => 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=800',
                'status' => 'active'
            ],
            [
                'user_id' => $businessUser->id,
                'destination_id' => $coxDestination->id,
                'property_type_id' => $resortType->id,
                'name' => 'Sunset Beach Resort',
                'location' => 'Inani Beach, Cox\'s Bazar',
                'latitude' => 21.1764,
                'longitude' => 92.0476,
                'description' => 'Exclusive beach resort with private cottages, seafood restaurant, and sunset views.',
                'phone' => '+880 1512-345678',
                'email' => 'info@sunsetbeach.com',
                'featured_image' => 'https://images.unsplash.com/photo-1564501049412-61c2a3083791?w=800',
                'status' => 'active'
            ],
            [
                'user_id' => $businessUser->id,
                'destination_id' => $sylhetDestination->id,
                'property_type_id' => $hotelType->id,
                'name' => 'Hill View Hotel',
                'location' => 'Jaflong, Sylhet',
                'latitude' => 25.1722,
                'longitude' => 92.0058,
                'description' => 'Hilltop hotel with panoramic views, traditional cuisine, and cultural experiences.',
                'phone' => '+880 1412-345678',
                'email' => 'info@hillview.com',
                'featured_image' => 'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=800',
                'status' => 'active'
            ]
        ];

        foreach ($hotels as $hotelData) {
            $hotel = Hotel::create($hotelData);

            // Add rooms for each hotel
            $roomTypes = [
                [
                    'name' => 'Standard Room',
                    'type' => 'standard',
                    'description' => 'Comfortable room with essential amenities, perfect for budget travelers.',
                    'price' => rand(2000, 3000) * 100,
                    'capacity' => 2,
                    'amenities' => 'AC, TV, WiFi, Mini Fridge',
                    'available_rooms' => rand(5, 10),
                    'featured_image' => 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?w=600'
                ],
                [
                    'name' => 'Deluxe Room',
                    'type' => 'deluxe',
                    'description' => 'Spacious room with premium amenities and beautiful views.',
                    'price' => rand(3500, 5000) * 100,
                    'capacity' => 3,
                    'amenities' => 'AC, TV, WiFi, Mini Bar, Bathtub, Coffee Maker',
                    'available_rooms' => rand(3, 7),
                    'featured_image' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=600'
                ],
                [
                    'name' => 'Executive Suite',
                    'type' => 'superior',
                    'description' => 'Luxurious suite with separate living area, ideal for business or family.',
                    'price' => rand(6000, 8000) * 100,
                    'capacity' => 4,
                    'amenities' => 'AC, TV, WiFi, Mini Bar, Bathtub, Living Room, Work Desk',
                    'available_rooms' => rand(2, 5),
                    'featured_image' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=600'
                ]
            ];

            foreach ($roomTypes as $roomData) {
                $roomData['hotel_id'] = $hotel->id;
                Room::create($roomData);
            }
        }

        echo "✅ Demo data seeded successfully!\n";
        echo "📧 Demo Business Login: demo@business.com / demo123\n";
    }
}