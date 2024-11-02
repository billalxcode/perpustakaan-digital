<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UsersResource\Pages;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role;

class UsersResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Data';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('email')->searchable()->sortable(),
                TextColumn::make('rfid')->searchable()
                    ->badge()
                    ->getStateUsing(fn ($record) => $record->rfid ?? 'Belum terkoneksi')
                    ->color(fn ($state) => $state === 'Belum terkoneksi' ? 'danger' : 'success')
                    ->label('Identifier'),
                TextColumn::make('roles.name')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'admin' => 'success',
                        'officer' => 'warning',
                        'general' => 'info'
                    })
                    ->label('Role'),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->options(function () {
                        return Role::all()->pluck('name', 'name')->toArray();
                    })
                    ->query(function (Builder $query, array $data) {
                        if ($data['value'] !== null) {
                            // Jika nama role tertentu dipilih, lakukan filter berdasarkan role tersebut
                            return $query->whereHas('roles', function (Builder $subQuery) use ($data) {
                                $subQuery->where('name', $data['value']);
                            });
                        }

                        return $query;
                    }),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('changeRole')
                        ->label('Change Role')
                        ->icon('heroicon-o-adjustments-horizontal')
                        ->form([
                            Select::make('role')
                                ->label('Role')
                                ->options(
                                    Role::all()->pluck('name', 'name')
                                )
                                ->required(),
                        ])
                        ->action(function ($record, array $data) {
                            $record->syncRoles([]);

                            $record->assignRole($data['role']);
                        })
                        ->requiresConfirmation()
                        ->modalHeading('Change Role'),
                    Tables\Actions\Action::make('connect')
                        ->label('Hubungkan Kartu')
                        ->icon('heroicon-o-credit-card')
                        ->form([
                            TextInput::make('uuid')
                                ->id('uuidInput')
                                ->label('UUID')
                                ->placeholder('Masukan UUID')
                                ->reactive()
                                ->disabled(),
                        ])
                        ->modalWidth(MaxWidth::Small)
                        ->modalDescription('Mohon maaf, fitur ini masih dalam tahap pengembangan')
                        ->modalHeading('Hubungkan Kartu')
                        ->action(function () {
                            Notification::make()
                                ->warning()
                                ->title('PERHATIAN!!!')
                                ->body('Fitur ini masih dalam tahap pengembangan, mohon untuk tunggu sampai pengembangan selesai')
                                ->send();
                        }),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                // Sembunyikan pengguna dengan role "admin"
                return $query->whereDoesntHave('roles', function (Builder $subQuery) {
                    $subQuery->where('name', 'admin');
                });
            })
            ->defaultSort('created_at');
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUsers::route('/create'),
            'edit' => Pages\EditUsers::route('/{record}/edit'),
        ];
    }
}
