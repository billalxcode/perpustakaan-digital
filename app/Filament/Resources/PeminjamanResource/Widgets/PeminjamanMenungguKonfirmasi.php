<?php

namespace App\Filament\Resources\PeminjamanResource\Widgets;

use App\Models\Peminjaman;
use App\Models\User;
use Filament\Notifications\Actions\Action;
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
                    ->label('Cover'),
                TextColumn::make('buku.judul')
                    ->searchable()
                    ->sortable()
                    ->label('Judul'),
                TextColumn::make('tanggal_pengembalian')
                    ->date()
                    ->label('Rencana Pengembalian'),
                TextColumn::make('user.name')
                    ->label('Oleh')
                    ->sortable()
                    ->searchable()
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
                                    ->title('Peminjaman buku anda telah disetujui oleh admin')
                                    ->success()
                                    ->actions([
                                        Action::make('markAsRead')
                                            ->button()
                                            ->markAsRead()
                                    ])
                                    ->toDatabase()
                            );
                            $recipient->notify(
                                Notification::make()
                                    ->title('Peminjaman buku anda telah disetujui oleh admin')
                                    ->success()
                                    ->toBroadcast()
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
                                    ->title('Peminjaman buku anda telah dibatalkan oleh admin')
                                    ->danger()
                                    ->actions([
                                        Action::make('markAsRead')
                                            ->button()
                                            ->markAsRead()
                                    ])
                                    ->toDatabase()
                            );
                            $recipient->notify(
                                Notification::make()
                                    ->title('Peminjaman buku anda telah dibatalkan oleh admin')
                                    ->danger()
                                    ->toBroadcast()
                            );
                        }),
                ]),
            ])
            ->emptyStateHeading('Data kosong');
    }
}
