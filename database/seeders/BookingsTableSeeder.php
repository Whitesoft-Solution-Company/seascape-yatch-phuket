<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class BookingsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            DB::table('bookings')->insert([
                'booking_code' => strtoupper(Str::random(10)),
                'name' => $faker->name,
                'user_id' => $faker->numberBetween(1, 10), // สมมุติว่ามีผู้ใช้อยู่ในฐานข้อมูลแล้ว
                'tel' => $faker->numerify('##########'), // 10 หลัก
                'agent' => $faker->numberBetween(1, 10),
                'contact' => $faker->text,
                'package_id' => $faker->numberBetween(1, 10), // สมมุติว่ามีแพ็กเกจอยู่ในฐานข้อมูลแล้ว
                'seat' => $faker->numberBetween(1, 20),
                'private_seat' => $faker->numberBetween(1, 10),
                'adult' => $faker->numberBetween(1, 10),
                'child' => $faker->numberBetween(0, 5),
                'baby' => $faker->numberBetween(0, 2),
                'guide_inspect' => $faker->numberBetween(1, 5),
                'amount' => $faker->numberBetween(1000, 5000),
                'code_id' => $faker->optional()->numberBetween(1, 10),
                'aff_id' => $faker->optional()->numberBetween(1, 10),
                'credit' => $faker->numberBetween(0, 1),
                'pledge' => $faker->numberBetween(100, 1000),
                'arrearage' => $faker->numberBetween(0, 500),
                'booking_time' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'),
                'admin_id' => $faker->numberBetween(1, 10),
                'statement_status' => $faker->randomElement(['deposit', 'full_payment', 'ent', 'unpaid', 'internal']),
            'booking_status' => $faker->randomElement(['deleted', 'pending_agent_confirmation', 'unpaid', 'confirmed', 'pending_confirmation', 'checked_in', 'cancelled', 'internal', 'refunded', 'maintenance']),
                'note' => $faker->optional()->text,
                'percent_discount' => $faker->randomFloat(2, 0, 100),
                'departure_date' => $faker->date(),
                'return_date' => $faker->date(),
            ]);
        }
    }
}
