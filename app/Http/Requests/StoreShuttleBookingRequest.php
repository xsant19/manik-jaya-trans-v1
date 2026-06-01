<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreShuttleBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'customer';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
            'passenger_count' => ['required', 'integer', 'min:1'],
            'pickup_time' => ['nullable', 'date_format:H:i'],
            'note' => ['nullable', 'string', 'max:500'],
        ];
    }
}
