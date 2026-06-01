<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabel rute airport transfer.
     */
    public function up(): void
    {
        Schema::create('airport_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('route_name');
            $table->string('pickup_location');
            $table->string('dropoff_location');
            $table->decimal('price', 12, 2);
            $table->string('estimated_duration')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();

            $table->index('status');
            $table->index('pickup_location');
            $table->index('dropoff_location');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('airport_transfers');
    }
};
