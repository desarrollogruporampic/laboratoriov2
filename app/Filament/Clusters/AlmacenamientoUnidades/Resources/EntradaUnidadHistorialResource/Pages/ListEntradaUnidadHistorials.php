<?php

namespace App\Filament\Clusters\AlmacenamientoUnidades\Resources\EntradaUnidadHistorialResource\Pages;

use App\Filament\Clusters\AlmacenamientoUnidades\Resources\EntradaUnidadHistorialResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Guava\FilamentDrafts\Admin\Resources\Concerns\Draftable;

class ListEntradaUnidadHistorials extends ListRecords
{
    use Draftable;
    protected static string $resource = EntradaUnidadHistorialResource::class;
}
