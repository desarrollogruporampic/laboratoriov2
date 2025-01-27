<?php

namespace App\Filament\Resources\UnidadTransfusionalResource\Pages;

use App\Filament\Resources\UnidadTransfusionalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Guava\FilamentDrafts\Admin\Resources\Concerns\Draftable;

class EditUnidadTransfusional extends EditRecord
{
    use Draftable;
    protected static string $resource = UnidadTransfusionalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
