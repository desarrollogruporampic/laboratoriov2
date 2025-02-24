<?php

namespace App\Filament\Resources\SalidaUnidadResource\Pages;

use App\Filament\Resources\SalidaUnidadResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Guava\FilamentDrafts\Admin\Resources\Concerns\Draftable;

class CreateSalidaUnidad extends CreateRecord
{
    use Draftable;
    protected static string $resource = SalidaUnidadResource::class;
}
