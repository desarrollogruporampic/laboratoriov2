<?php

namespace App\Filament\Resources\UnidadTransfusionalResource\Pages;

use App\Filament\Resources\UnidadTransfusionalResource;
use App\Models\BodegaAlmacen;
use App\Models\Fenotipo;
use App\Models\GrupoSanguineo;
use App\Models\TipoHemocomponente;
use App\Models\TipoRh;
use App\Models\UnidadTransfusional;
use App\Models\UnidadTransfusionalFenotipo;
use Carbon\Carbon;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;

use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Table;
use Filament\Tables\Contracts\HasTable;
use Guava\FilamentDrafts\Admin\Resources\Concerns\Draftable;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Filament\Tables\Actions\Action as ActionButton;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class EntradaUnidadTransfusional extends Page implements HasTable
{

    use Draftable;
    use InteractsWithTable;
    public ?array $data = [];
    protected static string $resource = UnidadTransfusionalResource::class;

    protected static string $view = 'filament.resources.unidad-transfusional-resource.pages.entrada-unidad-transfusional';

    protected static ?string $navigationLabel = 'Entrada Unidad Transfusional';


    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
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
                            ->label('Tipo Hemocomponente')
                            ->options(fn() => TipoHemocomponente::all()->pluck('nombre_tipo_hemocomponente', 'id'))
                            ->searchable(true)
                            ->searchDebounce(debounce: 200)
                            ->required()
                            ->validationAttribute('Tipo Hemocomponente'),
                        TextInput::make('numero_componente')
                            ->label('Número de unidad')
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
                            ->options(fn() => GrupoSanguineo::all()->pluck('nombre_grupo_sanguineo', 'id'))
                            ->searchable(true)
                            ->required()
                            ->native(false),
                        Select::make('tipo_rh_fk')
                            ->label('Tipo Rh')
                            ->options(fn() => TipoRh::all()->pluck('nombre_tipo_rh', 'id'))
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
                            ->dehydrated(false)
                            ->formatStateUsing(fn(?UnidadTransfusional $record) => (bool) $record?->list_fenotipo)
                            ->disabled(fn(?UnidadTransfusional $record, $context) => (bool) $record?->list_fenotipo && $context == 'edit')
                            ->afterStateUpdated(function (Set $set, Get $get) {
                                $fenotipos = Fenotipo::all();

                                $array = [];

                                foreach ($fenotipos as $fenotipo) {

                                    $element = [
                                        'id_fenotipo' => $fenotipo->id,
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
                                'lg' => 3,
                                'xl' => 3,
                                '2xl' => 6,
                            ])
                            ->maxItems(Fenotipo::count())
                            ->columnSpanFull()
                            ->addable(true)
                            ->reorderableWithDragAndDrop(false)
                            ->schema([
                                Select::make('id')
                                    ->label('Tipo de Fenotipo')
                                    ->options(fn() => Fenotipo::all()->pluck('nombre_fenotipo', 'id'))
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
                                    ->options(fn() => TipoRh::all()->pluck('nombre_tipo_rh', 'id'))
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
                            ->deleteAction(fn(Action $action) => $action->requiresConfirmation())

                    ])
            ])->statePath('data');
    }


    public function create()
    {

        $form = $this->form->getState();
        $nombreFenotipo = null;

        try {
            DB::beginTransaction();

            $unidad = UnidadTransfusional::createDraft([
                'tipo_hemocomponente_fk' => $form['tipo_hemocomponente_fk'],
                'numero_componente' => $form['numero_componente'],
                'fecha_donacion' => $form['fecha_donacion'],
                'fecha_caducidad' => $form['fecha_caducidad'],
                'fecha_entrada' => $form['fecha_entrada'],
                'grupo_sanguineo_fk' => $form['grupo_sanguineo_fk'],
                'tipo_rh_fk' => $form['tipo_rh_fk'],
                'bodega_fk' => $form['bodega_fk'],
                'is_fenotipo' => $form['is_fenotipo'],
                'nombre_fenotipo' => $nombreFenotipo,
                'user_registra' => 3,
                'EMPRESA' => 1,
            ]);



            if (isset($form['list_fenotipo']) && $form['is_fenotipo'] == 1) {

                foreach ($form['list_fenotipo'] as $key => $element) {

                    UnidadTransfusionalFenotipo::create([
                        'id_unidad_transfusional' => $unidad->id,
                        'id_fenotipo' => $element['id_fenotipo'],
                        'id_tipo_rh' => $element['id_tipo_rh'],
                        'descripcion' => $element['nombre_fenotipo'] . $element['sigla_tipo_rh'],
                        'EMPRESA' => 1,
                    ]);

                    if (($key + 1) != count($form['list_fenotipo'])) {
                        $nombreFenotipo .= $element['nombre_fenotipo'] . $element['sigla_tipo_rh'] . ', ';
                    } else {
                        $nombreFenotipo .= $element['nombre_fenotipo'] . $element['sigla_tipo_rh'];
                    }
                }
                Log::info($unidad);

                $unidad->withoutRevision()->update(['nombre_fenotipo' => $nombreFenotipo]);
            }

            DB::commit();

            $this->form->fill();

            Notification::make()
                ->title('Unidad transfusional agregada')
                ->success()
                ->send();
        } catch (\Throwable $th) {
            DB::rollback();

            Notification::make()
                ->title('Error al intentar agregar la unidad transfusional')
                ->warning()
                ->persistent()
                ->body($th->getMessage())
                ->send();
        }
    }
    public function table(Table $table): Table
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
                            $selectedRecords->each(
                                fn(Model $selectedRecord) => $selectedRecord->withoutRevision()->update([
                                    'is_published' => 1,
                                    'published_at' => Carbon::now(),
                                ]),
                            );
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
                ActionButton::make('Editar')
                    ->url(
                        fn(UnidadTransfusional $unidad) => "unidad-transfusionals/$unidad->id/edit"
                    )
                    ->openUrlInNewTab()
            ])->striped()
            ->poll('5s');
            /* ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]) */;
    }
}
