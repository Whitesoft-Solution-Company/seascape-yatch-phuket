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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code', 20);
            $table->string('name', 100);
            $table->unsignedBigInteger('user_id');
            $table->string('tel', 15);
            $table->unsignedInteger('agent')->default(2);
            $table->text('contact')->nullable();
            $table->unsignedBigInteger('package_id');
            $table->integer('seat');
            $table->integer('private_seat');
            $table->integer('adult');
            $table->integer('child');
            $table->integer('baby')->default(0);
            $table->integer('guide_inspect');
            $table->integer('amount');
            $table->unsignedBigInteger('code_id')->nullable();
            $table->unsignedBigInteger('aff_id')->nullable();
            $table->integer('credit')->default(0)->comment('0 = ยังไม่ตัด , 1 = ตัดเครดิตแล้ว');
            $table->integer('pledge')->comment('เงินมัดจำ');
            $table->integer('arrearage')->comment('คงค้าง');
            $table->string('booking_time', 20);
            $table->date('departure_date')->nullable();
            $table->date('return_date')->nullable();
            $table->unsignedBigInteger('admin_id');
            $table->enum('statement_status', [
                'deposit',
                'paid',
                'ent',
                'unpaid',
                'full_payment',
                'internal'
            ])->default('unpaid')->comment('Payment Status');
            $table->enum('booking_status', [
                'deleted',
                'pending_agent_confirmation',
                'pending',
                'confirmed',
                'pending_confirmation',
                'checked_in',
                'cancelled',
                'internal',
                'refunded',
                'maintenance',
                'unpaid',
            ])->default('pending')->comment('Booking Status');
            $table->text('note')->nullable();
            $table->float('percent_discount', 8, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
