<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // TODO: Tambahkan aturan validasi booking
            // 'route_id'       => ['required', 'exists:routes,id'],
            // 'travel_date'    => ['required', 'date', 'after:today'],
            // 'passenger_name' => ['required', 'string', 'max:255'],
            // 'passenger_phone'=> ['required', 'string', 'max:20'],
            // 'seat_count'     => ['required', 'integer', 'min:1', 'max:10'],
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
