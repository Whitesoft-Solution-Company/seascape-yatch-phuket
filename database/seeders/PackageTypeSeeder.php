<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PackageTypeSeeder extends Seeder
{
    public function run()
    {
        DB::table('package_types')->insert([
            [
                'name_th' => 'ดำน้ำ',
                'name_en' => 'oneday_trip',
                'trip_type' => 'join',
                'color_title' => '#FF5733',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'status' => 1
            ],
            [
                'name_th' => 'ดำน้ำ',
                'name_en' => 'oneday_trip',
                'trip_type' => 'private',
                'color_title' => '#33FF57',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'status' => 1
            ],
            [
                'name_th' => 'ชมพระอาทิตย์ตก',
                'name_en' => 'sunset',
                'trip_type' => 'join',
                'color_title' => '#3357FF',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'status' => 1
            ],
            [
                'name_th' => 'ชมพระอาทิตย์ตก',
                'name_en' => 'sunset',
                'trip_type' => 'private',
                'color_title' => '#FF33A6',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'status' => 1
            ]
        ]);
    }
}

