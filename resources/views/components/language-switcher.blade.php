{{-- Language Switch Toggle Component --}}
{{-- Toggle switch with language code in the thumb circle --}}
{{-- Left = ID (Indonesia) | Right = EN (English) --}}

<div class="notranslate lang-switch-wrapper" data-lang-switch>
    <button
        type="button"
        class="lang-switch-track"
        data-lang-toggle
        role="switch"
        aria-checked="false"
        aria-label="Ganti Bahasa / Switch Language"
    >
        {{-- Static labels on the track --}}
        <span class="lang-switch-label lang-switch-label--left" aria-hidden="true">ID</span>
        <span class="lang-switch-label lang-switch-label--right" aria-hidden="true">EN</span>

        {{-- Sliding thumb with language code --}}
        <span class="lang-switch-thumb" data-lang-thumb>
            <span class="lang-switch-flag" data-lang-thumb-flag>ID</span>
        </span>
    </button>
</div>
