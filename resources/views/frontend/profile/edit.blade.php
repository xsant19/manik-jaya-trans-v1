@extends('layouts.app')

@section('content')
<div class="py-12 bg-faint-gray border-b border-soft-divider">
    <x-page-container>
        <h1 class="text-4xl font-bold text-carbon-black mb-4">Edit Profil</h1>
        <p class="text-storm-gray text-lg">Kelola informasi profil dan keamanan akun Anda</p>
    </x-page-container>
</div>

<div class="py-16">
    <x-page-container>
        <div class="mx-auto max-w-3xl space-y-8">
            
            {{-- Success Message --}}
            @if(session('success'))
                <div class="rounded-card border-l-4 border-carbon-black bg-canvas-white p-5">
                    <div class="flex items-start gap-3">
                        <svg class="mt-0.5 size-5 shrink-0 text-carbon-black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 13l4 4L19 7"/>
                        </svg>
                        <div class="text-sm leading-relaxed text-carbon-black font-medium">
                            {{ session('success') }}
                        </div>
                    </div>
                </div>
            @endif

            {{-- Profile Information Form --}}
            <div class="rounded-card border border-soft-divider bg-canvas-white">
                <div class="border-b border-soft-divider px-6 py-5">
                    <h2 class="text-xl font-bold text-carbon-black">Informasi Profil</h2>
                    <p class="mt-1 text-sm text-storm-gray">Perbarui informasi profil akun Anda</p>
                </div>
                
                <div class="p-6">
                    <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        {{-- Name --}}
                        <div>
                            <label for="name" class="block text-sm font-semibold text-carbon-black mb-2">
                                Nama Lengkap
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name', $user->name) }}"
                                   class="w-full rounded-btn border border-soft-divider bg-canvas-white px-4 py-3 text-sm text-carbon-black focus:border-carbon-black focus:outline-none focus:ring-1 focus:ring-carbon-black @error('name') border-red-500 @enderror"
                                   required>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label for="email" class="block text-sm font-semibold text-carbon-black mb-2">
                                Email
                            </label>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   value="{{ old('email', $user->email) }}"
                                   class="w-full rounded-btn border border-soft-divider bg-canvas-white px-4 py-3 text-sm text-carbon-black focus:border-carbon-black focus:outline-none focus:ring-1 focus:ring-carbon-black @error('email') border-red-500 @enderror"
                                   required>
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Submit Button --}}
                        <div class="flex items-center justify-end gap-4 pt-4">
                            <a href="{{ route('customer.dashboard') }}" 
                               class="rounded-btn border border-soft-divider bg-canvas-white px-6 py-3 text-sm font-semibold text-carbon-black transition-opacity hover:opacity-80">
                                Batal
                            </a>
                            <button type="submit" 
                                    class="rounded-btn bg-carbon-black px-6 py-3 text-sm font-semibold text-canvas-white transition-opacity hover:opacity-90">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Password Update Form --}}
            <div class="rounded-card border border-soft-divider bg-canvas-white">
                <div class="border-b border-soft-divider px-6 py-5">
                    <h2 class="text-xl font-bold text-carbon-black">Ganti Password</h2>
                    <p class="mt-1 text-sm text-storm-gray">Perbarui password untuk keamanan akun Anda</p>
                </div>
                
                <div class="p-6">
                    <form method="POST" action="{{ route('profile.password.update') }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        {{-- Current Password --}}
                        <div>
                            <label for="current_password" class="block text-sm font-semibold text-carbon-black mb-2">
                                Password Saat Ini
                            </label>
                            <input type="password" 
                                   name="current_password" 
                                   id="current_password"
                                   class="w-full rounded-btn border border-soft-divider bg-canvas-white px-4 py-3 text-sm text-carbon-black focus:border-carbon-black focus:outline-none focus:ring-1 focus:ring-carbon-black @error('current_password') border-red-500 @enderror"
                                   required>
                            @error('current_password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- New Password --}}
                        <div>
                            <label for="password" class="block text-sm font-semibold text-carbon-black mb-2">
                                Password Baru
                            </label>
                            <input type="password" 
                                   name="password" 
                                   id="password"
                                   class="w-full rounded-btn border border-soft-divider bg-canvas-white px-4 py-3 text-sm text-carbon-black focus:border-carbon-black focus:outline-none focus:ring-1 focus:ring-carbon-black @error('password') border-red-500 @enderror"
                                   required>
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-xs text-storm-gray">Minimal 8 karakter</p>
                        </div>

                        {{-- Confirm Password --}}
                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-carbon-black mb-2">
                                Konfirmasi Password Baru
                            </label>
                            <input type="password" 
                                   name="password_confirmation" 
                                   id="password_confirmation"
                                   class="w-full rounded-btn border border-soft-divider bg-canvas-white px-4 py-3 text-sm text-carbon-black focus:border-carbon-black focus:outline-none focus:ring-1 focus:ring-carbon-black"
                                   required>
                        </div>

                        {{-- Submit Button --}}
                        <div class="flex items-center justify-end gap-4 pt-4">
                            <button type="reset" 
                                    class="rounded-btn border border-soft-divider bg-canvas-white px-6 py-3 text-sm font-semibold text-carbon-black transition-opacity hover:opacity-80">
                                Reset
                            </button>
                            <button type="submit" 
                                    class="rounded-btn bg-carbon-black px-6 py-3 text-sm font-semibold text-canvas-white transition-opacity hover:opacity-90">
                                Ganti Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Account Info --}}
            <div class="rounded-card border border-soft-divider bg-faint-gray p-6">
                <div class="flex items-start gap-3">
                    <svg class="mt-0.5 size-5 shrink-0 text-storm-gray" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 16v-4"/>
                        <path d="M12 8h.01"/>
                    </svg>
                    <div class="text-sm leading-relaxed text-storm-gray">
                        <strong class="text-carbon-black">Informasi Keamanan:</strong> Pastikan menggunakan password yang kuat dengan kombinasi huruf besar, huruf kecil, angka, dan simbol. Jangan bagikan password Anda kepada siapapun.
                    </div>
                </div>
            </div>

        </div>
    </x-page-container>
</div>
@endsection
