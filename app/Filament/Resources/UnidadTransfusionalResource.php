<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UnidadTransfusionalResource\Pages;
use App\Models\Fenotipo;
use App\Models\TipoRh;
use App\Models\UnidadTransfusional;
use App\Models\UnidadTransfusionalFenotipo;
use Filament\Forms\Contracts\HasForms;
use Filament\Resources\Resource;

use Guava\FilamentDrafts\Admin\Resources\Concerns\Draftable;

class UnidadTransfusionalResource extends Resource
{
    use Draftable;

    protected static ?string $model = UnidadTransfusional::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    protected static ?string $navigationLabel = 'Stock Unidad';


    protected static ?string $pluralLabel = 'Stock Unidades';

    protected static ?string $navigationGroup = 'Almacenamiento Unidades Transfusionales';

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUnidadTransfusionals::route('/'),
            'create' => Pages\CreateUnidadTransfusional::route('/create'),
            'edit' => Pages\EditUnidadTransfusional::route('/{record}/edit'),
        ];
    }
}
