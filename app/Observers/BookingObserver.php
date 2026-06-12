<?php

namespace App\Observers;

class BookingObserver
{
    public function updated($model)
    {
        if ($model->isDirty('booking_status')) {
            try {
                \Illuminate\Support\Facades\Mail::to($model->user->email)->send(new \App\Mail\BookingStatusUpdatedMail($model));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Failed to send booking status email: ' . $e->getMessage());
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
        $driver = \App\Models\Driver::find($driverId);
        if (!$driver || $driver->status === 'inactive') {
            return; // Don't auto-update inactive drivers
        }

        $isOnTrip = \App\Models\RentalBooking::where('driver_id', $driverId)->where('booking_status', 'on_trip')->exists() ||
                    \App\Models\TourBooking::where('driver_id', $driverId)->where('booking_status', 'on_trip')->exists() ||
                    \App\Models\TransferBooking::where('driver_id', $driverId)->where('booking_status', 'on_trip')->exists() ||
                    \App\Models\ShuttleBooking::where('driver_id', $driverId)->where('booking_status', 'on_trip')->exists();

        $newStatus = $isOnTrip ? 'on_trip' : 'available';

        if ($driver->status !== $newStatus) {
            // Using update directly without triggering model events to prevent infinite loops if Driver had observers
            \Illuminate\Support\Facades\DB::table('drivers')
                ->where('id', $driverId)
                ->update(['status' => $newStatus, 'updated_at' => now()]);
        }
    }
}
