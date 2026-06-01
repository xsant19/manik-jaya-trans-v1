<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabel payments polymorphic untuk berbagai jenis booking.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->morphs('payable'); // Creates payable_type and payable_id
            $table->string('booking_code');
            $table->string('payment_method')->nullable();
            $table->string('payment_gateway')->nullable();
            $table->string('transaction_id')->nullable();
            $table->decimal('gross_amount', 12, 2);
            $table->enum('status', ['pending', 'paid', 'failed', 'expired', 'refunded'])->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->json('raw_response')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('booking_code');
            $table->index('status');
            $table->index('transaction_id');
            // morphs() automatically creates an index for payable_type and payable_id
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
