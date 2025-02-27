<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class YachtSeeder extends Seeder
{
    public function run()
    {
        DB::table('yachts')->insert([
            [
                'name' => 'Luxury Yacht 1',
                'description' => 'A luxury yacht with all amenities included.',
                'capacity' => 10,
                'image' => 'luxury_yacht_1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Adventure Yacht 2',
                'description' => 'An adventure yacht for thrill-seekers.',
                'capacity' => 8,
                'image' => 'adventure_yacht_2.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Family Yacht 3',
                'description' => 'A family-friendly yacht for vacations.',
                'capacity' => 12,
                'image' => 'family_yacht_3.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Speed Yacht 4',
                'description' => 'A high-speed yacht for racing enthusiasts.',
                'capacity' => 6,
                'image' => 'speed_yacht_4.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Classic Yacht 5',
                'description' => 'A classic yacht with vintage design.',
                'capacity' => 15,
                'image' => 'classic_yacht_5.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

