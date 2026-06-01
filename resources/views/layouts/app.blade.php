<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Manik Jaya Trans') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-canvas-white text-carbon-black font-sans antialiased">
    <div class="min-h-screen flex flex-col">
        <x-navbar />

        <main class="flex-grow">
            @yield('content')
        </main>

        <x-footer />
    </div>
</body>
</html>
