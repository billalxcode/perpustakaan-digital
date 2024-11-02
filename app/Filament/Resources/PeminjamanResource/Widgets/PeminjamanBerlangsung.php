<?php

namespace App\Filament\Resources\PeminjamanResource\Widgets;

use App\Models\Peminjaman;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class PeminjamanBerlangsung extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->poll('1s')
            ->query(function () {
                return Peminjaman::query()
                    ->where('status_peminjaman', '=', 'berlangsung');
            })
            ->columns([
                ImageColumn::make('buku.cover')
                    ->disk('local')
                    ->visibility('private')
                    ->label('Judul'),
                TextColumn::make('buku.judul')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Oleh')
                    ->sortable()
                    ->searchable()
            ])
            ->filters([
                //
            ])
            ->actions([
                \Filament\Tables\Actions\Action::make('kembalikan')
                    ->label('Kembalikan')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->modalHeading('Kembalikan Buku')
                    ->modalDescription(
                        'Saya mengembalikan buku ini dengan keadaan utuh, tidak rusak.'
                    )
                    ->action(function ($record) {
                        $peminjaman = Peminjaman::find($record->id);
                        $peminjaman->status_peminjaman = 'dikembalikan';
                        $peminjaman->save();

                        Notification::make()
                            ->success()
                            ->body('Buku berhasil dikembalikan, silahkan simpan buku ke tempat nya')
                            ->send();
                    }),
            ])
            ->emptyStateHeading('Data kosong');
    }
}
