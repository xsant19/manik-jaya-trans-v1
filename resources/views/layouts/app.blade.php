<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Manik Jaya Trans') }}</title>
    <link rel="icon" type="image/x-icon" href="https://res.cloudinary.com/dafmuqvhh/image/upload/v1781007908/favicon_obwlpf.png" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Google Translate: hide default widget & override injected styles --}}
    <style>
        /* Hide the default Google Translate toolbar & widget */
        .goog-te-banner-frame, #goog-gt-tt, .goog-te-balloon-frame,
        .goog-te-gadget, #google_translate_element {
            display: none !important;
        }
        /* Prevent Google Translate from adding top padding */
        body { top: 0 !important; }
        /* Preserve our font styling after translation */
        .goog-text-highlight {
            background: none !important;
            box-shadow: none !important;
        }
        /* Keep the notranslate class elements from being translated */
        .notranslate { font-family: inherit !important; }
    </style>
</head>
<body class="bg-canvas-white text-carbon-black font-sans antialiased">
    {{-- Hidden Google Translate Element (required for API) --}}
    <div id="google_translate_element" style="display:none;"></div>

    <div class="min-h-screen flex flex-col">
        <x-navbar />

        <main class="flex-grow">
            @yield('content')
        </main>

        <x-footer />

        <!-- Floating WhatsApp Button -->
        <x-floating-wa />
    </div>

    {{-- Google Translate Script --}}
    <script>
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'id',
                includedLanguages: 'id,en',
                autoDisplay: false,
                layout: google.translate.TranslateElement.InlineLayout.NONE
            }, 'google_translate_element');

            // After widget initializes, apply saved language preference
            setTimeout(function() {
                var savedLang = localStorage.getItem('mjt-lang') || 'id';
                if (savedLang !== 'id') {
                    triggerGoogleTranslate(savedLang);
                }
            }, 1500);
        }
    </script>
    <script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</body>
</html>
