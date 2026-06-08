<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <style>
    /* font-family: 'DejaVu Sans', sans-serif — WAJIB, support karakter Indonesia */
    /* warna utama: #1a1a2e (navy) | aksen: #10b981 (hijau) */
    /* paper: A4, body margin 40px */
    body {
        font-family: 'DejaVu Sans', sans-serif;
        margin: 40px;
        color: #1a1a2e;
        font-size: 14px;
        line-height: 1.5;
    }
    .header-table {
        width: 100%;
        margin-bottom: 20px;
        border-bottom: 2px solid #1a1a2e;
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
        font-size: 20px;
        font-weight: bold;
    }
    .invoice-title {
        font-size: 28px;
        font-weight: bold;
        color: #1a1a2e;
        margin-bottom: 5px;
        text-transform: uppercase;
    }
    .section-title {
        background-color: #f1f5f9;
        padding: 6px 10px;
        font-weight: bold;
        margin-top: 20px;
        margin-bottom: 10px;
    }
    .data-table {
        width: 100%;
        margin-bottom: 15px;
    }
    .data-table td {
        padding: 4px;
        vertical-align: top;
    }
    .data-table td:first-child {
        width: 180px;
    }
    .payment-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    .payment-table th {
        background-color: #1a1a2e;
        color: white;
        text-align: left;
        padding: 10px;
    }
    .payment-table td {
        padding: 10px;
    }
    .payment-total {
        font-weight: bold;
        border-top: 2px solid #1a1a2e;
    }
    .stamp-container {
        text-align: right;
    }
    .stamp {
        color: #10b981;
        border: 2px solid #10b981;
        padding: 4px 16px;
        font-size: 20px;
        font-weight: bold;
        display: inline-block;
        transform: rotate(-12deg);
        margin-top: 10px;
    }
    .footer {
        border-top: 1px solid #dddddd;
        padding-top: 10px;
        text-align: center;
        font-size: 10px;
        color: #999;
        margin-top: 50px;
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
        <div>Email: {{ config('company.email', 'info@manikjaya.test') }}</div>
      </td>
      <td class="header-right">
        <div class="invoice-title">INVOICE</div>
        <div>No: INV/{{ optional($payment->paid_at)->format('Ymd') ?? date('Ymd') }}/{{ strtoupper($booking->booking_code) }}</div>
        <div>Tanggal Cetak: {{ now()->translatedFormat('d F Y') }}</div>
        <div>Tanggal Bayar: {{ optional($payment->paid_at)->translatedFormat('d F Y H:i') ?? '-' }} WITA</div>
      </td>
    </tr>
  </table>

  <div class="section-title">DATA PELANGGAN</div>
  <table class="data-table">
    <tr>
      <td>Nama</td>
      <td>: {{ $booking->user->name }}</td>
    </tr>
    <tr>
      <td>Email</td>
      <td>: {{ $booking->user->email }}</td>
    </tr>
    <tr>
      <td>No. Telepon</td>
      <td>: {{ $booking->user->phone ?? '-' }}</td>
    </tr>
    <tr>
      <td>Kode Booking</td>
      <td>: {{ strtoupper($booking->booking_code) }}</td>
    </tr>
  </table>

  <div class="section-title">DETAIL LAYANAN &mdash; {{ $bookingTypeLabel }}</div>
  <table class="data-table">
    @foreach($serviceDetails as $label => $value)
      <tr>
        <td>{{ $label }}</td>
        <td>: {{ $value }}</td>
      </tr>
    @endforeach
  </table>

  <div class="section-title">RINCIAN PEMBAYARAN</div>
  <table class="payment-table">
    <thead>
      <tr>
        <th>Keterangan</th>
        <th style="text-align: right;">Jumlah</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>{{ $bookingTypeLabel }}</td>
        <td style="text-align: right;">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
      </tr>
      <tr class="payment-total">
        <td>TOTAL</td>
        <td style="text-align: right;">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
      </tr>
    </tbody>
  </table>

  <div class="stamp-container">
      <div class="stamp">&check; LUNAS</div>
  </div>
  
  <div class="footer">
    <div>Dokumen ini adalah bukti pembayaran sah dari {{ config('company.name', 'Manik Jaya Trans') }}.</div>
    <div>Terima kasih telah menggunakan layanan kami.</div>
    <div>Metode Pembayaran: Midtrans | Transaction ID: {{ optional($payment)->transaction_id ?? '-' }}</div>
  </div>

</body>
</html>
