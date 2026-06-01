<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    /**
     * Tentukan apakah user bisa melakukan request ini.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi yang berlaku pada request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // TODO: Tambahkan aturan validasi pembayaran
            // 'booking_code'    => ['required', 'exists:bookings,code'],
            // 'payment_method'  => ['required', 'in:transfer,cash,ewallet'],
            // 'amount'          => ['required', 'numeric', 'min:1'],
        ];
    }

    /**
     * Pesan error kustom untuk validasi.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            // TODO: Tambahkan pesan error kustom
        ];
    }
}
