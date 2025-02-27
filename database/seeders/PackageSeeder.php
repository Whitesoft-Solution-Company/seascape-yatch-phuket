<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Package;
use Faker\Factory as Faker;
class PackageSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) { // ปรับจำนวน record ที่ต้องการสร้างได้ตามต้องการ
            Package::create([
                'name_boat' => $faker->word . ' ' . $faker->randomElement(['Speedboat', 'Yacht', 'Catamaran']),
                'max_guest' => $faker->numberBetween(1, 20),
                'type' => $faker->numberBetween(1, 4),
                'yacht' => $faker->numberBetween(1, 5),
                'note' => $faker->sentence,
                'image' => 'yacht.jpg', // สร้างภาพจำลองใน storage
                'min' => $faker->numberBetween(1, 5),
                'max' => $faker->numberBetween(10, 30),
                'start_time' => '2024-08-01 20:07:11',
                'end_time' =>  '2024-10-01 20:07:11',
                'status' => $faker->boolean,
                'hiding' => $faker->boolean,
            ]);
        }

        // Repeat for more rows as needed
    }
}
