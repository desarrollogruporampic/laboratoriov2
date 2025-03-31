<?php

namespace App\Filament\Clusters\AlmacenamientoUnidades\Resources\TrazabilidadUnidadResource\Pages;

use App\Filament\Clusters\AlmacenamientoUnidades\Resources\TrazabilidadUnidadResource;
use App\Filament\Clusters\AlmacenamientoUnidades\Resources\TrazabilidadUnidadResource\Widgets\SearchUnidadWidget;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageTrazabilidadUnidads extends ManageRecords
{
    protected static string $resource = TrazabilidadUnidadResource::class;


    public static function getWidgets(): array
    {
        return [
            SearchUnidadWidget::class,
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            SearchUnidadWidget::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
