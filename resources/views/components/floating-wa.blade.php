{{-- Floating WhatsApp Button --}}
<a
    href="{{ config('company.wa_link') }}"
    target="_blank"
    rel="noopener noreferrer"
    class="fixed bottom-6 right-6 z-50 flex items-center justify-center w-14 h-14 bg-[#25D366] text-white rounded-full shadow-lg hover:scale-110 hover:shadow-xl transition-all duration-300 group"
    aria-label="Chat WhatsApp Manik Jaya Trans"
    id="floating-whatsapp-btn"
>
    {{-- Tooltip (muncul saat hover, desktop only) --}}
    <span class="absolute right-full mr-4 bg-carbon-black text-canvas-white text-xs font-medium px-3 py-1.5 rounded-md opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none whitespace-nowrap hidden md:block">
        Chat WhatsApp
    </span>

    {{-- WhatsApp Icon --}}
    <svg
        xmlns="http://www.w3.org/2000/svg"
        width="28"
        height="28"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        stroke-linecap="round"
        stroke-linejoin="round"
        aria-hidden="true"
    >
        <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
    </svg>
</a>
