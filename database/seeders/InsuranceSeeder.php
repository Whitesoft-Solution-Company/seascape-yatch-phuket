<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Faker\Factory as Faker;

class InsuranceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */


    public function run()
    {
        $booking = DB::table('bookings')->first();
        $faker = Faker::create();
  
            $insurances = [
                [
                    'booking_id' => $booking->id, // ใช้ ID ของการจองที่มีอยู่
                    'id_card' => 'INS123456',
                    'start_date' => Carbon::now()->toDateString(),
                    'end_date' => Carbon::now()->addYear()->toDateString(),
                    'amount' => 1000.00,
                    'age' => $faker->numberBetween(18, 65), // สุ่มอายุระหว่าง 18 ถึง 65 ปี
                ],
                // สามารถเพิ่มข้อมูลตัวอย่างเพิ่มเติมได้ที่นี่
            ];
      

        foreach ($insurances as $insurance) {
            DB::table('insurances')->insert($insurance);
        }
    }
}
