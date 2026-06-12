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
        Schema::table('shuttle_bookings', function (Blueprint $table) {
            $table->foreignId('vehicle_id')
                ->nullable()
                ->after('hotel_shuttle_id')
                ->constrained('vehicles')
                ->onDelete('set null');

            $table->foreignId('driver_id')
                ->nullable()
                ->after('vehicle_id')
                ->constrained('drivers')
                ->onDelete('set null');

            $table->timestamp('completed_at')
                ->nullable()
                ->after('booking_status');

            // Indexes
            $table->index('vehicle_id', 'idx_shuttle_vehicle');
            $table->index('driver_id', 'idx_shuttle_driver');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shuttle_bookings', function (Blueprint $table) {
            $table->dropForeign(['vehicle_id']);
            $table->dropForeign(['driver_id']);
            $table->dropIndex('idx_shuttle_vehicle');
            $table->dropIndex('idx_shuttle_driver');
            $table->dropColumn(['vehicle_id', 'driver_id', 'completed_at']);
        });
    }
};
