<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrdenResource\Pages;
use App\Filament\Resources\OrdenResource\RelationManagers;
use App\Models\Tratamiento;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;

class OrdenResource extends Resource
{


    protected static ?string $model = Tratamiento::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([])
                //
            ]);
    }


    public static function table(Table $table): Table
    {

        $hoy = Carbon::now('America/Costa_Rica')->format('Y-m-d');

        return $table
            ->modifyQueryUsing(function ($query) use ($hoy) {

                $query->where('t_tratamiento.IS_DELETE', 0)
                    ->where('t_tratamiento.accion_tratamiento', '<', 2)
                    ->where('t_tratamiento.tipo_tratamiento_fk', 4)
                    ->where('t_tratamiento.IS_HIDDEN', 0)
                    ->where('t_tratamiento.EMPRESA', 1)
                    ->join('t_tratamiento_detalle', function (JoinClause $join) use ($hoy) {
                        $join->on('t_tratamiento.id_tratamiento', '=', 't_tratamiento_detalle.tratamiento_fk')
                            ->where(function ($query) {
                                $query->where('t_tratamiento_detalle.completada', 0)->orwhere('t_tratamiento_detalle.completada', 3);
                            })
                            ->where('t_tratamiento_detalle.referir', 0)
                            ->where('t_tratamiento_detalle.ubicacion_filtro_fk', 1)
                            ->where('t_tratamiento_detalle.is_guardado', 0)
                            ->whereDate('t_tratamiento_detalle.fecha_aplicacion_individual', '<=', $hoy)
                            ->where('t_tratamiento_detalle.IS_DELETE', 0)
                            ->where('t_tratamiento_detalle.EMPRESA', 1)
                            ->where('t_tratamiento_detalle.examen_fk', '!=', 0)
                            ->distinct('t_tratamiento_detalle.tratamiento_fk');
                    })
                    ->select(
                        't_tratamiento.orden',
                        't_tratamiento.fecha_aplicacion',
                        't_tratamiento.paciente',
                        't_tratamiento.paciente_fk',
                        't_tratamiento.created_at',
                        't_tratamiento.id_tratamiento'
                    )->distinct('t_tratamiento.id_tratamiento');
            })
            ->columns([
                TextColumn::make('orden')
                    ->label('Número Orden')
                    ->sortable(true)
                    ->wrap()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('fecha_aplicacion')
                    ->label('Fecha indicación')
                    ->sortable(true),
                TextColumn::make('paciente')
                    ->label('paciente')
                    ->sortable(true)
                    ->wrap()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('pacientefk.telefono')
                    ->label('Teléfono')
                    ->sortable(true)
                    ->wrap()
                    ->toggleable(isToggledHiddenByDefault: false),

            ])
            ->searchable(true)

            ->filters([
                Filter::make('fecha_aplicacion')
            ], layout: FiltersLayout::AboveContentCollapsible)

            ->actions([
                /* Tables\Actions\EditAction::make(), */])
            ->deferLoading()
            ->striped()
            ->queryStringIdentifier('pendiente')
            ->defaultPaginationPageOption(10);
    }
    protected function paginateTableQuery(Builder $query): CursorPaginator
    {
        return $query->fastPaginate(($this->getTableRecordsPerPage() === 'all') ? $query->count() : $this->getTableRecordsPerPage());
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageOrdens::route('/'),
        ];
    }
}
