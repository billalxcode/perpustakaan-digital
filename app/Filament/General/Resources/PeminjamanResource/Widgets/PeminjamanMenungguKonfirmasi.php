<?php

namespace App\Filament\General\Resources\PeminjamanResource\Widgets;

use App\Models\Peminjaman;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class PeminjamanMenungguKonfirmasi extends BaseWidget
{
    public function table(Table $table): Table
    {
        $user = Auth::user();

        return $table
            ->poll('1s')
            ->query(function () use ($user) {
                return Peminjaman::query()
                    ->where('status_peminjaman', '=', 'menunggu')
                    ->where('user_id', '=', $user->id);
            })
            ->columns([
                ImageColumn::make('buku.cover')
                    ->disk('local')
                    ->visibility('private')
                    ->label('Judul'),
                TextColumn::make('buku.judul')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tanggal_peminjaman')
                    ->date(),
            ])
            ->filters([
                //
            ])
            ->actions([
                \Filament\Tables\Actions\Action::make('batalkan')
                    ->label('Batalkan')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->modalHeading('Pembatalan')
                    ->modalDescription('Apakah kamu yakin ingin membatalkan peminjaman buku ini?')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $peminjaman = Peminjaman::find($record->id);
                        $peminjaman->status_peminjaman = 'dibatalkan';
                        $peminjaman->save();

                        Notification::make()
                            ->success()
                            ->body('Peminjaman buku anda dibatalkan')
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Data kosong');
    }
}
