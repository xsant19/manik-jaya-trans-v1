<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('name', 255);
            $table->enum('type', ['percentage', 'fixed']);
            $table->decimal('value', 12, 2);
            $table->decimal('min_booking_amount', 12, 2)->nullable()->comment('Minimum total_price agar kupon bisa digunakan');
            $table->decimal('max_discount_amount', 12, 2)->nullable()->comment('Batas maksimal potongan (khusus tipe percentage)');
            $table->unsignedInteger('usage_limit')->nullable()->comment('Batas total penggunaan, null = unlimited');
            $table->unsignedInteger('usage_count')->default(0)->comment('Sudah berapa kali digunakan');
            $table->dateTime('started_at')->nullable()->comment('Tanggal mulai berlaku kupon');
            $table->dateTime('expired_at')->nullable()->comment('Tanggal kedaluwarsa, null = tidak expired');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
