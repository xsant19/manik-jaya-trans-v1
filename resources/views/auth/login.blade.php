@extends('layouts.guest')

@section('content')
    <h2 class="text-2xl font-bold mb-6 text-center text-carbon-black">Masuk ke Akun</h2>

    <form method="POST" action="{{ route('login.post') }}">
        @csrf
        
        <!-- Email Field -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-carbon-black mb-2">Email</label>
            <input 
                type="email" 
                id="email"
                name="email" 
                value="{{ old('email') }}" 
                required 
                autofocus
                class="w-full px-4 py-3 border border-soft-divider rounded-btn focus:outline-none focus:ring-2 focus:ring-carbon-black"
                placeholder="nama@email.com"
            >
            <x-form-error :messages="$errors->get('email')" />
        </div>

        <!-- Password Field with Toggle -->
        <div class="mb-6">
            <label for="password" class="block text-sm font-medium text-carbon-black mb-2">Password</label>
            <div class="relative">
                <input 
                    type="password" 
                    id="password"
                    name="password" 
                    required 
                    class="w-full px-4 py-3 pr-12 border border-soft-divider rounded-btn focus:outline-none focus:ring-2 focus:ring-carbon-black"
                    placeholder="Masukkan password"
                >
                <button 
                    type="button"
                    onclick="togglePassword('password', 'toggleIcon')"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-storm-gray hover:text-carbon-black focus:outline-none"
                >
                    <svg id="toggleIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </button>
            </div>
            <x-form-error :messages="$errors->get('password')" />
        </div>

        <!-- Submit Button -->
        <x-primary-button type="submit" class="w-full">
            Masuk
        </x-primary-button>
    </form>

    <div class="mt-6 text-center text-sm text-storm-gray">
        Belum punya akun? <a href="{{ route('register') }}" class="text-carbon-black font-medium hover:underline">Daftar sekarang</a>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                `;
            } else {
                input.type = 'password';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                `;
            }
        }
    </script>
@endsection
