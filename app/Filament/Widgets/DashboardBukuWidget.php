<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardBukuWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Tersedia', 100),
            Stat::make('Buku Dipinjam', 0),
            Stat::make('Buku Belum Dikembalikan', 0),
        ];
    }
}
