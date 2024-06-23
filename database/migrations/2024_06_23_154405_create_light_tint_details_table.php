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
        Schema::create('light_tint_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('light_id');
            $table->enum('class_car', ['Luxury', 'Regular', 'Electric', 'Others']);
            $table->enum('sub_class_car', ['Coupe', 'Sedan', 'SUV', '7 seater SUV', 'TRUCK']);
            $table->string('light_type');
            $table->double('price');
            $table->timestamps();
            $table->foreign('light_id')->references('id')->on('light_tints')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('light_tint_details');
    }
};
