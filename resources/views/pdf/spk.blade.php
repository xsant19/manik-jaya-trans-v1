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
        font-size: 20px;
        font-weight: bold;
    }
    .spk-title {
        font-size: 24px;
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
    .status-badge {
        display: inline-block;
        padding: 2px 10px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: bold;
        color: #ffffff;
    }
    .status-approved  { background-color: #10b981; }
    .status-on_trip   { background-color: #f59e0b; }
    .status-completed { background-color: #6366f1; }
    .instruction-box {
        background-color: #f0f9ff;
        border: 1px solid #bae6fd;
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
    .signature-table {
        width: 100%;
        margin-top: 60px;
        text-align: center;
    }
    .signature-table td {
        width: 33.33%;
        padding: 10px;
        vertical-align: top;
    }
    .signature-line {
        border-top: 1px solid #1a1a2e;
        margin-top: 60px;
        padding-top: 5px;
    }
    .footer {
        border-top: 1px solid #dddddd;
        padding-top: 10px;
        text-align: center;
        font-size: 10px;
        color: #999;
        margin-top: 40px;
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
        <div class="spk-title">Surat Perintah Kerja</div>
        <div>No: {{ $spkNumber }}</div>
        <div>Tanggal Cetak: {{ now()->translatedFormat('d F Y') }}</div>
        <div>
          Status:
          <span class="status-badge status-{{ $booking->booking_status }}">
            {{ strtoupper($booking->booking_status) }}
          </span>
        </div>
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

  <div class="section-title">INFORMASI PEMBAYARAN</div>
  <table class="data-table">
    <tr>
      <td>Total Biaya</td>
      <td>: Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
    </tr>
    <tr>
      <td>Status Pembayaran</td>
      <td>: {{ strtoupper($booking->payment_status) }}</td>
    </tr>
  </table>

  <div class="instruction-box">
    <div class="instruction-title">Catatan Operasional:</div>
    <ul class="instruction-list">
      <li>&bull; Dokumen ini merupakan perintah kerja resmi dari {{ config('company.name', 'Manik Jaya Trans') }}.</li>
      <li>&bull; Driver wajib membawa salinan SPK ini selama perjalanan.</li>
      <li>&bull; Segala perubahan jadwal harus dikonfirmasi ke admin terlebih dahulu.</li>
      @if($booking->note)
        <li>&bull; Catatan khusus pelanggan: {{ $booking->note }}</li>
      @endif
    </ul>
  </div>

  <table class="signature-table">
    <tr>
      <td>
        <div>Admin</div>
        <div class="signature-line">( ........................ )</div>
      </td>
      <td>
        <div>Driver</div>
        <div class="signature-line">( ........................ )</div>
      </td>
      <td>
        <div>Pelanggan</div>
        <div class="signature-line">( {{ optional($booking->user)->name }} )</div>
      </td>
    </tr>
  </table>

  <div class="footer">
    <div>{{ config('company.name', 'Manik Jaya Trans') }} | {{ config('company.address', 'Jl. Contoh Alamat No. 123, Bali') }}</div>
    <div>Dokumen ini diterbitkan secara digital dan sah sebagai perintah kerja.</div>
  </div>

</body>
</html>
