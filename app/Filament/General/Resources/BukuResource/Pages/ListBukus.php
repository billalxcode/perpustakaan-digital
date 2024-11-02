<?php

namespace App\Filament\General\Resources\BukuResource\Pages;

use App\Filament\General\Resources\BukuResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBukus extends ListRecords
{
    protected static string $resource = BukuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
