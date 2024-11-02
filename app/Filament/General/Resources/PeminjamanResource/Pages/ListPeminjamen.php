<?php

namespace App\Filament\General\Resources\PeminjamanResource\Pages;

use App\Filament\General\Resources\PeminjamanResource;
use App\Filament\General\Resources\PeminjamanResource\Widgets\PeminjamanBerlangsung;
use App\Filament\General\Resources\PeminjamanResource\Widgets\PeminjamanMenungguKonfirmasi;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPeminjamen extends ListRecords
{
    protected static string $resource = PeminjamanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            PeminjamanBerlangsung::class,
            PeminjamanMenungguKonfirmasi::class,
        ];
    }
}
