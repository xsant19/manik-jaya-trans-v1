@props(['type' => 'button'])

<button type="{{ $type }}" {{ $attributes->merge(['class' => 'inline-flex items-center justify-center px-4 py-2 bg-transparent text-carbon-black font-medium rounded-btn hover:bg-pale-drift focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-carbon-black transition-colors']) }}>
    {{ $slot }}
</button>
