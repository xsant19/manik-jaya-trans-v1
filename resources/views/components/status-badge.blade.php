@props(['status'])

@php
    $colorClass = match($status) {
        'pending', 'unpaid' => 'bg-yellow-100 text-yellow-800',
        'approved', 'paid', 'completed', 'active', 'available' => 'bg-green-100 text-green-800',
        'on_trip' => 'bg-gray-100 text-gray-800',
        'canceled', 'failed', 'expired', 'refunded', 'inactive', 'maintenance' => 'bg-red-100 text-red-800',
        default => 'bg-pale-drift text-storm-gray',
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize $colorClass"]) }}>
    {{ str_replace('_', ' ', $status) }}
</span>
