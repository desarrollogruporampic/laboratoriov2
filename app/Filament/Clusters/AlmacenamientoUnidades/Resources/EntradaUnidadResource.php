<?php

namespace App\Filament\Clusters\AlmacenamientoUnidades\Resources;

use App\Filament\Clusters\AlmacenamientoUnidades;
use App\Filament\Clusters\AlmacenamientoUnidades\Resources\EntradaUnidadResource\Pages;

use App\Http\Controllers\UnidadTransfusionalController;
use App\Models\BodegaAlmacen;
use App\Models\EntradaUnidad;
use App\Models\Fenotipo;
use App\Models\GrupoSanguineo;
use App\Models\TipoHemocomponente;
use App\Models\TipoRh;
use App\Models\UnidadTransfusional;
use App\Models\UnidadTransfusionalFenotipo;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;

use Filament\Tables\Table;
use Filament\Forms\Components\Actions\Action;
use Filament\Notifications\Notification;

use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Guava\FilamentDrafts\Admin\Resources\Concerns\Draftable;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Log;
use Filament\Tables\Actions\Action as ActionButton;
use Filament\Tables\Actions\EditAction;
use Illuminate\Support\Facades\Auth;

class EntradaUnidadResource extends Resource
{
    use Draftable;
    use InteractsWithTable;

    protected static ?string $model = UnidadTransfusional::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = AlmacenamientoUnidades::class;

    protected static ?string $pluralLabel = 'Crear Entrada';

    protected static ?string $label = 'Entrada Unidades';

    protected static ?string $navigationGroup = 'Entrada Unidades';

