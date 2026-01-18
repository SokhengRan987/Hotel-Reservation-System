<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [
            ['number' => '101', 'type' => 'Standard', 'description' => 'Cozy standard room', 'price' => 79.99, 'capacity' => 2, 'features' => ['wifi','tv']],
            ['number' => '201', 'type' => 'Deluxe', 'description' => 'Spacious deluxe room', 'price' => 129.99, 'capacity' => 3, 'features' => ['wifi','balcony','minibar']],
            ['number' => '301', 'type' => 'Suite', 'description' => 'Luxury suite', 'price' => 249.99, 'capacity' => 4, 'features' => ['wifi','tv','jacuzzi']],
        ];

        foreach ($rooms as $r) {
            if (!Room::where('number', $r['number'])->exists()) {
                Room::create($r);
            }
        }
    }
}
