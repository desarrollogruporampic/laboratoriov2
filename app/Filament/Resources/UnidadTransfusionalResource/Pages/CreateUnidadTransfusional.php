<?php

namespace App\Filament\Resources\UnidadTransfusionalResource\Pages;

use App\Filament\Resources\UnidadTransfusionalResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Guava\FilamentDrafts\Admin\Resources\Concerns\Draftable;

class CreateUnidadTransfusional extends CreateRecord
{
    use Draftable;
    protected static string $resource = UnidadTransfusionalResource::class;
}