    /*    protected static SubNavigationPosition $subNavigationPosition  = SubNavigationPosition::Top; */

    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->columns([
                        'default' => 1,
                        'sm' => 1,
                        'md' => 2,
                        'lg' => 2,
                        'xl' => 2,
                        '2xl' => 2,
                    ])
                    ->schema([
                        Select::make('tipo_hemocomponente_fk')
                            ->label('Tipo de Hemocomponente')
                            ->options(fn() => TipoHemocomponente::all()->pluck('nombre_tipo_hemocomponente', 'id_tipo_hemocomponente'))
                            ->searchable(true)
                            ->searchDebounce(debounce: 200)
                            ->required()
                            ->validationAttribute('Tipo de Hemocomponente'),
                        TextInput::make('numero_componente')
                            ->label('Número de serie')
                            ->placeholder('Escriba el número de serie')
                            ->required(),
                        DateTimePicker::make('fecha_entrada')
                            ->label('Fecha de entrada')
                            ->required()
                            ->native(false),
                        DateTimePicker::make('fecha_donacion')
                            ->label('Fecha de donación')
                            ->required()
                            ->native(false),
                        DateTimePicker::make('fecha_caducidad')
                            ->label('Fecha de caducidad')
                            ->required()
                            ->native(false),
                        Select::make('grupo_sanguineo_fk')
                            ->label('Grupo sanguineo')
                            ->options(fn() => GrupoSanguineo::all()->pluck('nombre_grupo_sanguineo', 'id_grupo_sanguineo'))
                            ->searchable(true)
                            ->required()
                            ->native(false),
                        Select::make('tipo_rh_fk')
                            ->label('Tipo Rh')
                            ->options(fn() => TipoRh::all()->pluck('nombre_tipo_rh', 'id_tipo_rh'))
                            ->searchable(true)
                            ->searchDebounce(debounce: 200)
                            ->required()
                            ->native(false),
                        Select::make('bodega_fk')
                            ->label('Bodega')
                            ->options(fn() => BodegaAlmacen::where('IS_DELETE', 0)->where('EMPRESA', 1)->pluck('nombre_bodega_almacen', 'id_bodega_almacen'))
                            ->searchable(true)
                            ->searchDebounce(debounce: 200)
                            ->required()
                            ->native(false),
                        Checkbox::make('is_fenotipo')
                            ->label('Agregar Fenotipos')
                            ->live()
                            ->columnSpanFull()
                            /*  ->dehydrated(false) */
                            ->formatStateUsing(fn(?UnidadTransfusional $record) => (bool) $record?->is_fenotipo)
                            /*  ->disabled(fn(?UnidadTransfusional $record, $context) => (bool) $record?->is_fenotipo && $context == 'edit') */
                            ->afterStateUpdated(function (Set $set, Get $get) {
                                $fenotipos = Fenotipo::all();

                                $array = [];

                                foreach ($fenotipos as $fenotipo) {

                                    $element = [
                                        'id_fenotipo' => $fenotipo->id_fenotipo,
                                        'nombre_fenotipo' => $fenotipo->nombre_fenotipo,
                                        'id_tipo_rh' => '',
                                        'sigla_tipo_rh' => ''
                                    ];

                                    \array_push($array, $element);
                                }
                                $set('list_fenotipo', $array);
                            }),
                        Repeater::make('list_fenotipo')
                            ->label('Nombre de Fenotipo')
                            ->hidden(fn(Get $get) => ! $get('is_fenotipo'))
                            ->grid([
                                'default' => 1,
                                'sm' => 1,
                                'md' => 2,
                                'lg' => 6,
                                'xl' => 6,
                                '2xl' => 6,
                            ])
                            ->maxItems(Fenotipo::count())
                            ->columnSpanFull()
                            ->addable(true)
                            ->reorderableWithDragAndDrop(false)
                            ->schema([
                                Select::make('id_fenotipo')
                                    ->label('Tipo de Fenotipo')
                                    ->options(fn() => Fenotipo::all()->pluck('nombre_fenotipo', 'id_fenotipo'))
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                    ->selectablePlaceholder(false)
                                    ->required()
                                    ->native(false),
                                TextInput::make('nombre_fenotipo')
                                    ->required()
                                    ->hidden(true),
                                Select::make('id_tipo_rh')
                                    ->label('Tipo de Rh')
                                    ->live()
                                    ->options(fn() => TipoRh::all()->pluck('nombre_tipo_rh', 'id_tipo_rh'))
                                    ->afterStateUpdated(function (Get $get, Set $set) {
                                        if ($get('id_tipo_rh')) {
                                            $set('sigla_tipo_rh', TipoRh::find($get('id_tipo_rh'))->sigla_tipo_rh);
                                        } else {
                                            $set('sigla_tipo_rh', null);
                                        }
                                    })
                                    ->required()
                                    ->native(false),
                                TextInput::make('sigla_tipo_rh')
                                    ->required()
                                    ->hidden(true),

                            ])
                            ->addActionLabel('Nuevo Fenotipo')
                            ->deleteAction(fn(Action $action) => $action->requiresConfirmation()->cancelParentActions())

                    ])
            ])->statePath('data');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading('Tabla de unidades transfusionales sin procesar')
            ->description('Seleccione las unidades que desea procesar')
            ->headerActions([
                ActionButton::make('add')
                    ->label('Procesar seleccionados')
                    ->icon('heroicon-m-circle-stack')
                    ->button()
                    ->outlined()
                    ->labeledFrom('md')
                    ->accessSelectedRecords()
                    ->requiresConfirmation()
                    ->action(function (Collection $selectedRecords) {
                        if (count($selectedRecords) > 0) {

                            $entrada = EntradaUnidad::create([
                                'user_genera' => Auth::user()->id,
                                'EMPRESA' => 1,
                                'tipo_unidad' => 'entrada'
                            ]);

                            $selectedRecords->each(function (Model $selectedRecord) use ($entrada) {
                                UnidadTransfusionalController::publicarEntradaUnidad($selectedRecord, $entrada, 0);
                            });

                            Notification::make()
                                ->title('Cambios guardados')
                                ->success()
                                ->body('Registros procesados')
                                ->send();
                        } else {

                            Notification::make()
                                ->title('Atención')
                                ->info()
                                ->body('No se ha selecionado un registro')
                                ->send();
                        }
                    })
                    ->deselectRecordsAfterCompletion(),
                ActionButton::make('delete')
                    ->label('Borrar seleccionados')
                    ->icon('heroicon-m-trash')
                    ->button()
                    ->outlined()
                    ->color('danger')
                    ->labeledFrom('md')
                    ->accessSelectedRecords()
                    ->requiresConfirmation()
                    ->action(function (Collection $selectedRecords) {
                        if (count($selectedRecords) > 0) {
                            $selectedRecords->each(
                                fn(Model $selectedRecord) => $selectedRecord->withoutRevision()->update([
                                    'IS_DELETE' => 1,
                                ]),
                            );
                            Notification::make()
                                ->title('Cambios guardados')
                                ->success()
                                ->body('Registros borrados')
                                ->send();
                        } else {

                            Notification::make()
                                ->title('Atención')
                                ->info()
                                ->body('No se ha selecionado un registro')
                                ->send();
                        }
                    })
                    ->deselectRecordsAfterCompletion(),




            ])
            ->selectable()
            ->query(UnidadTransfusional::query()->where('IS_DELETE', 0)->where('EMPRESA', 1)->onlyDrafts())
            ->columns([
                TextColumn::make('tipohemocomponente.nombre_tipo_hemocomponente')
                    ->label('Tipo Hemocomponente')
                    ->sortable(true)
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('numero_componente')
                    ->label('Número unidad')
                    ->sortable(true)
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('fecha_donacion')
                    ->label('Fecha donación')
                    ->sortable(true)
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('fecha_caducidad')
                    ->label('Fecha caducidad')
                    ->sortable(true)
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('fecha_entrada')
                    ->label('Fecha entrada')
                    ->sortable(true)
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('gruposanguineo.nombre_grupo_sanguineo')
                    ->label('Grupo Sanguineo')
                    ->sortable(true)
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('tiporh.nombre_tipo_rh')
                    ->label('Tipo Rh')
                    ->sortable(true)
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('nombre_fenotipo')
                    ->label('Nombre Fenotipo')
                    ->sortable(true)
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make()
                    ->mutateRecordDataUsing(function (array $data): array {

                        $unidad = UnidadTransfusional::with('unidadtransfusionalfenotipo')->onlyDrafts()->find($data['id_unidad_transfusional']);
                        Log::info($unidad);
                        $data['list_fenotipo'] = $unidad->unidadtransfusionalfenotipo;
                        return $data;
                    })->modalWidth(MaxWidth::Screen)
                    ->using(function (Model $record, array $data): Model {

                        return self::update($record, $data);
                    })
            ])->striped()
            ->paginated(false);
    }

    public static function update(Model $record, array $data): Model
    {

        Log::info('Data');
        Log::info($data);
        /*    Log::info($data); */

        $nombreFenotipo = null;


        Log::info('Entra a borrar todo los fenotipo');
        $unidades = UnidadTransfusionalFenotipo::where('id_unidad_transfusional', $record->id_unidad_transfusional)->get();
        foreach ($unidades as $unidad) {
            if ($unidad) {
                Log::info('Borra unidad');
                Log::info($unidad);
                $unidad->delete();
            }
        }


        if (isset($data['list_fenotipo']) && $data['is_fenotipo'] == true) {

            foreach ($data['list_fenotipo'] as $key => $element) {
                $fenotipo = Fenotipo::find($element['id_fenotipo']);
                $tiporh = TipoRh::find($element['id_tipo_rh']);

                Log::info('crea nuevo fenotipo');

                $unidadFenotipo = UnidadTransfusionalFenotipo::create([
                    'id_unidad_transfusional' => $record['id_unidad_transfusional'],
                    'id_fenotipo' => $element['id_fenotipo'],
                    'id_tipo_rh' => $element['id_tipo_rh'],
                    'descripcion' => $element['nombre_fenotipo'] . $element['sigla_tipo_rh'],
                    'EMPRESA' => 1,
                ]);
                Log::info($unidadFenotipo);

                if (($key + 1) != count($data['list_fenotipo'])) {

                    $nombreFenotipo .= $fenotipo->nombre_fenotipo . $tiporh->sigla_tipo_rh . ', ';
                } else {
                    $nombreFenotipo .=  $fenotipo->nombre_fenotipo . $tiporh->sigla_tipo_rh;
                }
            }
        }


        $record->withoutRevision()->update([
            'tipo_hemocomponente_fk' => $data['tipo_hemocomponente_fk'],
            'numero_componente' => $data['numero_componente'],
            'fecha_donacion' => $data['fecha_donacion'],
            'fecha_caducidad' => $data['fecha_caducidad'],
            'fecha_entrada' => $data['fecha_entrada'],
            'grupo_sanguineo_fk' => $data['grupo_sanguineo_fk'],
            'tipo_rh_fk' => $data['tipo_rh_fk'],
            'bodega_fk' => $data['bodega_fk'],
            'is_fenotipo' => $data['is_fenotipo'],
            'nombre_fenotipo' => $nombreFenotipo,
            'user_registra' => 3,
            'EMPRESA' => 1,
        ]);

        return $record;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageEntradaUnidads::route('/'),
        ];
    }
}
