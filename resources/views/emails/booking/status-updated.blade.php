<x-mail::message>
# Halo {{ $booking->user->name }},

Status pesanan Anda dengan kode **{{ $booking->booking_code }}** telah diperbarui.

- **Status Terbaru**: {{ strtoupper(str_replace('_', ' ', $booking->booking_status)) }}

<x-mail::button :url="route('customer.bookings.index')">
Cek Status Pemesanan
</x-mail::button>

Jika Anda memiliki pertanyaan terkait perubahan status ini, silakan hubungi tim layanan pelanggan kami.

Terima kasih,<br>
Tim {{ config('app.name') }}
</x-mail::message>
