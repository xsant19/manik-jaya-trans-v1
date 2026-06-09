<?php

namespace App\Http\Controllers;

use App\Exports\LaporanKeuanganExport;
use App\Models\Payment;
use App\Models\RentalBooking;
use App\Models\ShuttleBooking;
use App\Models\TourBooking;
use App\Models\TransferBooking;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DocumentController extends Controller
{
    /**
     * Model map per booking type.
     */
    private function getBookingModelMap(): array
    {
        return [
            'rental'   => RentalBooking::class,
            'tour'     => TourBooking::class,
            'transfer' => TransferBooking::class,
            'shuttle'  => ShuttleBooking::class,
        ];
    }

    /**
     * Eager-load relations per booking type.
     */
    private function getRelationsMap(): array
    {
        return [
            'rental'   => ['user', 'vehicle', 'driver', 'payment'],
            'tour'     => ['user', 'tourPackage', 'payment'],
            'transfer' => ['user', 'airportTransfer', 'payment'],
            'shuttle'  => ['user', 'hotelShuttle', 'payment'],
        ];
    }

    /**
     * Human-readable label per booking type.
     */
    private function getTypeLabels(): array
    {
        return [
            'rental'   => 'Sewa Kendaraan',
            'tour'     => 'Paket Wisata',
            'transfer' => 'Airport Transfer',
            'shuttle'  => 'Hotel Shuttle',
        ];
    }

    /**
     * Resolve a booking by type + id with eager-loaded relations.
     */
    private function resolveBooking(string $type, int $id)
    {
        $models    = $this->getBookingModelMap();
        $relations = $this->getRelationsMap();

        abort_if(! array_key_exists($type, $models), 404);

        return $models[$type]::with($relations[$type])->findOrFail($id);
    }

    /**
     * Build service detail array for PDF templates.
     */
    private function getServiceDetails($booking, string $type): array
    {
        return match ($type) {
            'rental' => [
                'Kendaraan'       => optional($booking->vehicle)->name . ' (' . optional($booking->vehicle)->type . ')',
                'Tipe Sewa'       => $booking->rental_type === 'full_day' ? 'Sehari Penuh (Full Day)' : 'Setengah Hari (Half Day)',
                'Tanggal Mulai'   => Carbon::parse($booking->start_date)->translatedFormat('d F Y'),
                'Tanggal Selesai' => Carbon::parse($booking->end_date)->translatedFormat('d F Y'),
                'Lokasi Jemput'   => $booking->pickup_location,
                'Supir'           => optional($booking->driver)->name ?? 'Akan dikonfirmasi admin',
                'No. HP Supir'    => optional($booking->driver)->phone ?? '-',
            ],
            'tour' => [
                'Nama Paket'     => optional($booking->tourPackage)->name,
                'Durasi'         => optional($booking->tourPackage)->duration,
                'Tanggal Tour'   => Carbon::parse($booking->booking_date)->translatedFormat('d F Y'),
                'Jumlah Peserta' => $booking->participant_count . ' Orang',
            ],
            'transfer' => [
                'Rute'              => optional($booking->airportTransfer)->pickup_location . ' → ' . optional($booking->airportTransfer)->dropoff_location,
                'Tanggal Layanan'   => Carbon::parse($booking->booking_date)->translatedFormat('d F Y'),
                'Waktu Jemput'      => $booking->pickup_time ? Carbon::parse($booking->pickup_time)->format('H:i') . ' WITA' : '-',
                'Jumlah Penumpang'  => $booking->passenger_count . ' Orang',
                'Nomor Penerbangan' => $booking->flight_number ?? '-',
            ],
            'shuttle' => [
                'Layanan'          => optional($booking->hotelShuttle)->route_name,
                'Rute'             => optional($booking->hotelShuttle)->pickup_location . ' → ' . optional($booking->hotelShuttle)->dropoff_location,
                'Tanggal Layanan'  => Carbon::parse($booking->booking_date)->translatedFormat('d F Y'),
                'Waktu Jemput'     => $booking->pickup_time ? Carbon::parse($booking->pickup_time)->format('H:i') . ' WITA' : '-',
                'Jumlah Penumpang' => $booking->passenger_count . ' Orang',
            ],
            default => [],
        };
    }

    // ─────────────────────────────────────────────────────────────────────
    //  SPK / Surat Jalan
    // ─────────────────────────────────────────────────────────────────────

    public function spk(string $type, int $id)
    {
        $booking = $this->resolveBooking($type, $id);

        abort_if(
            ! in_array($booking->booking_status, ['approved', 'on_trip', 'completed']),
            403,
            'SPK hanya tersedia untuk booking yang sudah disetujui.'
        );

        $typeLabel      = $this->getTypeLabels()[$type];
        $serviceDetails = $this->getServiceDetails($booking, $type);
        $spkNumber      = 'SPK/' . now()->format('Ymd') . '/' . strtoupper($booking->booking_code);

        $pdf = Pdf::loadView('pdf.spk', compact(
            'booking', 'type', 'typeLabel', 'serviceDetails', 'spkNumber'
        ))->setPaper('a4');

        return $pdf->download('spk-' . $booking->booking_code . '.pdf');
    }

    // ─────────────────────────────────────────────────────────────────────
    //  Invoice / Tagihan (dari Payment record)
    // ─────────────────────────────────────────────────────────────────────

    public function invoice(int $id)
    {
        $payment = Payment::with(['user', 'payable'])->findOrFail($id);

        $booking = $payment->payable;
        abort_if(! $booking, 404, 'Booking terkait tidak ditemukan.');

        // Determine booking type from payable_type
        $typeMap = [
            RentalBooking::class   => 'rental',
            TourBooking::class     => 'tour',
            TransferBooking::class => 'transfer',
            ShuttleBooking::class  => 'shuttle',
        ];

        $type = $typeMap[$payment->payable_type] ?? null;
        abort_if(! $type, 404);

        // Re-load booking with full relations
        $booking        = $this->resolveBooking($type, $booking->id);
        $typeLabel      = $this->getTypeLabels()[$type];
        $serviceDetails = $this->getServiceDetails($booking, $type);

        $pdf = Pdf::loadView('pdf.invoice', compact(
            'booking', 'payment', 'typeLabel', 'serviceDetails'
        ))->setPaper('a4');

        return $pdf->download('invoice-' . $payment->booking_code . '.pdf');
    }

    // ─────────────────────────────────────────────────────────────────────
    //  E-Voucher / Kuitansi Lunas
    // ─────────────────────────────────────────────────────────────────────

    public function evoucher(string $type, int $id)
    {
        $booking = $this->resolveBooking($type, $id);

        abort_if(
            ! in_array($booking->booking_status, ['approved', 'on_trip', 'completed']),
            403,
            'E-Voucher hanya tersedia untuk booking yang sudah disetujui.'
        );

        abort_if(
            $booking->payment_status !== 'paid',
            403,
            'E-Voucher hanya tersedia setelah pembayaran lunas.'
        );

        $typeLabel      = $this->getTypeLabels()[$type];
        $serviceDetails = $this->getServiceDetails($booking, $type);
        $payment        = $booking->payment;

        $pdf = Pdf::loadView('pdf.evoucher', compact(
            'booking', 'type', 'typeLabel', 'serviceDetails', 'payment'
        ))->setPaper('a4');

        return $pdf->download('evoucher-' . $booking->booking_code . '.pdf');
    }

    // ─────────────────────────────────────────────────────────────────────
    //  Laporan Keuangan — PDF
    // ─────────────────────────────────────────────────────────────────────

    public function laporanKeuanganPdf(Request $request)
    {
        $from = Carbon::parse($request->input('from', now()->startOfMonth()->toDateString()))->startOfDay();
        $to   = Carbon::parse($request->input('to', now()->toDateString()))->endOfDay();

        $payments = Payment::with(['user', 'payable'])
            ->where('status', 'paid')
            ->whereBetween('paid_at', [$from, $to])
            ->orderBy('paid_at', 'asc')
            ->get();

        $totalRevenue     = $payments->sum('gross_amount');
        $totalTransactions = $payments->count();
        $averagePerTx     = $totalTransactions > 0 ? $totalRevenue / $totalTransactions : 0;

        $pdf = Pdf::loadView('pdf.laporan-keuangan', compact(
            'payments', 'from', 'to', 'totalRevenue', 'totalTransactions', 'averagePerTx'
        ))->setPaper('a4', 'landscape');

        return $pdf->download('laporan-keuangan-' . $from->format('Ymd') . '-' . $to->format('Ymd') . '.pdf');
    }

    // ─────────────────────────────────────────────────────────────────────
    //  Laporan Keuangan — Excel
    // ─────────────────────────────────────────────────────────────────────

    public function laporanKeuanganExcel(Request $request)
    {
        $from = Carbon::parse($request->input('from', now()->startOfMonth()->toDateString()))->startOfDay();
        $to   = Carbon::parse($request->input('to', now()->toDateString()))->endOfDay();

        $filename = 'laporan-keuangan-' . $from->format('Ymd') . '-' . $to->format('Ymd') . '.xlsx';

        return Excel::download(new LaporanKeuanganExport($from, $to), $filename);
    }
}
