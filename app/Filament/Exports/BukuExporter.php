<?php

namespace App\Filament\Exports;

use App\Models\Buku;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use OpenSpout\Common\Entity\Style\CellAlignment;
use OpenSpout\Common\Entity\Style\CellVerticalAlignment;
use OpenSpout\Common\Entity\Style\Color;
use OpenSpout\Common\Entity\Style\Style;

class BukuExporter extends Exporter
{
    protected static ?string $model = Buku::class;

    public function getFileDisk(): string
    {
        return 'local';
    }

    public function getXlsxHeaderCellStyle(): ?Style
    {
        return (new Style)
            ->setFontBold()
            ->setFontItalic()
            ->setFontColor(Color::rgb(255, 255, 255))
            ->setBackgroundColor(Color::rgb(51, 51, 51))
            ->setCellAlignment(CellAlignment::CENTER)
            ->setCellVerticalAlignment(CellVerticalAlignment::CENTER);
    }

    public function getXlsxCellStyle(): ?Style
    {
        return (new Style)
            ->setFontColor(Color::rgb(0, 0, 0))
            ->setBackgroundColor(Color::rgb(239, 239, 239))
            ->setCellAlignment(CellAlignment::CENTER)
            ->setCellVerticalAlignment(CellAlignment::CENTER);
    }

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('judul'),
            ExportColumn::make('penulis'),
            ExportColumn::make('penerbit'),
            ExportColumn::make('tahun_terbit'),
            ExportColumn::make('created_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your buku export has completed and '.number_format($export->successful_rows).' '.str('row')->plural($export->successful_rows).' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.number_format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to export.';
        }

        return $body;
    }
}
