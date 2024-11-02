<?php

namespace App\Filament\General\Resources;

use App\Filament\General\Resources\BukuResource\Pages;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Mokhosh\FilamentRating\Components\Rating;

class BukuResource extends Resource
{
    protected static ?string $model = Buku::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationLabel = 'Buku';

    protected static ?string $pluralLabel = 'Buku';

    public static function table(Table $table): Table
    {
        $user = Auth::user();

        return $table
            ->columns([
                ImageColumn::make('cover')
                    ->disk('local')
                    ->visibility('private'),
                TextColumn::make('judul')->searchable()->sortable(),
                TextColumn::make('penulis')->searchable()->sortable(),
                TextColumn::make('penerbit')->searchable(),
                TextColumn::make('tahun_terbit')->searchable()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                \Filament\Tables\Actions\ActionGroup::make([
                    \Filament\Tables\Actions\Action::make('ulasan')
                        ->label('Buat Ulasan')
                        ->color('green')
                        ->icon('heroicon-o-pencil')
                        ->form([
                            TextInput::make('ulasan')
                                ->placeholder('Masukan ulasan kamu'),
                            Rating::make('rating')
                                ->stars(10)
                                ->size('xl'),
                        ])
                        ->modalHeading('Buat Ulasan'),
                    \Filament\Tables\Actions\Action::make('pinjam')
                        ->label('Pinjam')
                        ->icon('heroicon-o-plus-circle')
                        ->modalHeading('Pinjam Buku')
                        ->modalDescription('Dengan ini, kamu bertanggung jawab atas kerusakan atau kehilangan pada buku ini.')
                        ->color('warning')
                        ->action(function ($record) use ($user) {
                            Peminjaman::create([
                                'user_id' => $user->id,
                                'buku_id' => $record->id,
                                'tanggal_peminjaman' => now(),
                                'status_peminjaman' => 'menunggu',
                            ]);

                            Notification::make()
                                ->success()
                                ->body('Silahkan tunggu petugas untuk mengkonfirmasi peminjaman buku anda')
                                ->send();

                            $users = User::role(['admin', 'officer'])->get();

                            foreach ($users as $user) {
                                $user->notify(
                                    Notification::make()
                                        ->info()
                                        ->body('Ada peminjam yang butuh konfirmasi')
                                        ->actions([
                                            Action::make('markAsRead')
                                                ->button()
                                                ->markAsRead()
                                        ])
                                        ->toDatabase()
                                );
                                $user->notify(
                                    Notification::make()
                                        ->info()
                                        ->body('Ada peminjam yang butuh konfirmasi')
                                        ->toBroadcast()
                                );
                            }
                        })
                        ->modalIcon('heroicon-o-exclamation-triangle'),
                ]),
            ], ActionsPosition::BeforeColumns);
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
            'index' => Pages\ListBukus::route('/'),
        ];
    }
}
