<?php

namespace App\Filament\Clusters\AlmacenamientoUnidades\Resources\SalidaUnidadResource\Pages;

use App\Filament\Clusters\AlmacenamientoUnidades\Resources\SalidaUnidadResource;
use App\Filament\Clusters\AlmacenamientoUnidades\Resources\SalidaUnidadResource\Widgets\CreateSalidaUnidadWidget;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageSalidaUnidads extends ManageRecords
{
    protected static string $resource = SalidaUnidadResource::class;

    public static function getWidgets(): array
    {
        return [
            CreateSalidaUnidadWidget::class,
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            CreateSalidaUnidadWidget::class,
        ];
    }
}
