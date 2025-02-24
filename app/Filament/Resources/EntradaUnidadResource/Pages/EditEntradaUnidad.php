<?php

namespace App\Filament\Resources\EntradaUnidadResource\Pages;

use App\Filament\Resources\EntradaUnidadResource;
use App\Filament\Resources\UnidadTransfusionalResource;
use App\Models\BodegaAlmacen;
use App\Models\Fenotipo;
use App\Models\GrupoSanguineo;
use App\Models\TipoHemocomponente;
use App\Models\TipoRh;
use App\Models\UnidadTransfusional;
use App\Models\UnidadTransfusionalFenotipo;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Pages\EditRecord;
use Guava\FilamentDrafts\Admin\Resources\Concerns\Draftable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;

class EditEntradaUnidad extends EditRecord
{
    use Draftable;

    use InteractsWithActions;
    use WithPagination;

    public ?array $data = [];
    protected static string $resource = UnidadTransfusionalResource::class;


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
                            ->options(fn() => TipoHemocomponente::all()->pluck('nombre_tipo_hemocomponente', 'id_tipo_hemocomponente'))
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
                            ->columnSpanFull()
                            ->reactive()
                            ->formatStateUsing(fn(?UnidadTransfusional $record) => (bool) $record->is_fenotipo),

                        Repeater::make('unidadtransfusionalfenotipo')
                            ->label('Nombre de Fenotipo')
                            ->relationship()
                            ->hidden(fn(Get $get) => ! $get('is_fenotipo'))
                            ->reactive()
                            /*  ->dehydrateStateUsing(fn(string $state): string => Hash::make($state)) */
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
                                Select::make('id_fenotipo')
                                    ->relationship('fenotipo')
                                    ->label('Tipo de Fenotipo')
                                    ->options(fn() => Fenotipo::all()->pluck('nombre_fenotipo', 'id_fenotipo'))
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                    ->selectablePlaceholder(false)
                                    ->required()
                                    ->native(false),
                                Select::make('id_tipo_rh')
                                    ->relationship('tiporh')
                                    ->label('Tipo de Rh')
                                    ->options(fn() => TipoRh::all()->pluck('nombre_tipo_rh', 'id_tipo_rh'))
                                    ->required()
                                    ->native(false),
                            ])
                            ->addActionLabel('Nuevo Fenotipo')
                            ->deleteAction(fn(Action $action) => $action->requiresConfirmation())
                            ->mutateRelationshipDataBeforeSaveUsing(function (array $data): array {
                                $data['EMPRESA'] = 1;
                                /*   Log::info($data); */
                                return $data;
                            })

                            ->dehydrated(true)



                    ])
            ]);
    }


    protected function handleRecordUpdate(Model $record, array $data): Model
    {

        Log::info($this->data);
        /*    Log::info($data); */

        $nombreFenotipo = null;

        if (!$data['is_fenotipo']) {

            $unidades = UnidadTransfusionalFenotipo::where('id_unidad_transfusional', $record->id_unidad_transfusional)->get();
            foreach ($unidades as $unidad) {
                if ($unidad) {
                    $unidad->delete();
                }
            }
        }

        if (isset($data['unidadtransfusionalfenotipo']) && $data['is_fenotipo'] == true) {

            foreach ($data['unidadtransfusionalfenotipo'] as $key => $element) {
                $fenotipo = Fenotipo::find($element['id_fenotipo']);
                $tiporh = TipoRh::find($element['id_tipo_rh']);
                /*  UnidadTransfusionalFenotipo::create([
                    'id_unidad_transfusional' => $record['id_unidad_transfusional'],
                    'id_fenotipo' => $element['id_fenotipo'],
                    'id_tipo_rh' => $element['id_tipo_rh'],
                    'descripcion' => $element['nombre_fenotipo'] . $element['sigla_tipo_rh'],
                    'EMPRESA' => 1,
                ]); */

                if (($key + 1) != count($data['unidadtransfusionalfenotipo'])) {

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


        $this->redirect('edit', true);
        return $record;
    }

    protected function getFormActions(): array
    {
        return [
            /*   ...parent::getFormActions(), */
            Action::make('save')
                ->label('Guardar cambios')
                ->icon('fas-save')
                ->action('save'),
            Action::make('cancel')
                ->label('Cancelar')
                ->icon('tabler-cancel')
                ->action('saveAndClose')->color('gray'),
        ];
    }

    public function saveAndClose(): void
    {
        $this->redirect($this->previousUrl);
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
