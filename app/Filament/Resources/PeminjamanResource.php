<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeminjamanResource\Pages;
use App\Models\Peminjaman;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PeminjamanResource extends Resource
{
    protected static ?string $model = Peminjaman::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Peminjaman';

    protected static ?string $navigationGroup = 'Data';

    protected static ?string $pluralLabel = 'Peminjaman';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll('1s')
            ->heading('Riwayat Peminjaman')
            ->query(function () {
                return Peminjaman::query()
                    ->whereIn('status_peminjaman', ['dikembalikan', 'dibatalkan']);
            })
            ->columns([
                ImageColumn::make('buku.cover')
                    ->disk('local')
                    ->visibility('private'),
                TextColumn::make('buku.judul')
                    ->searchable()
                    ->sortable()
                    ->label('Judul'),
                TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->label('Dipinjam oleh:'),
                TextColumn::make('tanggal_peminjaman')
                    ->date(),
                TextColumn::make('status_peminjaman')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'dikembalikan' => 'success',
                        'dibatalkan' => 'danger'
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPeminjamen::route('/'),
        ];
    }
}
