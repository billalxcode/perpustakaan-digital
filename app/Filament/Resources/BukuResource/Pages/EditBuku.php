<?php

namespace App\Filament\Resources\BukuResource\Pages;

use App\Filament\Resources\BukuResource;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\EditRecord;

class EditBuku extends EditRecord
{
    protected static string $resource = BukuResource::class;

    protected function getSavedNotification(): ?\Filament\Notifications\Notification
    {
        return \Filament\Notifications\Notification::make()
            ->success()
            ->title('Sukses')
            ->body('Data buku berhasil diubah');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function form(\Filament\Forms\Form $form): \Filament\Forms\Form
    {
        return $form->schema([
            FileUpload::make('cover')
                ->disk('local')
                ->visibility('private')
                ->image(),
            TextInput::make('judul')->placeholder('Masukan judul buku'),
            TextInput::make('penulis')->placeholder('Masukan nama penulis'),
            TextInput::make('penerbit')->placeholder('Masukan nama penerbit'),
            TextInput::make('tahun_terbit')->numeric()->placeholder('Masukan tahun terbit'),
        ]);
    }
}
