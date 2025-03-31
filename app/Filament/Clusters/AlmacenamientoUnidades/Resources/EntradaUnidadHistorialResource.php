<?php

namespace App\Filament\Clusters\AlmacenamientoUnidades\Resources;

use App\Enums\TipoBitacoraUnidad;
use App\Filament\Clusters\AlmacenamientoUnidades;
use App\Filament\Clusters\AlmacenamientoUnidades\Resources\EntradaUnidadHistorialResource\Pages;
use App\Models\EntradaUnidad;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;


class EntradaUnidadHistorialResource extends Resource
{

    protected static ?string $model = EntradaUnidad::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = AlmacenamientoUnidades::class;

    /*     protected static SubNavigationPosition $subNavigationPosition  = SubNavigationPosition::Top; */

    protected static ?int $navigationSort = 1;

    protected static ?string $pluralLabel = 'Historial Unidad Transfusional';

    protected static ?string $label = 'Historial Unidad Transfusional';

    protected static ?string $navigationGroup = 'Historial Unidades';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            /*   ->query(BitacoraUnidad::query()->where('IS_DELETE', 0)->where('EMPRESA', 1)->onlyDrafts()) */
            ->columns([
                TextColumn::make('tipo_unidad')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'entrada' => 'success',
                        'salida' => 'danger',
                    })
                    ->formatStateUsing(fn(string $state): string => ucfirst(
                        strtolower($state)
                    ))
                    ->sortable(true)
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->width('10%'),
                TextColumn::make('id_entrada_unidad')
                    ->label('Número entrada')
                    ->sortable(true)
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('created_at')
                    ->label('Fecha creación')
                    ->sortable(true),
                TextColumn::make('usercrea.name')
                    ->label('Creado por')
                    ->sortable(true)
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                SelectFilter::make('Filtrar por')
                    ->options(TipoBitacoraUnidad::options())->attribute('tipo_unidad'),
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_at')->native(false),
                        DatePicker::make('created_at')->native(false),
                    ])->columns(2)
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_at'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_at'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                Action::make('download')
                    ->label('PDF')
                    ->url(
                        fn(EntradaUnidad $record): string => route('entrada.bitacora.generar-pdf', ['record' => $record]),
                        shouldOpenInNewTab: true
                    )
            ])
            /*  ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]) */;
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEntradaUnidadHistorials::route('/'),
            /*  'edit' => Pages\EditEntradaUnidadHistorial::route('/{record}/edit'), */
        ];
    }
}
