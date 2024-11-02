<?php

namespace App\Filament\Officer\Resources\BukuResource\Pages;

use App\Filament\Officer\Resources\BukuResource;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\CreateRecord;

class CreateBuku extends CreateRecord
{
    protected static string $resource = BukuResource::class;

    public function form(\Filament\Forms\Form $form): \Filament\Forms\Form
    {
        return $form->schema([
            TextInput::make('judul')->placeholder('Masukan judul buku'),
            TextInput::make('penulis')->placeholder('Masukan nama penulis'),
            TextInput::make('penerbit')->placeholder('Masukan nama penerbit'),
            TextInput::make('tahun_terbit')->numeric()->placeholder('Masukan tahun terbit'),
        ]);
    }
}
