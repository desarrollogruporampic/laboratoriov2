<?php

namespace App\Filament\Resources\UnidadTransfusionalResource\Pages;

use App\Filament\Resources\UnidadTransfusionalResource;
use App\Models\TipoHemocomponente;
use App\Models\UnidadTransfusional;
use Filament\Actions;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
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

    public function table(Table $table): Table
    {
        return $table
            ->heading('Tabla de disponibilidad de tipos de Hemocomponentes')
            ->description('Se muestra el stock actual de los tipos de Hemocomponentes que están registrados')
            ->selectable()
            ->query(TipoHemocomponente::query()->where('IS_DELETE', 0))
            ->defaultSort('nombre_tipo_hemocomponente', 'asc')

            ->columns([
                TextColumn::make('nombre_tipo_hemocomponente')
                    ->label('Tipo Hemocomponente')
                    ->sortable(true)
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('sigla_tipo_hemocomponente')
                    ->label('Siglas')
                    ->sortable(true)
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('unidadtransfusionalsapositivo_count')->counts([
                    'unidadtransfusionalsapositivo' => fn(Builder $query) => $query->where('is_published', 1),
                ])
                    ->label('A+')
                    ->sortable(true)
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('unidadtransfusionalsanegativo_count')->counts([
                    'unidadtransfusionalsanegativo' => fn(Builder $query) => $query->where('is_published', 1),
                ])
                    ->label('A-')
                    ->sortable(true)
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('unidadtransfusionalsbpositivo_count')->counts([
                    'unidadtransfusionalsbpositivo' => fn(Builder $query) => $query->where('is_published', 1),
                ])
                    ->label('B+')
                    ->sortable(true)
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('unidadtransfusionalsbnegativo_count')->counts([
                    'unidadtransfusionalsbnegativo' => fn(Builder $query) => $query->where('is_published', 1),
                ])
                    ->label('B-')
                    ->sortable(true)
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('unidadtransfusionalsabpositivo_count')->counts([
                    'unidadtransfusionalsabpositivo' => fn(Builder $query) => $query->where('is_published', 1),
                ])
                    ->label('AB+')
                    ->sortable(true)
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('unidadtransfusionalsabnegativo_count')->counts([
                    'unidadtransfusionalsabnegativo' => fn(Builder $query) => $query->where('is_published', 1),
                ])
                    ->label('AB-')
                    ->sortable(true)
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('unidadtransfusionalsopositivo_count')->counts([
                    'unidadtransfusionalsopositivo' => fn(Builder $query) => $query->where('is_published', 1),
                ])
                    ->label('O+')
                    ->sortable(true)
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('unidadtransfusionalsonegativo_count')->counts([
                    'unidadtransfusionalsonegativo' => fn(Builder $query) => $query->where('is_published', 1),
                ])
                    ->label('O-')
                    ->sortable(true)
                    ->toggleable(isToggledHiddenByDefault: false),
            ])

            ->filters([
                //
            ])

            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->striped()
            ->paginated(false)
            ->poll('2s');
    }
}
