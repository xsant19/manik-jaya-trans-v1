<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds reserved_until column to rental_bookings for the temporary hold system.
     * When a rental booking is created, the vehicle stock is held for 30 minutes.
     * If payment is not made within 30 minutes, the booking is auto-canceled and stock returned.
     */
    public function up(): void
    {
        Schema::table('rental_bookings', function (Blueprint $table) {
            $table->timestamp('reserved_until')->nullable()->after('payment_status')
                ->comment('Hold expiry timestamp. Null if payment has been completed (permanent hold).');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rental_bookings', function (Blueprint $table) {
            $table->dropColumn('reserved_until');
        });
    }
};
