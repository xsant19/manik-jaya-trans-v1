<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\RentalBooking;
use App\Models\ShuttleBooking;
use App\Models\TourBooking;
use App\Models\TransferBooking;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    public function download(string $type, string $bookingCode)
    {
        $models = [
            'rental' => RentalBooking::class,
            'tour' => TourBooking::class,
            'transfer' => TransferBooking::class,
            'shuttle' => ShuttleBooking::class,
        ];

        abort_if(! array_key_exists($type, $models), 404);

        $modelClass = $models[$type];

        $withRelations = match ($type) {
            'rental' => ['user', 'vehicle', 'driver', 'payment'],
            'tour' => ['user', 'tourPackage', 'payment'],
            'transfer' => ['user', 'airportTransfer', 'payment'],
            'shuttle' => ['user', 'hotelShuttle', 'payment'],
        };

        $booking = $modelClass::with($withRelations)->where('booking_code', $bookingCode)->firstOrFail();

        abort_if($booking->user_id != auth()->id(), 403);
        abort_if($booking->payment_status !== 'paid', 403, 'Invoice hanya tersedia setelah pembayaran lunas.');

        $serviceDetails = $this->getServiceDetails($booking, $type);

        $bookingTypeLabels = [
            'rental' => 'Sewa Kendaraan',
            'tour' => 'Paket Wisata',
            'transfer' => 'Airport Transfer',
            'shuttle' => 'Hotel Shuttle',
        ];

        $bookingTypeLabel = $bookingTypeLabels[$type];
        $payment = $booking->payment;

        $pdf = Pdf::loadView('invoice.booking-invoice', compact('booking', 'payment', 'bookingTypeLabel', 'serviceDetails'))->setPaper('a4');

        return $pdf->download('invoice-'.$booking->booking_code.'.pdf');
    }

    public function downloadVoucher(string $bookingCode)
    {
        $rental = RentalBooking::with(['user', 'vehicle', 'driver', 'payment'])->where('booking_code', $bookingCode)->firstOrFail();

        abort_if($rental->user_id != auth()->id(), 403);

        // Voucher tersedia selama payment lunas, driver sudah diassign,
        // dan status booking adalah approved / on_trip / completed
        $allowedStatuses = ['approved', 'on_trip', 'completed'];
        abort_if(
            $rental->payment_status !== 'paid'
                || ! in_array($rental->booking_status, $allowedStatuses)
                || ! $rental->driver_id,
            403,
            'Voucher belum tersedia.'
        );

        $pdf = Pdf::loadView('invoice.rental-voucher', compact('rental'))->setPaper('a4');

        return $pdf->download('voucher-'.$rental->booking_code.'.pdf');
    }


    private function getServiceDetails($booking, string $type): array
    {
        return match ($type) {
            'rental' => [
                'Kendaraan' => $booking->vehicle->name.' ('.$booking->vehicle->type.')',
                'Tipe Sewa' => $booking->rental_type === 'full_day' ? 'Sehari Penuh (Full Day)' : 'Setengah Hari (Half Day)',
                'Tanggal Mulai' => Carbon::parse($booking->start_date)->translatedFormat('d F Y'),
                'Tanggal Selesai' => Carbon::parse($booking->end_date)->translatedFormat('d F Y'),
                'Lokasi Jemput' => $booking->pickup_location,
                'Supir' => $booking->driver?->name ?? 'Akan dikonfirmasi admin',
                'No. HP Supir' => $booking->driver?->phone ?? '-',
            ],
            'tour' => [
                'Nama Paket' => $booking->tourPackage->name,
                'Durasi' => $booking->tourPackage->duration,
                'Tanggal Tour' => Carbon::parse($booking->booking_date)->translatedFormat('d F Y'),
                'Jumlah Peserta' => $booking->participant_count.' Orang',
            ],
            'transfer' => [
                'Rute' => $booking->airportTransfer->pickup_location.' → '.$booking->airportTransfer->dropoff_location,
                'Tanggal Layanan' => Carbon::parse($booking->booking_date)->translatedFormat('d F Y'),
                'Waktu Jemput' => $booking->pickup_time ? Carbon::parse($booking->pickup_time)->format('H:i').' WITA' : '-',
                'Jumlah Penumpang' => $booking->passenger_count.' Orang',
                'Nomor Penerbangan' => $booking->flight_number ?? '-',
            ],
            'shuttle' => [
                'Layanan' => $booking->hotelShuttle->route_name,
                'Rute' => $booking->hotelShuttle->pickup_location.' → '.$booking->hotelShuttle->dropoff_location,
                'Tanggal Layanan' => Carbon::parse($booking->booking_date)->translatedFormat('d F Y'),
                'Waktu Jemput' => $booking->pickup_time ? Carbon::parse($booking->pickup_time)->format('H:i').' WITA' : '-',
                'Estimasi Waktu' => $booking->hotelShuttle->estimated_duration,
                'Jumlah Penumpang' => $booking->passenger_count.' Orang',
            ],
            default => [],
        };
    }
}
