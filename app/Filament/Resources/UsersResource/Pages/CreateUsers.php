<?php

namespace App\Filament\Resources\UsersResource\Pages;

use App\Filament\Resources\UsersResource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class CreateUsers extends CreateRecord
{
    protected static string $resource = UsersResource::class;

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
            TextInput::make('password')
                ->required()
                ->placeholder('Masukan password')
                ->password(),
            Select::make('role')
                ->label('Role')
                ->options(Role::all()->pluck('name', 'name'))
                ->required()
                ->placeholder('Pilih role'),
        ]);

    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['password'] = Hash::make($data['password']);

        return $data;
    }

    protected function afterActionCalled(): void
    {
        $this->record->assignRole(
            $this->form->getState()['role']
        );
    }
}
