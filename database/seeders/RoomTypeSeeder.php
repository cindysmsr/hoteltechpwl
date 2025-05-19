<?php

namespace Database\Seeders;

use App\Models\RoomType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roomTypes = [
            [
                'name' => 'Standard',
                'description' => 'Comfortable room with basic amenities for a pleasant stay.',
                'price' => 100000.00,
                'capacity' => 2,
                'amenities' => ['TV', 'AC', 'WiFi', 'Private Bathroom'],
            ],
            [
                'name' => 'Deluxe',
                'description' => 'Spacious room with premium amenities and scenic views.',
                'price' => 200000.00,
                'capacity' => 2,
                'amenities' => ['TV', 'AC', 'WiFi', 'Private Bathroom', 'Mini Bar', 'Coffee Maker'],
            ],
            [
                'name' => 'Suite',
                'description' => 'Luxury suite with separate living area and exclusive amenities.',
                'price' => 350000.00,
                'capacity' => 4,
                'amenities' => ['TV', 'AC', 'WiFi', 'Private Bathroom', 'Mini Bar', 'Coffee Maker', 'Jacuzzi', 'Kitchenette', 'Living Room'],
            ],
        ];

        foreach ($roomTypes as $roomType) {
            RoomType::create($roomType);
        }
    }
}
