<?php

namespace App\Filament\Widgets;

use App\Models\Peminjaman;
use Filament\Widgets\ChartWidget;

class StatistikPeminjaman extends ChartWidget
{
    protected static ?string $heading = 'Peminjaman Buku Per Bulan';

    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $peminjamanDataPerBulan = Peminjaman::query()
            ->selectRaw('MONTH(tanggal_peminjaman) as month, COUNT(*) as count')
            ->whereYear('tanggal_peminjaman', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();
        $data = array_fill(1, 12, 0);
        foreach ($peminjamanDataPerBulan as $month => $count) {
            $data[$month] = $count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Peminjaman',
                    'data' => array_values($data),
                    'backgroundColor' => '#3b82f6',
                ],
            ],
            'labels' => [
                'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember',
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
