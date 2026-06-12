<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hotel_shuttles', function (Blueprint $table) {
            // Hapus kolom hotel_name yang tidak relevan
            // Kita bungkus try-catch jika ada index sebelumnya
            try {
                $table->dropIndex(['hotel_name']);
            } catch (Exception $e) {
            }

            $table->dropColumn('hotel_name');

            // Tambah route_name seperti airport_transfers
            $table->string('route_name')->after('id');

            // Ganti index pickup/dropoff agar sejajar dengan airport_transfers
            $table->index('pickup_location');
            $table->index('dropoff_location');

            // Rename schedule → estimated_duration (konsisten dengan airport_transfers)
            $table->renameColumn('schedule', 'estimated_duration');
        });
    }

    public function down(): void
    {
        Schema::table('hotel_shuttles', function (Blueprint $table) {
            $table->dropIndex(['pickup_location']);
            $table->dropIndex(['dropoff_location']);
            $table->dropColumn('route_name');
            $table->string('hotel_name')->after('id');
            $table->index('hotel_name');
            $table->renameColumn('estimated_duration', 'schedule');
        });
    }
};
