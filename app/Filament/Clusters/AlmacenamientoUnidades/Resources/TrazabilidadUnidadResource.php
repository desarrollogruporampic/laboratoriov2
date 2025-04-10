<?php

namespace App\Filament\Clusters\AlmacenamientoUnidades\Resources;

use App\Filament\Clusters\AlmacenamientoUnidades;
use App\Filament\Clusters\AlmacenamientoUnidades\Resources\TrazabilidadUnidadResource\Pages;
use App\Filament\Clusters\AlmacenamientoUnidades\Resources\TrazabilidadUnidadResource\RelationManagers;
use App\Http\Controllers\UnidadTransfusionalController;
use App\Models\BitacoraUnidad;
use App\Models\EntradaUnidad;
use App\Models\KardexUnidad;
use App\Models\TipoHemocomponente;
use Filament\Actions\Concerns\HasInfolist;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use JaOcero\ActivityTimeline\Components\ActivityDate;
use JaOcero\ActivityTimeline\Components\ActivityDescription;
use JaOcero\ActivityTimeline\Components\ActivityIcon;
use JaOcero\ActivityTimeline\Components\ActivitySection;
use JaOcero\ActivityTimeline\Components\ActivityTitle;
use JaOcero\ActivityTimeline\Enums\IconAnimation;

class TrazabilidadUnidadResource extends Resource
{


    protected static ?string $model = BitacoraUnidad::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = AlmacenamientoUnidades::class;


    protected static ?string $pluralLabel = 'Trazabilidad';

    protected static ?string $label = 'Trazabilidad';

    protected static ?string $navigationGroup = 'Trazabilidad Unidades';

    protected static ?int $navigationSort = 2;

    protected $record;

    public static function getPages(): array
    {
        return [
            'index' => Pages\TrazabilidadUnidad::route('/'),
            /*    'activities' => Pages\TimelineUnidad::route('/{record}/activities'), */
        ];
    }
}
