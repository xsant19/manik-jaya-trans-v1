<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabel kendaraan untuk layanan sewa kendaraan.
     */
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->unsignedInteger('capacity');
            $table->decimal('price_full_day', 12, 2);
            $table->decimal('price_half_day', 12, 2);
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->enum('status', ['available', 'maintenance', 'inactive'])->default('available');
            $table->timestamps();

            $table->index('status');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
