<?php

namespace App\Exports;

use App\Models\Payment;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanKeuanganExport implements WithMultipleSheets
{
    use Exportable;

    public function __construct(
        private Carbon $from,
        private Carbon $to,
    ) {}

    public function sheets(): array
    {
        $payments = Payment::with(['user', 'payable'])
            ->where('status', 'paid')
            ->whereBetween('paid_at', [$this->from, $this->to])
            ->orderBy('paid_at', 'asc')
            ->get();

        return [
            new RingkasanSheet($payments, $this->from, $this->to),
            new DetailTransaksiSheet($payments),
        ];
    }
}

// ─────────────────────────────────────────────────────────────────────────────
//  Sheet 1 — Ringkasan
// ─────────────────────────────────────────────────────────────────────────────

class RingkasanSheet implements FromCollection, WithTitle, WithHeadings, ShouldAutoSize, WithStyles
{
    public function __construct(
        private $payments,
        private Carbon $from,
        private Carbon $to,
    ) {}

    public function title(): string
    {
        return 'Ringkasan';
    }

    public function headings(): array
    {
        return ['Keterangan', 'Nilai'];
    }

    public function collection()
    {
        $totalRevenue      = $this->payments->sum('gross_amount');
        $totalTransactions = $this->payments->count();
        $average           = $totalTransactions > 0 ? $totalRevenue / $totalTransactions : 0;

        return collect([
            ['Periode', $this->from->format('d/m/Y') . ' — ' . $this->to->format('d/m/Y')],
            ['Total Pendapatan', 'Rp ' . number_format($totalRevenue, 0, ',', '.')],
            ['Jumlah Transaksi', $totalTransactions],
            ['Rata-rata per Transaksi', 'Rp ' . number_format($average, 0, ',', '.')],
        ]);
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}

// ─────────────────────────────────────────────────────────────────────────────
//  Sheet 2 — Detail Transaksi
// ─────────────────────────────────────────────────────────────────────────────

class DetailTransaksiSheet implements FromCollection, WithTitle, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    private int $rowNumber = 0;

    public function __construct(
        private $payments,
    ) {}

    public function title(): string
    {
        return 'Detail Transaksi';
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode Booking',
            'Customer',
            'Tipe Layanan',
            'Metode Pembayaran',
            'Jumlah (Rp)',
            'Status',
            'Tanggal Bayar',
        ];
    }

    public function collection()
    {
        return $this->payments;
    }

    /**
     * @param  Payment  $payment
     */
    public function map($payment): array
    {
        $this->rowNumber++;

        $typeMap = [
            'App\\Models\\RentalBooking'   => 'Sewa Kendaraan',
            'App\\Models\\TourBooking'     => 'Paket Wisata',
            'App\\Models\\TransferBooking' => 'Airport Transfer',
            'App\\Models\\ShuttleBooking'  => 'Hotel Shuttle',
        ];

        return [
            $this->rowNumber,
            $payment->booking_code,
            optional($payment->user)->name ?? '-',
            $typeMap[$payment->payable_type] ?? '-',
            $payment->payment_method ?? '-',
            number_format($payment->gross_amount, 0, ',', '.'),
            ucfirst($payment->status),
            optional($payment->paid_at)?->format('d/m/Y H:i') ?? '-',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 11]],
        ];
    }
}
