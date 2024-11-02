<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardBukuWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Buku', 0),
        ];
    }
}
