<?php

namespace App\Filament\General\Resources;

use App\Filament\General\Resources\PeminjamanResource\Pages;
use App\Models\Peminjaman;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class PeminjamanResource extends Resource
{
    protected static ?string $model = Peminjaman::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Peminjaman';

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
        $user = Auth::user();

        return $table
            ->poll('1s')
            ->heading('Riwayat Peminjaman')
            ->query(function () use ($user) {
                return Peminjaman::query()
                    ->whereIn('status_peminjaman', ['dikembalikan', 'dibatalkan'])
                    ->where('user_id', '=', $user->id);
            })
            ->columns([
                ImageColumn::make('buku.cover')
                    ->disk('local')
                    ->visibility('private'),
                TextColumn::make('buku.judul')
                    ->searchable()
                    ->sortable()
                    ->label('Judul'),
                TextColumn::make('buku.penulis')
                    ->searchable()
                    ->sortable()
                    ->label('Penulis'),
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
