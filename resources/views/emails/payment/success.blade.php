<x-mail::message>
# Halo {{ $booking->user->name }},

Pembayaran Anda untuk pesanan **{{ $booking->booking_code }}** telah **BERHASIL** kami terima.

- **Nominal Pembayaran**: Rp {{ number_format($booking->total_price, 0, ',', '.') }}
- **Status Pembayaran**: Lunas (Paid)

<x-mail::button :url="url('/customer/my-bookings')">
Lihat Pesanan
</x-mail::button>

Tim kami akan segera memproses layanan Anda. Terima kasih telah mempercayakan perjalanan Anda bersama **{{ config('app.name') }}**.

Salam hangat,<br>
Tim {{ config('app.name') }}
</x-mail::message>
