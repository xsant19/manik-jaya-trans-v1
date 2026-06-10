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
        Schema::create('vehicle_inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')
                  ->constrained('vehicles')
                  ->onDelete('cascade');
            $table->date('date');
            $table->integer('stock')->default(1);
            $table->timestamps();

            // Unique constraint: one record per vehicle per date
            $table->unique(['vehicle_id', 'date'], 'unique_vehicle_date');

            // Indexes for performance
            $table->index('vehicle_id', 'idx_vehicle_inventory_vehicle');
            $table->index('date', 'idx_vehicle_inventory_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_inventories');
    }
};
