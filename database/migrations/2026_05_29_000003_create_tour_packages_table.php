<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabel paket wisata.
     */
    public function up(): void
    {
        Schema::create('tour_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->text('itinerary')->nullable();
            $table->string('duration');
            $table->decimal('price', 12, 2);
            $table->string('image')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();

            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_packages');
    }
};
