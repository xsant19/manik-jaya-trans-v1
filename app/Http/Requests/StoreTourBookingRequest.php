<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTourBookingRequest extends FormRequest
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
            'booking_date'     => ['required', 'date', 'after_or_equal:today'],
            'participant_count' => ['required', 'integer', 'min:1'],
            'note'             => ['nullable', 'string', 'max:500'],
            'coupon_code'      => ['nullable', 'string', 'max:50'],
        ];
    }
}
