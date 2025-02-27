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
        Schema::create('payments', function (Blueprint $table) {
            $table->id(); // แทน `id int NOT NULL`
            $table->unsignedBigInteger('user_id'); // foreign key สำหรับผู้ใช้
            $table->integer('amount'); // จำนวนเงิน
            $table->string('account', 100); // หมายเลขบัญชี
            $table->string('name', 200); // ชื่อ
            $table->string('payment_token', 200); // ชื่อ
            $table->string('type', 200); // ชื่อ
            $table->string('bank', 200); // ช่องทางชำระ
            $table->string('transfer_time', 50); // เวลาที่โอน
            $table->string('slip', 255); // หลักฐานการโอน
            $table->unsignedBigInteger('admin_id'); // foreign key สำหรับแอดมิน
            $table->unsignedBigInteger('booking_id'); // foreign key สำหรับการจอง
            $table->string('status', 50); // สถานะ
            $table->timestamps(); // Laravel จะเพิ่ม created_at และ updated_at ให้
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
