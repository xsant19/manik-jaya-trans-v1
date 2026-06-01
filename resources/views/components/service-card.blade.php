<div {{ $attributes->merge(['class' => 'bg-canvas-white rounded-card border border-soft-divider overflow-hidden flex flex-col transition-transform hover:-translate-y-1 hover:shadow-sm']) }}>
    @if(isset($image))
        <div class="h-48 w-full bg-pale-drift overflow-hidden">
            {{ $image }}
        </div>
    @endif
    <div class="p-6 flex-grow flex flex-col">
        {{ $slot }}
    </div>
</div>
