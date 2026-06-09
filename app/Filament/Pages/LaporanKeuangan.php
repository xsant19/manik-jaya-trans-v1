<?php

namespace App\Filament\Pages;

use App\Models\Payment;
use App\Filament\Widgets\LaporanKeuanganStatsWidget;
use BackedEnum;
use Carbon\Carbon;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

// Import yang dibutuhkan untuk Form Schema
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Actions;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\ToggleButtons;
use Filament\Actions\Action;

class LaporanKeuangan extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $title = 'Laporan Keuangan';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentChartBar;
    protected static ?string $navigationLabel = 'Laporan Keuangan';
    protected static string|UnitEnum|null $navigationGroup = 'Keuangan';
    protected static ?int $navigationSort = 2;
    protected string $view = 'filament.pages.laporan-keuangan';

    public function getBreadcrumbs(): array
    {
        return [
            static::getUrl() => 'Laporan Keuangan',
            '' => 'Laporan',
        ];
    }

    // Standar Filament: Gunakan array untuk menyimpan state form
    public ?array $data = []; 

    public function mount(): void
    {
        // Mengisi nilai default form saat halaman dimuat
        $this->form->fill([
            'from' => now()->startOfMonth()->toDateString(),
            'to'   => now()->toDateString(),
            'preset' => 'this_month',
        ]);
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Section::make('Filter Periode Laporan')
                    ->description('Pilih rentang tanggal untuk melihat laporan keuangan.')
                    ->schema([
                        // GRID 2 KOLOM (Ini yang membuat input sejajar seperti Gambar A)
                        Grid::make([
                            'default' => 1, // Layar HP (vertikal)
                            'md' => 2,      // Layar PC/Tablet (sejajar)
                        ])
                        ->schema([
                            DatePicker::make('from')
                                ->label('Dari Tanggal')
                                ->required()
                                ->live() // Otomatis trigger update saat diubah
                                ->afterStateUpdated(fn (callable $set) => $set('preset', null)),

                            DatePicker::make('to')
                                ->label('Sampai Tanggal')
                                ->required()
                                ->live()
                                ->afterStateUpdated(fn (callable $set) => $set('preset', null)),
                        ]),

                        // TOMBOL QUICK PRESETS MENGGUNAKAN TOGGLE BUTTONS
                        ToggleButtons::make('preset')
                            ->hiddenLabel()
                            ->options([
                                'this_month' => 'Bulan Ini',
                                'last_month' => 'Bulan Lalu',
                            ])
                            ->colors([
                                'this_month' => 'gray',
                                'last_month' => 'gray',
                            ])
                            ->grouped()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state === 'this_month') {
                                    $set('from', now()->startOfMonth()->toDateString());
                                    $set('to', now()->toDateString());
                                } elseif ($state === 'last_month') {
                                    $set('from', now()->subMonth()->startOfMonth()->toDateString());
                                    $set('to', now()->subMonth()->endOfMonth()->toDateString());
                                }
                            }),
                    ]),
            ])
            ->statePath('data'); // Hubungkan form ke properti $data
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('export_pdf')
                ->label('Export PDF')
                ->icon(Heroicon::OutlinedDocumentArrowDown)
                ->color('danger')
                ->url(fn () => route('documents.laporan-keuangan', [
                    // Ambil nilai dari properti $data form
                    'from' => $this->data['from'] ?? null, 
                    'to' => $this->data['to'] ?? null
                ]))
                ->openUrlInNewTab(),

            Action::make('export_excel')
                ->label('Export Excel')
                ->icon(Heroicon::OutlinedTableCells)
                ->color('success')
                ->url(fn () => route('documents.laporan-keuangan-excel', [
                    'from' => $this->data['from'] ?? null, 
                    'to' => $this->data['to'] ?? null
                ]))
                ->openUrlInNewTab(),
        ];
    }

    // Fungsi panduanSchema tetap sama seperti sebelumnya
    public function panduanSchema(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return $schema->schema([
            \Filament\Schemas\Components\Section::make('Cara Menggunakan Laporan Keuangan')
                ->description('Ikuti langkah-langkah berikut untuk mengunduh laporan transaksi.')
                ->schema([
                    // ... (Kode HTML Panduan Anda tidak saya ubah sama sekali) ...
                    \Filament\Schemas\Components\Text::make(new \Illuminate\Support\HtmlString('
                        <div class="flex flex-col gap-5">
                            <div>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white mb-1">1. Tentukan Rentang Tanggal</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">Isi kolom <strong class="font-medium text-gray-700 dark:text-gray-300">Dari Tanggal</strong> dan <strong class="font-medium text-gray-700 dark:text-gray-300">Sampai Tanggal</strong> pada filter di atas. Gunakan pintasan <strong class="font-medium text-gray-700 dark:text-gray-300">Bulan Ini</strong> atau <strong class="font-medium text-gray-700 dark:text-gray-300">Bulan Lalu</strong> untuk mempercepat.</p>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white mb-1">2. Tinjau Ringkasan Statistik</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">Kartu statistik di atas otomatis memperbarui <strong class="font-medium text-gray-700 dark:text-gray-300">Total Pendapatan</strong>, <strong class="font-medium text-gray-700 dark:text-gray-300">Total Transaksi</strong>, dan <strong class="font-medium text-gray-700 dark:text-gray-300">Rata-rata Nilai</strong> sesuai periode yang dipilih.</p>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white mb-1">3. Export PDF</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">Klik tombol <strong class="font-medium text-gray-700 dark:text-gray-300">Export PDF</strong> di kanan atas untuk mengunduh laporan dalam format cetak A4 Landscape. Cocok untuk arsip fisik atau dilampirkan ke manajemen.</p>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white mb-1">4. Export Excel</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">Klik tombol <strong class="font-medium text-gray-700 dark:text-gray-300">Export Excel</strong> untuk mengunduh dalam format <code class="text-xs bg-gray-100 dark:bg-gray-800 px-1 rounded">.xlsx</code>. Cocok untuk pembukuan lanjutan, analisis data, atau rekap bulanan.</p>
                            </div>
                        </div>
                    ')),
                    \Filament\Schemas\Components\Callout::make('Catatan Penting')
                        ->color('warning')
                        ->description(new \Illuminate\Support\HtmlString('Laporan ini hanya mencakup transaksi berstatus <strong>Lunas (paid)</strong>. Transaksi berstatus pending, gagal, atau kedaluwarsa tidak diikutsertakan dalam perhitungan laporan.'))
                ])
        ]);
    }
}