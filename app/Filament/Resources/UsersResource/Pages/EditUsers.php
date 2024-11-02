<?php

namespace App\Filament\Resources\UsersResource\Pages;

use App\Filament\Resources\UsersResource;
use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\EditRecord;
use Spatie\Permission\Models\Role;

class EditUsers extends EditRecord
{
    protected static string $resource = UsersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function form(\Filament\Forms\Form $form): \Filament\Forms\Form
    {

        return $form->schema([
            TextInput::make('name')
                ->required()
                ->placeholder('Masukan nama'),
            TextInput::make('email')
                ->required()
                ->placeholder('Masukan email'),
            TextInput::make('address')
                ->required()
                ->placeholder('Masukan alamat'),
            Select::make('role')
                ->label('Role')
                ->options(Role::all()->pluck('name', 'name'))
                ->required()
                ->placeholder('Pilih role'),
        ]);
    }
}
