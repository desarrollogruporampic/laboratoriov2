<?php

namespace App\Filament\Exports;

use App\Models\EntradaUnidad;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class EntradaUnidadExporter extends Exporter
{
    protected static ?string $model = EntradaUnidad::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id'),
            ExportColumn::make('bodega_fk'),
            ExportColumn::make('tipo_unidad'),
            ExportColumn::make('user_genera'),
            ExportColumn::make('IS_DELETE'),
            ExportColumn::make('EMPRESA'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your entrada unidad export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
