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
        border-bottom: 3px solid #10b981;
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
    .voucher-title {
        font-size: 24px;
        font-weight: bold;
        color: #10b981;
        margin-bottom: 5px;
    }
    .voucher-subtitle {
        font-size: 12px;
        color: #6a6a6a;
    }
    .paid-badge {
        display: inline-block;
        background-color: #10b981;
        color: white;
        padding: 6px 20px;
        border-radius: 4px;
        font-size: 16px;
        font-weight: bold;
        margin-top: 10px;
    }
    .section-title {
        background-color: #f0fdf4;
        padding: 6px 10px;
        font-weight: bold;
        margin-top: 20px;
        margin-bottom: 10px;
        color: #10b981;
        border-left: 4px solid #10b981;
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
    .highlight-box {
        background-color: #f0fdf4;
        border: 2px solid #10b981;
        border-radius: 8px;
        padding: 20px;
        margin-top: 20px;
        text-align: center;
    }
    .highlight-code {
        font-size: 22px;
        font-weight: bold;
        color: #1a1a2e;
        letter-spacing: 2px;
    }
    .highlight-label {
        font-size: 12px;
        color: #6a6a6a;
        margin-bottom: 6px;
    }
    .payment-summary {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 14px;
        margin-top: 20px;
    }
    .payment-summary-table {
        width: 100%;
    }
    .payment-summary-table td {
        padding: 4px;
    }
    .payment-summary-table .amount {
        text-align: right;
        font-weight: bold;
        font-size: 18px;
    }
    .instruction-box {
        background-color: #fffbeb;
        border: 1px solid #fde68a;
        border-radius: 6px;
        padding: 14px;
        margin-top: 24px;
    }
    .instruction-title {
        font-weight: bold;
        margin-bottom: 8px;
    }
    .instruction-list {
        margin: 0;
        padding-left: 0;
        list-style-type: none;
    }
    .instruction-list li {
        margin-bottom: 4px;
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
        <div class="voucher-title">E-VOUCHER</div>
        <div class="voucher-subtitle">Kuitansi Pembayaran Lunas</div>
        <div>Tanggal Cetak: {{ now()->translatedFormat('d F Y') }}</div>
        <div class="paid-badge">&#10003; LUNAS</div>
      </td>
    </tr>
  </table>

  <div class="highlight-box">
    <div class="highlight-label">KODE BOOKING</div>
    <div class="highlight-code">{{ strtoupper($booking->booking_code) }}</div>
  </div>

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

  <div class="payment-summary">
    <table class="payment-summary-table">
      <tr>
        <td>Total Pembayaran</td>
        <td class="amount">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
      </tr>
      <tr>
        <td>Metode Pembayaran</td>
        <td style="text-align: right;">{{ optional($payment)->payment_method ?? 'Midtrans' }}</td>
      </tr>
      <tr>
        <td>Transaction ID</td>
        <td style="text-align: right;">{{ optional($payment)->transaction_id ?? '-' }}</td>
      </tr>
      <tr>
        <td>Tanggal Bayar</td>
        <td style="text-align: right;">{{ optional($payment?->paid_at)->translatedFormat('d F Y H:i') ?? '-' }} WITA</td>
      </tr>
    </table>
  </div>

  <div class="instruction-box">
    <div class="instruction-title">&#128203; Petunjuk Penggunaan E-Voucher</div>
    <ul class="instruction-list">
      <li>&bull; Tunjukkan e-voucher ini kepada petugas/driver saat penjemputan.</li>
      <li>&bull; Simpan kode booking Anda: {{ strtoupper($booking->booking_code) }}</li>
      <li>&bull; Voucher ini berlaku sebagai bukti pembayaran lunas.</li>
      <li>&bull; Jika ada kendala, hubungi kami via WhatsApp: {{ config('company.phone', '+6281234567890') }}</li>
    </ul>
  </div>

  <div class="footer">
    <div>{{ config('company.name', 'Manik Jaya Trans') }} | {{ config('company.address', 'Jl. Contoh Alamat No. 123, Bali') }}</div>
    <div>Dokumen ini diterbitkan secara digital dan sah sebagai bukti pembayaran.</div>
    <div>Terima kasih telah menggunakan layanan kami.</div>
  </div>

</body>
</html>
