<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabel layanan hotel shuttle.
     */
    public function up(): void
    {
        Schema::create('hotel_shuttles', function (Blueprint $table) {
            $table->id();
            $table->string('hotel_name');
            $table->string('pickup_location');
            $table->string('dropoff_location');
            $table->decimal('price', 12, 2);
            $table->string('schedule')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();

            $table->index('status');
            $table->index('hotel_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotel_shuttles');
    }
};
