<?php

namespace App\Console\Commands;

use App\Models\RentalBooking;
use App\Models\ShuttleBooking;
use App\Models\TourBooking;
use App\Models\TransferBooking;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CancelExpiredBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking:cancel-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Batalkan hold kendaraan yang kedaluwarsa (> 30 menit) dan pesanan yang belum dibayar > 24 jam';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $totalCanceled = 0;

        // ─────────────────────────────────────────────────────────────────
        // STEP 1: Cancel RentalBooking dengan hold expired (reserved_until)
        // Hold 30 menit — jika belum bayar, batalkan dan kembalikan stok
        // Stock otomatis dikembalikan oleh BookingStockObserver saat status → canceled
        // ─────────────────────────────────────────────────────────────────
        $expiredHolds = RentalBooking::where('booking_status', 'pending')
            ->where('payment_status', 'unpaid')
            ->whereNotNull('reserved_until')
            ->where('reserved_until', '<=', now())
            ->get();

        foreach ($expiredHolds as $booking) {
            $booking->update(['booking_status' => 'canceled']);
            // BookingStockObserver::updated() akan memanggil returnStockForCancellation()
            // sehingga stok otomatis dikembalikan ke vehicle_inventories
            $totalCanceled++;
            $this->info("Canceled expired hold: {$booking->booking_code} (hold expired at {$booking->reserved_until})");
            Log::info("Hold expired & canceled: {$booking->booking_code}");
        }

        // ─────────────────────────────────────────────────────────────────
        // STEP 2: Cancel semua booking yang belum bayar > 24 jam (fallback umum)
        // Mencakup RentalBooking tanpa reserved_until (data lama) & booking lain
        // ─────────────────────────────────────────────────────────────────
        $models = [
            RentalBooking::class,
            TourBooking::class,
            TransferBooking::class,
            ShuttleBooking::class,
        ];

        $expirationTime = now()->subHours(24);

        foreach ($models as $modelClass) {
            $expiredBookings = $modelClass::where('booking_status', 'pending')
                ->where('payment_status', 'unpaid')
                ->where('created_at', '<=', $expirationTime)
                ->get();

            foreach ($expiredBookings as $booking) {
                $booking->update(['booking_status' => 'canceled']);
                $totalCanceled++;
                $this->info("Canceled unpaid booking: {$booking->booking_code}");
                Log::info("Unpaid booking canceled (24h fallback): {$booking->booking_code}");
            }
        }

        $this->info("Total pesanan dibatalkan: {$totalCanceled}");

        return Command::SUCCESS;
    }
}

