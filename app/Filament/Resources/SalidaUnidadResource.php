<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SalidaUnidadResource\Pages;
use App\Filament\Resources\SalidaUnidadResource\RelationManagers;
use App\Models\BitacoraUnidad;
use App\Models\SalidaUnidad;
use App\Models\UnidadTransfusional;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Guava\FilamentDrafts\Admin\Resources\Concerns\Draftable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SalidaUnidadResource extends Resource
{
    use Draftable;
    protected static ?string $model = BitacoraUnidad::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Salida Unidad';

    protected static ?string $pluralLabel = 'Almacenamiento Unidades Transfusionales';

    protected static ?string $navigationGroup = 'Almacenamiento Unidades Transfusionales';

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\SalidaUnidad::route('/'),
            'create' => Pages\CreateSalidaUnidad::route('/create'),
            'edit' => Pages\EditSalidaUnidad::route('/{record}/edit'),
        ];
    }
}
