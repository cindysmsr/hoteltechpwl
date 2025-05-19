<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roomTypes = RoomType::all();

        // Create 10 Standard rooms (101-110) on 1st floor
        for ($i = 1; $i <= 10; $i++) {
            Room::create([
                'room_number' => '10' . $i,
                'room_type_id' => $roomTypes->where('name', 'Standard')->first()->id,
                'floor' => 1,
                'status' => fake()->randomElement(['available', 'available', 'available', 'occupied', 'maintenance']),
            ]);
        }

        // Create 8 Deluxe rooms (201-208) on 2nd floor
        for ($i = 1; $i <= 8; $i++) {
            Room::create([
                'room_number' => '20' . $i,
                'room_type_id' => $roomTypes->where('name', 'Deluxe')->first()->id,
                'floor' => 2,
                'status' => fake()->randomElement(['available', 'available', 'available', 'occupied', 'maintenance']),
            ]);
        }

        // Create 5 Suite rooms (301-305) on 3rd floor
        for ($i = 1; $i <= 5; $i++) {
            Room::create([
                'room_number' => '30' . $i,
                'room_type_id' => $roomTypes->where('name', 'Suite')->first()->id,
                'floor' => 3,
                'status' => fake()->randomElement(['available', 'available', 'available', 'occupied', 'maintenance']),
            ]);
        }
    }
}
