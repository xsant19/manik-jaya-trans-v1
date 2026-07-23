<?php

namespace App\Filament\Resources;

use App\Filament\Resources\Coupons\Pages\CreateCoupon;
use App\Filament\Resources\Coupons\Pages\EditCoupon;
use App\Filament\Resources\Coupons\Pages\ListCoupons;
use App\Models\Coupon;
use App\Services\CouponService;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class CouponResource extends Resource
{
    protected static ?string $model = Coupon::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Promosi';

    protected static ?string $navigationLabel = 'Kupon Diskon';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-ticket';

    protected static ?string $modelLabel = 'Kupon Diskon';

    protected static ?string $pluralModelLabel = 'Kupon Diskon';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Kupon')
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('code')
                            ->label('Kode Kupon')
                            ->required()
                            ->maxLength(50)
                            ->placeholder('Contoh: HEMAT50')
                            ->helperText('Kode kupon bersifat case-insensitive. Akan disimpan dalam format UPPERCASE.')
                            ->dehydrateStateUsing(fn ($state) => strtoupper(trim($state)))
                            ->suffixAction(
                                \Filament\Actions\Action::make('generate_code')
                                    ->label('Generate Otomatis')
                                    ->icon('heroicon-o-arrow-path')
                                    ->action(function ($set) {
                                        $couponService = app(CouponService::class);
                                        $set('code', $couponService->generateCode());
                                    })
                            ),

                        TextInput::make('name')
                            ->label('Nama / Deskripsi Kupon')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Diskon Hari Kemerdekaan 50%'),

                        Select::make('type')
                            ->label('Tipe Diskon')
                            ->required()
                            ->options([
                                'percentage' => 'Persentase (%)',
                                'fixed'      => 'Nominal Tetap (Rp)',
                            ])
                            ->live()
                            ->helperText('Persentase: potongan dihitung dari total harga. Nominal Tetap: potongan langsung dikurangi dari total harga.'),

                        TextInput::make('value')
                            ->label(fn (Get $get) => $get('type') === 'percentage' ? 'Nilai Diskon (%)' : 'Nilai Diskon (Rp)')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(fn (Get $get) => $get('type') === 'percentage' ? 100 : null)
                            ->placeholder(fn (Get $get) => $get('type') === 'percentage' ? 'Contoh: 20 (artinya 20%)' : 'Contoh: 50000')
                            ->helperText(fn (Get $get) => $get('type') === 'percentage'
                                ? 'Masukkan angka antara 0–100 (tanpa simbol %).'
                                : 'Masukkan nominal dalam Rupiah (tanpa titik/koma).'),

                        TextInput::make('max_discount_amount')
                            ->label('Batas Maksimal Potongan (Rp)')
                            ->numeric()
                            ->minValue(0)
                            ->nullable()
                            ->placeholder('Contoh: 100000')
                            ->helperText('Opsional. Hanya berlaku untuk tipe Persentase. Kosongkan jika tidak ada batas.')
                            ->visible(fn (Get $get) => $get('type') === 'percentage'),

                        TextInput::make('min_booking_amount')
                            ->label('Minimum Harga Pesanan (Rp)')
                            ->numeric()
                            ->minValue(0)
                            ->nullable()
                            ->placeholder('Contoh: 200000')
                            ->helperText('Opsional. Kupon hanya bisa dipakai jika total pesanan mencapai nilai ini. Kosongkan jika tidak ada minimum.'),

                        TextInput::make('usage_limit')
                            ->label('Batas Total Penggunaan')
                            ->numeric()
                            ->minValue(1)
                            ->nullable()
                            ->placeholder('Contoh: 100')
                            ->helperText('Opsional. Jumlah maksimal kupon ini boleh digunakan. Kosongkan jika tidak terbatas (unlimited).'),

                        DateTimePicker::make('started_at')
                            ->label('Tanggal Mulai Berlaku')
                            ->nullable()
                            ->helperText('Opsional. Kupon hanya bisa dipakai sejak tanggal ini. Kosongkan jika langsung berlaku.'),

                        DateTimePicker::make('expired_at')
                            ->label('Tanggal Kedaluwarsa')
                            ->nullable()
                            ->after('started_at')
                            ->helperText('Opsional. Kupon tidak bisa dipakai setelah tanggal ini. Kosongkan jika tidak ada kedaluwarsa.'),

                        Toggle::make('is_active')
                            ->label('Kupon Aktif')
                            ->default(true)
                            ->helperText('Nonaktifkan untuk menonaktifkan kupon tanpa menghapusnya.'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Kode Kupon')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('bold')
                    ->fontFamily('mono'),

                TextColumn::make('name')
                    ->label('Nama Kupon')
                    ->searchable()
                    ->limit(30),

                TextColumn::make('type')
                    ->label('Tipe')
                    ->formatStateUsing(fn ($state) => $state === 'percentage' ? 'Persentase' : 'Nominal')
                    ->badge()
                    ->color(fn ($state) => $state === 'percentage' ? 'info' : 'success'),

                TextColumn::make('value')
                    ->label('Nilai')
                    ->formatStateUsing(function ($state, $record) {
                        if ($record->type === 'percentage') {
                            return number_format($state, 0) . '%';
                        }

                        return 'Rp ' . number_format($state, 0, ',', '.');
                    }),

                TextColumn::make('usage_count')
                    ->label('Penggunaan')
                    ->formatStateUsing(function ($state, $record) {
                        if ($record->usage_limit === null) {
                            return $state . ' / ∞';
                        }

                        return $state . ' / ' . $record->usage_limit;
                    }),

                TextColumn::make('expired_at')
                    ->label('Kedaluwarsa')
                    ->dateTime('d M Y, H:i')
                    ->placeholder('Tidak ada')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),

                TextColumn::make('status_label')
                    ->label('Status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'Aktif'          => 'success',
                        'Nonaktif'       => 'danger',
                        'Kedaluwarsa'    => 'warning',
                        'Belum Berlaku'  => 'gray',
                        'Habis'          => 'danger',
                        default          => 'gray',
                    }),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Status Aktif'),

                SelectFilter::make('type')
                    ->label('Tipe Diskon')
                    ->options([
                        'percentage' => 'Persentase (%)',
                        'fixed'      => 'Nominal Tetap (Rp)',
                    ]),
            ])
            ->recordActions([
                EditAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Edit Kupon Diskon')
                    ->modalDescription('Pastikan perubahan kupon sudah benar sebelum disimpan.')
                    ->modalSubmitActionLabel('Simpan Perubahan'),

                DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Hapus Kupon Diskon')
                    ->modalDescription('Kupon yang sudah digunakan dalam booking tidak akan terpengaruh. Data booking akan tetap menyimpan kode kupon yang digunakan.')
                    ->modalSubmitActionLabel('Ya, Hapus'),
            ])
            ->toolbarActions([])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListCoupons::route('/'),
            'create' => CreateCoupon::route('/create'),
            'edit'   => EditCoupon::route('/{record}/edit'),
        ];
    }
}
