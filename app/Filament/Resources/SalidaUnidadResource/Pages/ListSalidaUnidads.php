<?php

namespace App\Filament\Resources\SalidaUnidadResource\Pages;

use App\Filament\Resources\SalidaUnidadResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Guava\FilamentDrafts\Admin\Resources\Concerns\Draftable;

class ListSalidaUnidads extends ListRecords
{
    use Draftable;
    protected static string $resource = SalidaUnidadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
