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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('card_id')->nullable();
            $table->string('card_type')->nullable();
            $table->string('card_brand')->nullable();
            $table->string('last_4')->nullable();
            $table->string('cardholder_name')->nullable();
            $table->string('bin')->nullable();
            $table->string('customer_id')->nullable();
            $table->string('exp_year')->nullable();
            $table->string('exp_month')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
