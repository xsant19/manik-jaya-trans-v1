<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
    protected $description = 'Batalkan pesanan yang belum dibayar selama lebih dari 24 jam';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $models = [
            \App\Models\RentalBooking::class,
            \App\Models\TourBooking::class,
            \App\Models\TransferBooking::class,
            \App\Models\ShuttleBooking::class,
        ];

        $expirationTime = now()->subHours(24);
        $totalCanceled = 0;

        foreach ($models as $modelClass) {
            $expiredBookings = $modelClass::where('booking_status', 'pending')
                ->where('payment_status', 'unpaid')
                ->where('created_at', '<=', $expirationTime)
                ->get();

            foreach ($expiredBookings as $booking) {
                $booking->update([
                    'booking_status' => 'canceled',
                ]);
                
                $totalCanceled++;
                $this->info("Canceled booking: {$booking->booking_code}");
            }
        }

        $this->info("Total pesanan dibatalkan: {$totalCanceled}");
    }
}
