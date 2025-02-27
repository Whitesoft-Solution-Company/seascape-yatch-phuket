<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('package_types', function (Blueprint $table) {
            $table->id();
            $table->string('name_th', 50);
            $table->string('name_en', 100);
            $table->string('trip_type', 50);
            $table->unsignedBigInteger('boat')->nullable();
            $table->string('color_title', 10);
            $table->timestamps();
            $table->integer('status');

            // Foreign key constraint
            $table->foreign('boat')->references('id')->on('yachts')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_types');
    }
};
