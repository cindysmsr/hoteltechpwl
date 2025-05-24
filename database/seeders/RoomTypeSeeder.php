<?php


namespace Database\Seeders;

use App\Models\RoomType;
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
                'amenities' => json_encode(['TV', 'AC', 'WiFi', 'Private Bathroom']),
                'img' => 'room_types/standard.jpeg',
            ],
            [
                'name' => 'Deluxe',
                'description' => 'Spacious room with premium amenities and scenic views.',
                'price' => 200000.00,
                'capacity' => 2,
                'amenities' => json_encode(['TV', 'AC', 'WiFi', 'Private Bathroom', 'Mini Bar', 'Coffee Maker']),
                'img' => 'room_types/deluxe.jpeg',
            ],
            [
                'name' => 'Suite',
                'description' => 'Luxury with separate living area and exclusive amenities.',
                'price' => 350000.00,
                'capacity' => 4,
                'amenities' => json_encode(['TV', 'AC', 'WiFi', 'Private Bathroom', 'Mini Bar', 'Coffee Maker', 'Jacuzzi', 'Kitchenette', 'Living Room']),
                'img' => 'room_types/suite.jpeg',
            ],
        ];

        foreach ($roomTypes as $roomType) {
            RoomType::create($roomType);
        }
    }
}