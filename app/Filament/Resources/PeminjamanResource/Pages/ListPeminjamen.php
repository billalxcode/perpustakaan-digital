<?php

namespace App\Filament\Resources\PeminjamanResource\Pages;

use App\Filament\Resources\PeminjamanResource;
use App\Filament\Resources\PeminjamanResource\Widgets\PeminjamanBerlangsung;
use App\Filament\Resources\PeminjamanResource\Widgets\PeminjamanMenungguKonfirmasi;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPeminjamen extends ListRecords
{
    protected static string $resource = PeminjamanResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            PeminjamanMenungguKonfirmasi::class,
            PeminjamanBerlangsung::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
