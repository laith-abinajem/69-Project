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
        Schema::create('ppf_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ppf_id');
            $table->enum('class_car', ['Luxury', 'Regular', 'Electric', 'Electric (Tesla)']);
            $table->enum('sub_class_car', ['Coupe', 'Sedan', 'SUV', '7 seater SUV', 'TRUCK']);
            $table->string('ppf_type');
            $table->double('price');
            $table->timestamps();
            $table->foreign('ppf_id')->references('id')->on('ppf_brands')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppf_details');
    }
};
