<?php

namespace App\Filament\Resources\UnidadTransfusionalResource\Pages;

use App\Filament\Resources\UnidadTransfusionalResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Guava\FilamentDrafts\Admin\Resources\Concerns\Draftable;

class ListUnidadTransfusionals extends ListRecords
{
    use Draftable;
    protected static string $resource = UnidadTransfusionalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
