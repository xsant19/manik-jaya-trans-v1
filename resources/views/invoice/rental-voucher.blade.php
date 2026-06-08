<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <style>
    /* font-family: 'DejaVu Sans', sans-serif */
    /* warna utama: #1a1a2e | hijau: #10b981 | kuning: #f59e0b */
    /* body margin: 40px */
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
    .voucher-title {
        font-size: 24px;
        font-weight: bold;
        color: #1a1a2e;
        margin-bottom: 5px;
    }
    .driver-box {
        background-color: #f0fdf4;
        border: 2px solid #10b981;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 24px;
    }
    .driver-title {
        font-size: 16px;
        font-weight: bold;
        color: #10b981;
        margin-bottom: 16px;
    }
    .driver-table {
        width: 100%;
    }
    .driver-table td {
        padding: 4px;
        vertical-align: top;
    }
    .driver-table td:first-child {
        width: 120px;
    }
    .driver-name {
        font-weight: bold;
        font-size: 15px;
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
    .instruction-box {
        background-color: #fffbeb;
        border: 1px solid #fde68a;
        border-radius: 6px;
        padding: 14px;
        margin-top: 24px;
    }
    .instruction-title {
        font-weight: bold;
        margin-bottom: 10px;
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
        <div class="voucher-title">VOUCHER PERJALANAN</div>
        <div>Kode: {{ strtoupper($rental->booking_code) }}</div>
        <div>Tanggal Cetak: {{ now()->translatedFormat('d F Y') }}</div>
      </td>
    </tr>
  </table>

  <div class="driver-box">
    <div class="driver-title">Informasi Driver Anda</div>
    <table class="driver-table">
      <tr>
        <td>Nama Driver</td>
        <td>: <span class="driver-name">{{ optional($rental->driver)->name ?? 'Menunggu Konfirmasi' }}</span></td>
      </tr>
      <tr>
        <td>No. Telepon</td>
        <td>: {{ optional($rental->driver)->phone ?? '-' }}</td>
      </tr>
      <tr>
        <td>Kendaraan</td>
        <td>: {{ optional($rental->vehicle)->name }} ({{ optional($rental->vehicle)->type }})</td>
      </tr>
      <tr>
        <td>Plat Nomor</td>
        <td>: {{ optional($rental->vehicle)->license_plate ?? 'Lihat konfirmasi WhatsApp' }}</td>
      </tr>
    </table>
  </div>

  <div class="section-title">DETAIL PERJALANAN</div>
  <table class="data-table">
    <tr>
      <td>Tanggal Mulai</td>
      <td>: {{ \Carbon\Carbon::parse($rental->start_date)->translatedFormat('d F Y') }}</td>
    </tr>
    <tr>
      <td>Tanggal Selesai</td>
      <td>: {{ \Carbon\Carbon::parse($rental->end_date)->translatedFormat('d F Y') }}</td>
    </tr>
    <tr>
      <td>Tipe Sewa</td>
      <td>: {{ $rental->rental_type === 'full_day' ? 'Sehari Penuh (Full Day)' : 'Setengah Hari (Half Day)' }}</td>
    </tr>
    <tr>
      <td>Lokasi Jemput</td>
      <td>: {{ $rental->pickup_location }}</td>
    </tr>
    @if($rental->note)
    <tr>
      <td>Catatan Khusus</td>
      <td>: {{ $rental->note }}</td>
    </tr>
    @endif
  </table>

  <div class="section-title">DATA PELANGGAN</div>
  <table class="data-table">
    <tr>
      <td>Nama</td>
      <td>: {{ optional($rental->user)->name }}</td>
    </tr>
    <tr>
      <td>Email</td>
      <td>: {{ optional($rental->user)->email }}</td>
    </tr>
    <tr>
      <td>Kode Booking</td>
      <td>: {{ strtoupper($rental->booking_code) }}</td>
    </tr>
  </table>

  <div class="instruction-box">
    <div class="instruction-title">&#128203; Petunjuk Penggunaan Voucher</div>
    <ul class="instruction-list">
      <li>&bull; Tunjukkan voucher ini kepada driver saat penjemputan.</li>
      <li>&bull; Simpan kode booking Anda: {{ strtoupper($rental->booking_code) }}</li>
      <li>&bull; Jika ada kendala, hubungi kami: {{ config('company.phone', '+6281234567890') }}</li>
    </ul>
  </div>

  <div class="footer">
    <div>{{ config('company.name', 'Manik Jaya Trans') }} | {{ config('company.address', 'Jl. Contoh Alamat No. 123, Bali') }}</div>
    <div>Dokumen ini diterbitkan secara digital dan sah tanpa tanda tangan basah.</div>
  </div>

</body>
</html>
