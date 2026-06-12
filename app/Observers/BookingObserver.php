<?php

namespace App\Observers;

use App\Mail\BookingStatusUpdatedMail;
use App\Models\Driver;
use App\Models\RentalBooking;
use App\Models\ShuttleBooking;
use App\Models\TourBooking;
use App\Models\TransferBooking;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class BookingObserver
{
    public function updated($model)
    {
        if ($model->isDirty('booking_status')) {
            try {
                Mail::to($model->user->email)->send(new BookingStatusUpdatedMail($model));
            } catch (\Exception $e) {
                Log::error('Failed to send booking status email: '.$e->getMessage());
            }
        }

        // Driver status automation
        if ($model->isDirty('booking_status') || $model->isDirty('driver_id')) {
            $this->updateDriverStatus($model);
        }
    }

    protected function updateDriverStatus($model)
    {
        $originalDriverId = $model->getOriginal('driver_id');
        $currentDriverId = $model->driver_id;

        if ($originalDriverId && $originalDriverId !== $currentDriverId) {
            $this->recalculateDriverStatus($originalDriverId);
        }

        if ($currentDriverId) {
            $this->recalculateDriverStatus($currentDriverId);
        }
    }

    protected function recalculateDriverStatus($driverId)
    {
        $driver = Driver::find($driverId);
        if (! $driver || $driver->status === 'inactive') {
            return; // Don't auto-update inactive drivers
        }

        $isOnTrip = RentalBooking::where('driver_id', $driverId)->where('booking_status', 'on_trip')->exists() ||
                    TourBooking::where('driver_id', $driverId)->where('booking_status', 'on_trip')->exists() ||
                    TransferBooking::where('driver_id', $driverId)->where('booking_status', 'on_trip')->exists() ||
                    ShuttleBooking::where('driver_id', $driverId)->where('booking_status', 'on_trip')->exists();

        $newStatus = $isOnTrip ? 'on_trip' : 'available';

        if ($driver->status !== $newStatus) {
            // Using update directly without triggering model events to prevent infinite loops if Driver had observers
            DB::table('drivers')
                ->where('id', $driverId)
                ->update(['status' => $newStatus, 'updated_at' => now()]);
        }
    }
}
