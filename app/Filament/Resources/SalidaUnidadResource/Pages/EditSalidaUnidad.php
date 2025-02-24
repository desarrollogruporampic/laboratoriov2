<?php

namespace App\Filament\Resources\SalidaUnidadResource\Pages;

use App\Filament\Resources\SalidaUnidadResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Guava\FilamentDrafts\Admin\Resources\Concerns\Draftable;

class EditSalidaUnidad extends EditRecord
{
    use Draftable;
    protected static string $resource = SalidaUnidadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
