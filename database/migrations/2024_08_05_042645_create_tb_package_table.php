<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbPackageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package', function (Blueprint $table) {
            $table->id();
            $table->string('name_boat', 50)->comment('ชื่อ package');
            $table->integer('max_guest');
            $table->string('type', 50)->comment('ชนิดทริปใน tb_packagetype');
            $table->integer('yacht')->comment('ใส่ ID เรือ 0 = join , 1 ... 999 = id เรือ');
            $table->text('note');
            $table->string('image', 100);
            $table->integer('min');
            $table->integer('max');
            $table->string('start_time', 20);
            $table->string('end_time', 20);
            $table->integer('status')->comment('-1 = ลบ , 0 = ปิด , 1 = เปิด');
            $table->integer('hiding')->comment('0 = เปิดหมด\r\n1 = เอเย่นต์\r\n2 = ในเครือ \r\n3 = หน้าเว็บ\r\n4 = เอเย่นต์ - หน้าเว็บ\r\n5 = ในเครือ - หน้าเว็บ\r\n6 = ในเครือ - เอเย่นต์');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('package');
    }
}
