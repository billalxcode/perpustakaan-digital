<?php

namespace App\Filament\Officer\Resources\BukuResource\Pages;

use App\Filament\Officer\Resources\BukuResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBukus extends ListRecords
{
    protected static string $resource = BukuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
