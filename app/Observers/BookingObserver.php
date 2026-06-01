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
    }
}
