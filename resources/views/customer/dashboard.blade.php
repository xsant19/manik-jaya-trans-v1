@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-4 mt-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-carbon-black">Dashboard Customer</h1>
        <p class="text-storm-gray mt-2">Selamat datang, {{ auth()->user()->name }}!</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="p-6 border border-soft-divider rounded-card bg-faint-gray">
            <h3 class="font-medium text-storm-gray">Total Booking</h3>
            <p class="text-3xl font-bold mt-2">0</p>
        </div>
        <div class="p-6 border border-soft-divider rounded-card bg-faint-gray">
            <h3 class="font-medium text-storm-gray">Booking Pending</h3>
            <p class="text-3xl font-bold mt-2">0</p>
        </div>
        <div class="p-6 border border-soft-divider rounded-card bg-faint-gray">
            <h3 class="font-medium text-storm-gray">Pembayaran Lunas</h3>
            <p class="text-3xl font-bold mt-2">0</p>
        </div>
    </div>
</div>
@endsection
