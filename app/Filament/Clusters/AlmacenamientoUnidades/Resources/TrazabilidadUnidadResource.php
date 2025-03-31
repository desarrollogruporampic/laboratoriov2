<?php

namespace App\Filament\Clusters\AlmacenamientoUnidades\Resources;

use App\Filament\Clusters\AlmacenamientoUnidades;
use App\Filament\Clusters\AlmacenamientoUnidades\Resources\TrazabilidadUnidadResource\Pages;
use App\Filament\Clusters\AlmacenamientoUnidades\Resources\TrazabilidadUnidadResource\RelationManagers;
use App\Http\Controllers\UnidadTransfusionalController;
use App\Models\KardexUnidad;
use App\Models\TipoHemocomponente;

use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TrazabilidadUnidadResource extends Resource
{
    use InteractsWithTable;
    protected static ?string $model = KardexUnidad::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = AlmacenamientoUnidades::class;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('unidadtransfusional.numero_componente')
                    ->label('Número unidad')
                    ->sortable(true)
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('unidadtransfusional.fecha_donacion')
                    ->label('Fecha donación')
                    ->sortable(true)
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('unidadtransfusional.fecha_caducidad')
                    ->label('Fecha caducidad')
                    ->sortable(true)
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('unidadtransfusional.fecha_entrada')
                    ->label('Fecha entrada')
                    ->sortable(true),
                TextColumn::make('unidadtransfusional.gruposanguineo.nombre_grupo_sanguineo')
                    ->label('Grupo Sanguineo')
                    ->sortable(true)
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('unidadtransfusional.tiporh.nombre_tipo_rh')
                    ->label('Tipo Rh')
                    ->sortable(true)
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('unidadtransfusional.nombre_fenotipo')
                    ->label('Nombre Fenotipo')
                    ->sortable(true)
                    ->toggleable(isToggledHiddenByDefault: false)
            ])
            ->filters([
                //
            ])

            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageTrazabilidadUnidads::route('/'),
        ];
    }
}
