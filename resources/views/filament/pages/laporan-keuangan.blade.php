<x-filament-panels::page>

    {{-- 1. Render Form Filter yang sudah kita buat di PHP (Otomatis Rapi & Sejajar) --}}
    {{ $this->form }}

    {{-- 2. Stats Widget --}}
    @livewire(\App\Filament\Widgets\LaporanKeuanganStatsWidget::class, [
        'from' => $this->data['from'] ?? null,
        'to'   => $this->data['to'] ?? null,
    ])

    {{-- 3. Panduan Penggunaan --}}
    {{ $this->getSchema('panduan') }}

</x-filament-panels::page>