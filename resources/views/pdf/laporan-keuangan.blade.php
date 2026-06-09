<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <style>
    body {
        font-family: 'DejaVu Sans', sans-serif;
        margin: 30px;
        color: #1a1a2e;
        font-size: 12px;
        line-height: 1.4;
    }
    .header-table {
        width: 100%;
        margin-bottom: 20px;
        border-bottom: 3px solid #1a1a2e;
        padding-bottom: 10px;
    }
    .header-left {
        width: 50%;
        vertical-align: top;
    }
    .header-right {
        width: 50%;
        vertical-align: top;
        text-align: right;
    }
    .company-name {
        font-size: 18px;
        font-weight: bold;
    }
    .report-title {
        font-size: 22px;
        font-weight: bold;
        color: #1a1a2e;
        margin-bottom: 5px;
        text-transform: uppercase;
    }
    .period-text {
        font-size: 13px;
        color: #6a6a6a;
    }
    .stats-table {
        width: 100%;
        margin-bottom: 25px;
    }
    .stat-box {
        background-color: #f1f5f9;
        border-radius: 6px;
        padding: 14px;
        text-align: center;
        width: 30%;
    }
    .stat-value {
        font-size: 18px;
        font-weight: bold;
        color: #1a1a2e;
    }
    .stat-label {
        font-size: 11px;
        color: #6a6a6a;
        margin-top: 4px;
    }
    .section-title {
        background-color: #f1f5f9;
        padding: 6px 10px;
        font-weight: bold;
        margin-top: 20px;
        margin-bottom: 10px;
    }
    .report-table {
        width: 100%;
        border-collapse: collapse;
    }
    .report-table th {
        background-color: #1a1a2e;
        color: white;
        text-align: left;
        padding: 8px 6px;
        font-size: 11px;
    }
    .report-table td {
        padding: 6px;
        border-bottom: 1px solid #e2e8f0;
        font-size: 11px;
    }
    .report-table tr:nth-child(even) {
        background-color: #f8fafc;
    }
    .report-table .text-right {
        text-align: right;
    }
    .total-row {
        font-weight: bold;
        border-top: 2px solid #1a1a2e;
        background-color: #f1f5f9 !important;
    }
    .footer {
        border-top: 1px solid #dddddd;
        padding-top: 10px;
        text-align: center;
        font-size: 9px;
        color: #999;
        margin-top: 30px;
    }
  </style>
</head>
<body>

  <table class="header-table">
    <tr>
      <td class="header-left">
        <div class="company-name">{{ config('company.name', 'Manik Jaya Trans') }}</div>
        <div>{{ config('company.address', 'Jl. Contoh Alamat No. 123, Bali') }}</div>
        <div>Telp: {{ config('company.phone', '+6281234567890') }}</div>
      </td>
      <td class="header-right">
        <div class="report-title">Laporan Keuangan</div>
        <div class="period-text">
          Periode: {{ $from->translatedFormat('d F Y') }} &mdash; {{ $to->translatedFormat('d F Y') }}
        </div>
        <div>Tanggal Cetak: {{ now()->translatedFormat('d F Y H:i') }} WITA</div>
      </td>
    </tr>
  </table>

  <table class="stats-table">
    <tr>
      <td class="stat-box">
        <div class="stat-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        <div class="stat-label">Total Pendapatan</div>
      </td>
      <td style="width: 5%;"></td>
      <td class="stat-box">
        <div class="stat-value">{{ $totalTransactions }}</div>
        <div class="stat-label">Total Transaksi</div>
      </td>
      <td style="width: 5%;"></td>
      <td class="stat-box">
        <div class="stat-value">Rp {{ number_format($averagePerTx, 0, ',', '.') }}</div>
        <div class="stat-label">Rata-rata / Transaksi</div>
      </td>
    </tr>
  </table>

  <div class="section-title">DETAIL TRANSAKSI</div>

  @if($payments->count() > 0)
    <table class="report-table">
      <thead>
        <tr>
          <th style="width: 30px;">No</th>
          <th>Kode Booking</th>
          <th>Customer</th>
          <th>Tipe Layanan</th>
          <th>Metode</th>
          <th class="text-right">Jumlah</th>
          <th>Tanggal Bayar</th>
        </tr>
      </thead>
      <tbody>
        @php $typeMap = [
            'App\\Models\\RentalBooking'   => 'Sewa Kendaraan',
            'App\\Models\\TourBooking'     => 'Paket Wisata',
            'App\\Models\\TransferBooking' => 'Airport Transfer',
            'App\\Models\\ShuttleBooking'  => 'Hotel Shuttle',
        ]; @endphp

        @foreach($payments as $index => $payment)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $payment->booking_code }}</td>
            <td>{{ optional($payment->user)->name ?? '-' }}</td>
            <td>{{ $typeMap[$payment->payable_type] ?? '-' }}</td>
            <td>{{ $payment->payment_method ?? '-' }}</td>
            <td class="text-right">Rp {{ number_format($payment->gross_amount, 0, ',', '.') }}</td>
            <td>{{ optional($payment->paid_at)?->format('d/m/Y H:i') ?? '-' }}</td>
          </tr>
        @endforeach

        <tr class="total-row">
          <td colspan="5">TOTAL</td>
          <td class="text-right">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
          <td></td>
        </tr>
      </tbody>
    </table>
  @else
    <div style="text-align: center; padding: 40px; color: #6a6a6a;">
      Tidak ada transaksi pada periode ini.
    </div>
  @endif

  <div class="footer">
    <div>{{ config('company.name', 'Manik Jaya Trans') }} | {{ config('company.address', 'Jl. Contoh Alamat No. 123, Bali') }}</div>
    <div>Laporan ini dibuat secara otomatis oleh sistem. Data yang ditampilkan adalah transaksi berstatus LUNAS (paid).</div>
  </div>

</body>
</html>
