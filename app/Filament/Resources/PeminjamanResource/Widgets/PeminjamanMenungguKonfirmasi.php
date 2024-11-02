<?php

namespace App\Filament\Resources\PeminjamanResource\Widgets;

use App\Models\Peminjaman;
use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class PeminjamanMenungguKonfirmasi extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->poll('1s')
            ->query(function () {
                return Peminjaman::query()
                    ->where('status_peminjaman', '=', 'menunggu');
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
                \Filament\Tables\Actions\ActionGroup::make([

                    \Filament\Tables\Actions\Action::make('setujui')
                        ->label('Setujui')
                        ->icon('heroicon-o-check')
                        ->color('success')
                        ->modalHeading('Persetujuan')
                        ->modalDescription('Apakah anda sebagai admin menyutujui peminjaman buku ini.')
                        ->requiresConfirmation()
                        ->action(function ($record) {
                            // dd($record->user);
                            $recipient = User::find($record->user->id);

                            $peminjaman = Peminjaman::find($record->id);
                            $peminjaman->status_peminjaman = 'berlangsung';
                            $peminjaman->save();

                            Notification::make()
                                ->success()
                                ->body('Peminjaman buku disetujui')
                                ->send();
                            $recipient->notify(
                                Notification::make()
                                    ->title('Peminjaman buku telah disetujui oleh admin')
                                    ->toDatabase()
                            );
                        }),
                    \Filament\Tables\Actions\Action::make('batalkan')
                        ->label('Batalkan')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->modalHeading('Pembatalan')
                        ->modalDescription('Apakah kamu yakin ingin membatalkan peminjaman buku ini?')
                        ->requiresConfirmation()
                        ->action(function ($record) {
                            $recipient = User::find($record->user->id);
                            $peminjaman = Peminjaman::find($record->id);
                            $peminjaman->status_peminjaman = 'dibatalkan';
                            $peminjaman->save();

                            Notification::make()
                                ->success()
                                ->body('Peminjaman buku dibatalkan')
                                ->send();

                            $recipient->notify(
                                Notification::make()
                                    ->danger()
                                    ->title('Peminjaman buku telah dibatalkan oleh admin')
                                    ->toDatabase()
                            );
                        }),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Data kosong');
    }
}
