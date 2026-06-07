<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Manik Jaya Trans') }} - Authentication</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Google Translate: hide default widget & override injected styles --}}
    <style>
        .goog-te-banner-frame, #goog-gt-tt, .goog-te-balloon-frame,
        .goog-te-gadget, #google_translate_element {
            display: none !important;
        }
        body { top: 0 !important; }
        .goog-text-highlight {
            background: none !important;
            box-shadow: none !important;
        }
        .notranslate { font-family: inherit !important; }
    </style>
</head>
<body class="bg-faint-gray text-carbon-black font-sans antialiased">
    {{-- Hidden Google Translate Element --}}
    <div id="google_translate_element" style="display:none;"></div>

    <div class="min-h-screen flex flex-col items-center justify-center p-4">
        <a href="{{ route('home') }}" class="mb-8 block">
            <span class="font-bold text-2xl text-carbon-black tracking-tight notranslate">MANIK JAYA.</span>
        </a>

        <div class="w-full max-w-md bg-canvas-white rounded-card border border-soft-divider p-8">
            {{-- Language toggle switch for auth pages --}}
            <div class="flex justify-end mb-4">
                <x-language-switcher />
            </div>

            @yield('content')
        </div>
        
        <div class="mt-8 text-sm text-storm-gray">
            &copy; {{ date('Y') }} Sistem Informasi Travel Manik Jaya Trans
        </div>
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

            setTimeout(function() {
                var savedLang = localStorage.getItem('mjt-lang') || 'id';
                if (savedLang !== 'id') {
                    triggerGoogleTranslate(savedLang);
                }
            }, 1500);
        }

        function triggerGoogleTranslate(langCode) {
            var gtCombo = document.querySelector('.goog-te-combo');
            if (gtCombo) {
                gtCombo.value = langCode;
                gtCombo.dispatchEvent(new Event('change'));
            } else {
                setTimeout(function() {
                    var combo = document.querySelector('.goog-te-combo');
                    if (combo) {
                        combo.value = langCode;
                        combo.dispatchEvent(new Event('change'));
                    }
                }, 1000);
            }
        }

        function syncAllSwitches(langCode) {
            var isEn = langCode === 'en';
            document.querySelectorAll('[data-lang-toggle]').forEach(function(toggle) {
                toggle.setAttribute('aria-checked', isEn ? 'true' : 'false');
                var flag = toggle.querySelector('[data-lang-thumb-flag]');
                if (flag) flag.textContent = isEn ? 'EN' : 'ID';
            });
        }

        // Init language toggle on guest page
        document.addEventListener('DOMContentLoaded', function() {
            var savedLang = localStorage.getItem('mjt-lang') || 'id';

            document.querySelectorAll('[data-lang-toggle]').forEach(function(toggle) {
                var isEn = savedLang === 'en';
                toggle.setAttribute('aria-checked', isEn ? 'true' : 'false');

                var flag = toggle.querySelector('[data-lang-thumb-flag]');
                if (flag) flag.textContent = isEn ? 'EN' : 'ID';

                toggle.addEventListener('click', function() {
                    var currentlyEn = this.getAttribute('aria-checked') === 'true';
                    var newLang = currentlyEn ? 'id' : 'en';

                    syncAllSwitches(newLang);
                    localStorage.setItem('mjt-lang', newLang);
                    triggerGoogleTranslate(newLang);
                });
            });
        });
    </script>
    <script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</body>
</html>
