<?php

namespace App\Filament\Resources\EntradaUnidadResource\Pages;

use App\Filament\Resources\EntradaUnidadResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEntradaUnidad extends EditRecord
{
    protected static string $resource = EntradaUnidadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
