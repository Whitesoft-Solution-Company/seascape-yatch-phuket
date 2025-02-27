<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYachtsTable extends Migration
{
    public function up()
    {
        Schema::create('yachts', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // ชื่อเรือ
            $table->text('description'); // รายละเอียดเรือ
            $table->integer('capacity'); // ความจุ
            $table->string('image')->nullable(); // รูปภาพเรือ
            $table->timestamps(); // created_at และ updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('yachts');
    }
}

