<x-mail::message>
# 🔔 Pesanan Baru Masuk!

**Tipe Layanan:** {{ ucfirst(str_replace('_', ' ', $bookingType)) }}

---

## Detail Pesanan

<x-mail::panel>
**Kode Booking:** {{ $booking->booking_code }}
**Tanggal Pesan:** {{ \Carbon\Carbon::parse($booking->created_at)->translatedFormat('d F Y H:i') }}
**Status Pembayaran:** {{ strtoupper($booking->payment_status ?? 'Unpaid') }}
**Total Tagihan:** Rp {{ number_format($booking->total_price, 0, ',', '.') }}
</x-mail::panel>

## Data Customer

- **Nama:** {{ $booking->user->name }}
- **Email:** {{ $booking->user->email }}
- **Telepon:** {{ $booking->user->phone ?? '-' }}

---

## Detail Layanan

@if($bookingType === 'rental')
- **Kendaraan:** {{ $booking->vehicle->name ?? '-' }}
- **Tipe Rental:** {{ $booking->rental_type === 'full_day' ? 'Full Day (24 Jam)' : 'Half Day (12 Jam)' }}
- **Tanggal Mulai:** {{ \Carbon\Carbon::parse($booking->start_date)->translatedFormat('d F Y') }}
- **Tanggal Selesai:** {{ \Carbon\Carbon::parse($booking->end_date)->translatedFormat('d F Y') }}
- **Lokasi Jemput:** {{ $booking->pickup_location }}
- **Catatan:** {{ $booking->note ?? '-' }}

@elseif($bookingType === 'tour')
- **Paket Wisata:** {{ $booking->tourPackage->name ?? '-' }}
- **Tanggal Tour:** {{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d F Y') }}
- **Jumlah Peserta:** {{ $booking->participant_count }} orang
- **Catatan:** {{ $booking->note ?? '-' }}

@elseif($bookingType === 'transfer')
- **Rute:** {{ $booking->airportTransfer->route_name ?? '-' }}
- **Dari:** {{ $booking->airportTransfer->pickup_location ?? '-' }}
- **Ke:** {{ $booking->airportTransfer->dropoff_location ?? '-' }}
- **Tanggal:** {{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d F Y') }}
- **Waktu Jemput:** {{ \Carbon\Carbon::parse($booking->pickup_time)->translatedFormat('H:i') }}
- **No. Penerbangan:** {{ $booking->flight_number ?? '-' }}
- **Jumlah Penumpang:** {{ $booking->passenger_count }} orang
- **Catatan:** {{ $booking->note ?? '-' }}

@elseif($bookingType === 'shuttle')
- **Hotel:** {{ $booking->hotelShuttle->hotel_name ?? '-' }}
- **Dari:** {{ $booking->hotelShuttle->pickup_location ?? '-' }}
- **Ke:** {{ $booking->hotelShuttle->dropoff_location ?? '-' }}
- **Tanggal:** {{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d F Y') }}
- **Waktu Jemput:** {{ \Carbon\Carbon::parse($booking->pickup_time)->translatedFormat('H:i') }}
- **Jumlah Penumpang:** {{ $booking->passenger_count }} orang
- **Catatan:** {{ $booking->note ?? '-' }}
@endif

---

<x-mail::button :url="url('/admin/{{ $bookingType }}-bookings/' . $booking->id)">
Kelola Pesanan di Admin Panel
</x-mail::button>

**Segera proses pesanan ini!**

Salam,
Sistem {{ config('app.name') }}
</x-mail::message>
