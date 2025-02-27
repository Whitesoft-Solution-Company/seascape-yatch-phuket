<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;
use App\Models\Price;
use Faker\Factory as Faker;

class PriceSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $packages = Package::all();

        foreach ($packages as $package) {
            // สร้างราคา 3 แบบ (Adult, Child, Senior) สำหรับแต่ละแพ็กเกจ
            foreach (['Adult', 'Child'] as $personType) {
                Price::create([
                    'package_id' => $package->id, // ใช้ package_id จาก package ปัจจุบัน
                    'person_type' => $personType, // กำหนดประเภทบุคคล
                    'agent' => $faker->numberBetween(1000, 5000), // สุ่มราคาสำหรับ agent
                    'regular' => $faker->numberBetween(1000, 5000), // สุ่มราคาปกติ
                    'subordinate' => $faker->numberBetween(0, 1000), // สุ่มราคาสำหรับ subordinate
                    'status' => $faker->boolean(90), // กำหนดสถานะให้เป็น 1 ใน 90% ของกรณี
                ]);
            }
        }

        // Repeat for more rows as needed
    }
}
