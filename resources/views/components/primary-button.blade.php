@props(['type' => 'button'])

<button type="{{ $type }}" {{ $attributes->merge(['class' => 'inline-flex items-center justify-center px-8 py-4 bg-carbon-black text-canvas-white text-base font-medium rounded-btn hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-carbon-black transition-colors disabled:opacity-50 disabled:cursor-not-allowed']) }}>
    {{ $slot }}
</button>
