<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbPriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('package_id'); // Foreign key for package
            $table->string('person_type', 50);
            $table->integer('agent');
            $table->integer('regular');
            $table->integer('subordinate')->default(0);
            $table->integer('status');
            $table->foreign('package_id')->references('id')->on('package')->onDelete('cascade');
            
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
        Schema::dropIfExists('price');
    }
}
