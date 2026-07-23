<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tables = ['rental_bookings', 'tour_bookings', 'transfer_bookings', 'shuttle_bookings'];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->foreignId('coupon_id')->nullable()->constrained('coupons')->nullOnDelete()->after('payment_status');
                $table->string('coupon_code', 50)->nullable()->after('coupon_id')->comment('Snapshot kode kupon untuk historis');
                $table->decimal('discount_amount', 12, 2)->default(0)->after('coupon_code')->comment('Nominal potongan diskon yang diberikan');
                $table->decimal('original_price', 12, 2)->nullable()->after('discount_amount')->comment('Harga sebelum diskon untuk keperluan audit');
            });
        }
    }

    public function down(): void
    {
        $tables = ['rental_bookings', 'tour_bookings', 'transfer_bookings', 'shuttle_bookings'];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                $table->dropForeign([$tableName . '_coupon_id_foreign']);
                $table->dropColumn(['coupon_id', 'coupon_code', 'discount_amount', 'original_price']);
            });
        }
    }
};
