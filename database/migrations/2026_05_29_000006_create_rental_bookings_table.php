<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabel booking sewa kendaraan.
     */
    public function up(): void
    {
        Schema::create('rental_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vehicle_id')->constrained()->cascadeOnDelete();
            $table->foreignId('driver_id')->nullable()->constrained()->nullOnDelete();
            $table->string('booking_code')->unique();
            $table->enum('rental_type', ['full_day', 'half_day']);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('pickup_location');
            $table->text('note')->nullable();
            $table->decimal('total_price', 12, 2);
            $table->enum('booking_status', ['pending', 'approved', 'on_trip', 'completed', 'canceled'])->default('pending');
            $table->enum('payment_status', ['unpaid', 'pending', 'paid', 'failed', 'expired', 'refunded'])->default('unpaid');
            $table->timestamps();

            $table->index('user_id');
            $table->index('vehicle_id');
            $table->index('driver_id');
            $table->index('booking_status');
            $table->index('payment_status');
            $table->index('start_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_bookings');
    }
};
