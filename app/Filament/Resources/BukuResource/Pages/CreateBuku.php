<?php

namespace App\Filament\Resources\BukuResource\Pages;

use App\Filament\Resources\BukuResource;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateBuku extends CreateRecord
{
    protected static string $resource = BukuResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->body('Buku berhasil disimpan');
    }

    public function form(\Filament\Forms\Form $form): \Filament\Forms\Form
    {
        return $form->schema([
            FileUpload::make('cover')
                ->columnSpanFull()
                ->disk('local')
                ->directory('covers')
                ->visibility('private')
                ->image(),
            TextInput::make('judul')->placeholder('Masukan judul buku'),
            TextInput::make('penulis')->placeholder('Masukan nama penulis'),
            TextInput::make('penerbit')->placeholder('Masukan nama penerbit'),
            TextInput::make('tahun_terbit')->numeric()->placeholder('Masukan tahun terbit'),
        ]);
    }
}
