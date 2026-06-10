<?php

namespace App\Filament\Resources\Vehicles\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InventoriesRelationManager extends RelationManager
{
    protected static string $relationship = 'inventories';

    protected static ?string $title = 'Inventaris / Stok Kendaraan';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('date')
                    ->label('Tanggal')
                    ->required()
                    ->native(false),
                TextInput::make('stock')
                    ->label('Stok')
                    ->required()
                    ->numeric()
                    ->default(1)
                    ->minValue(0),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('date')
            ->columns([
                TextColumn::make('date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('stock')
                    ->label('Stok')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                Action::make('bulkCreate')
                    ->label('Atur Stok Beberapa Hari')
                    ->icon('heroicon-o-calendar-days')
                    ->color('primary')
                    ->form([
                        DatePicker::make('start_date')
                            ->label('Tanggal Mulai')
                            ->required()
                            ->native(false),
                        DatePicker::make('end_date')
                            ->label('Tanggal Akhir')
                            ->required()
                            ->native(false)
                            ->afterOrEqual('start_date'),
                        TextInput::make('stock')
                            ->label('Stok Harian')
                            ->required()
                            ->numeric()
                            ->default(1)
                            ->minValue(0),
                    ])
                    ->action(function (array $data, RelationManager $livewire) {
                        $startDate = \Carbon\Carbon::parse($data['start_date']);
                        $endDate = \Carbon\Carbon::parse($data['end_date']);
                        $stock = $data['stock'];
                        
                        $vehicle = $livewire->getOwnerRecord();
                        
                        $currentDate = $startDate->copy();
                        while ($currentDate->lte($endDate)) {
                            \App\Models\VehicleInventory::updateOrCreate(
                                [
                                    'vehicle_id' => $vehicle->id,
                                    'date' => $currentDate->toDateString(),
                                ],
                                [
                                    'stock' => $stock,
                                ]
                            );
                            $currentDate->addDay();
                        }
                        
                        \Filament\Notifications\Notification::make()
                            ->title('Stok untuk ' . $startDate->diffInDays($endDate) + 1 . ' hari berhasil diperbarui')
                            ->success()
                            ->send();
                    }),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('date', 'desc');
    }
}
