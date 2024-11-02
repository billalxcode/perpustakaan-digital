<?php

namespace App\Filament\General\Resources\PeminjamanResource\Widgets;

use App\Models\Peminjaman;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class PeminjamanStatWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $user = Auth::user();

        $jumlah_buku_dipinjam =
            Peminjaman::where('user_id', '=', $user->id)
                ->where('status_peminjaman', '=', 'berlangsung');
        $jumlah_buku_dikembalikan =
            Peminjaman::where('user_id', '=', $user->id)
                ->where('status_peminjaman', '=', 'dikembalikan');
        $jumlah_buku_dibatalkan =
            Peminjaman::where('user_id', '=', $user->id)
                ->where('status_peminjaman', '=', 'dibatalkan');

        return [
            Stat::make('Buku dipinjam', $jumlah_buku_dipinjam->count()),
            Stat::make('Buku dikembalikan', $jumlah_buku_dikembalikan->count()),
            Stat::make('Buku dibatalkan', $jumlah_buku_dibatalkan->count()),
        ];
    }
}
