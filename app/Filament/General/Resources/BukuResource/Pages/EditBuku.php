<?php

namespace App\Filament\General\Resources\BukuResource\Pages;

use App\Filament\General\Resources\BukuResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBuku extends EditRecord
{
    protected static string $resource = BukuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
