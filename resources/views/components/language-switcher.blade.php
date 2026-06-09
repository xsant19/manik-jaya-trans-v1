{{-- Language Switch Toggle Component --}}
{{-- Toggle switch with flag icon in the thumb circle --}}
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
        {{-- Sliding thumb with flag image --}}
        <span class="lang-switch-thumb" data-lang-thumb>
            <img
                src="https://res.cloudinary.com/dafmuqvhh/image/upload/q_auto/f_auto/v1781011882/flag-id-2_k3otwi.png"
                alt="ID"
                class="lang-switch-flag"
                data-lang-thumb-flag
                data-flag-id="https://res.cloudinary.com/dafmuqvhh/image/upload/q_auto/f_auto/v1781011882/flag-id-2_k3otwi.png"
                data-flag-en="https://res.cloudinary.com/dafmuqvhh/image/upload/q_auto/f_auto/v1781011880/flag-uk_zrizp4.png"
            >
        </span>
    </button>
</div>
