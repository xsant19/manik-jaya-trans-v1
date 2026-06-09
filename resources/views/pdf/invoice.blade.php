<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <style>
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
        border-bottom: 1px solid #e2e8f0;
    }
    .payment-total {
        font-weight: bold;
        border-top: 2px solid #1a1a2e;
    }
    .status-box {
        margin-top: 20px;
        padding: 12px;
        border-radius: 6px;
        text-align: center;
        font-weight: bold;
        font-size: 16px;
    }
    .status-paid {
        background-color: #f0fdf4;
        border: 2px solid #10b981;
        color: #10b981;
    }
    .status-pending {
        background-color: #fffbeb;
        border: 2px solid #f59e0b;
        color: #f59e0b;
    }
    .status-unpaid {
        background-color: #fef2f2;
        border: 2px solid #ef4444;
        color: #ef4444;
    }
    .bank-info {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 14px;
        margin-top: 20px;
    }
    .bank-info-title {
        font-weight: bold;
        margin-bottom: 8px;
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
        <div>No: INV/{{ optional($payment->paid_at)->format('Ymd') ?? now()->format('Ymd') }}/{{ strtoupper($booking->booking_code) }}</div>
        <div>Tanggal Cetak: {{ now()->translatedFormat('d F Y') }}</div>
        <div>Status: {{ strtoupper($payment->status) }}</div>
      </td>
    </tr>
  </table>

  <div class="section-title">DATA PELANGGAN</div>
  <table class="data-table">
    <tr>
      <td>Nama</td>
      <td>: {{ optional($booking->user)->name }}</td>
    </tr>
    <tr>
      <td>Email</td>
      <td>: {{ optional($booking->user)->email }}</td>
    </tr>
    <tr>
      <td>No. Telepon</td>
      <td>: {{ optional($booking->user)->phone ?? '-' }}</td>
    </tr>
    <tr>
      <td>Kode Booking</td>
      <td>: {{ strtoupper($booking->booking_code) }}</td>
    </tr>
  </table>

  <div class="section-title">DETAIL LAYANAN &mdash; {{ $typeLabel }}</div>
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
        <td>{{ $typeLabel }}</td>
        <td style="text-align: right;">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
      </tr>
      <tr class="payment-total">
        <td>TOTAL</td>
        <td style="text-align: right;">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
      </tr>
    </tbody>
  </table>

  <table class="data-table" style="margin-top: 15px;">
    <tr>
      <td>Metode Pembayaran</td>
      <td>: {{ $payment->payment_method ?? '-' }}</td>
    </tr>
    <tr>
      <td>Transaction ID</td>
      <td>: {{ $payment->transaction_id ?? '-' }}</td>
    </tr>
    <tr>
      <td>Tanggal Pembayaran</td>
      <td>: {{ optional($payment->paid_at)->translatedFormat('d F Y H:i') ?? '-' }} WITA</td>
    </tr>
  </table>

  @if($payment->status === 'paid')
    <div class="status-box status-paid">&#10003; LUNAS</div>
  @elseif($payment->status === 'pending')
    <div class="status-box status-pending">MENUNGGU PEMBAYARAN</div>
  @else
    <div class="status-box status-unpaid">{{ strtoupper($payment->status) }}</div>
  @endif

  @if($payment->status !== 'paid')
    <div class="bank-info">
      <div class="bank-info-title">Instruksi Pembayaran:</div>
      <div>Silakan lakukan pembayaran melalui Midtrans sesuai instruksi yang telah dikirimkan.</div>
      <div>Jika mengalami kendala, hubungi kami di {{ config('company.phone', '+6281234567890') }}.</div>
    </div>
  @endif

  <div class="footer">
    <div>Dokumen ini adalah bukti tagihan/pembayaran dari {{ config('company.name', 'Manik Jaya Trans') }}.</div>
    <div>Terima kasih telah menggunakan layanan kami.</div>
  </div>

</body>
</html>
