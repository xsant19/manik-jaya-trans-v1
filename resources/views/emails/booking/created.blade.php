<x-mail::message>
# Halo {{ $booking->user->name }},

Terima kasih telah melakukan pemesanan di **{{ config('app.name') }}**.
Berikut adalah rincian pesanan Anda:

- **Kode Booking**: {{ $booking->booking_code }}
- **Tanggal Pesan**: {{ \Carbon\Carbon::parse($booking->created_at)->translatedFormat('d F Y') }}
- **Total Tagihan**: Rp {{ number_format($booking->total_price, 0, ',', '.') }}

<x-mail::button :url="url('/customer/my-bookings')">
Lihat Detail Pesanan
</x-mail::button>

Silakan segera lakukan pembayaran agar pesanan Anda dapat diproses.

Terima kasih,<br>
Tim {{ config('app.name') }}
</x-mail::message>
