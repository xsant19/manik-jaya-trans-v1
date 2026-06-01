<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabel booking paket wisata.
     */
    public function up(): void
    {
        Schema::create('tour_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tour_package_id')->constrained()->cascadeOnDelete();
            $table->string('booking_code')->unique();
            $table->date('booking_date');
            $table->unsignedInteger('participant_count');
            $table->text('note')->nullable();
            $table->decimal('total_price', 12, 2);
            $table->enum('booking_status', ['pending', 'approved', 'on_trip', 'completed', 'canceled'])->default('pending');
            $table->enum('payment_status', ['unpaid', 'pending', 'paid', 'failed', 'expired', 'refunded'])->default('unpaid');
            $table->timestamps();

            $table->index('user_id');
            $table->index('booking_status');
            $table->index('payment_status');
            $table->index('booking_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_bookings');
    }
};
