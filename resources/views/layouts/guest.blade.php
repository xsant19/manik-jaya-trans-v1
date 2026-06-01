<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Manik Jaya Trans') }} - Authentication</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-faint-gray text-carbon-black font-sans antialiased">
    <div class="min-h-screen flex flex-col items-center justify-center p-4">
        <a href="{{ route('home') }}" class="mb-8 block">
            <span class="font-bold text-2xl text-carbon-black tracking-tight">MANIK JAYA.</span>
        </a>

        <div class="w-full max-w-md bg-canvas-white rounded-card border border-soft-divider p-8">
            @yield('content')
        </div>
        
        <div class="mt-8 text-sm text-storm-gray">
            &copy; {{ date('Y') }} Sistem Informasi Travel Manik Jaya Trans
        </div>
    </div>
</body>
</html>
