<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $rooms = ['101', '102', '103', '201', '202', '203', '301', '302', '303'];
        
        foreach ($rooms as $room) {
            Room::create(['room_number' => $room]);
        }
    }
}
