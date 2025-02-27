<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('code_promotion', function (Blueprint $table) {
            $table->id(); // สร้างคอลัมน์ id เป็น primary key
            $table->string('promotion_code', 50);
            $table->string('type', 10);
            $table->string('traget', 50); // ดูจากตัวอย่างที่คุณให้มา `traget` อาจจะหมายถึง `target` คำนี้ผิดพิมพ์หรือไม่?
            $table->string('trip_type', 20);
            $table->integer('amount');
            $table->string('date_start', 20);
            $table->string('date_end', 20);
            $table->tinyInteger('status')->comment('1เปิด , 0 ปิด');
            $table->timestamps(); // สร้างคอลัมน์ created_at และ updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('code_promotion');
    }
};
