<?php

namespace App\Filament\Resources\SalidaUnidadResource\Pages;

use App\Filament\Resources\SalidaUnidadResource;
use App\Http\Controllers\UnidadTransfusionalController;
use App\Models\BitacoraUnidad;
use App\Models\TipoHemocomponente;
use App\Models\UnidadTransfusional;
use Carbon\Carbon;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Grid;
use Livewire\Component as Livewire;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;

use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Tables\Actions\Action as ActionButton;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Guava\FilamentDrafts\Admin\Resources\Concerns\Draftable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class SalidaUnidad extends Page implements HasTable
{
    use Draftable;
    use InteractsWithTable;
    public ?array $data = [];
    protected static string $resource = SalidaUnidadResource::class;

    protected static string $view = 'filament.resources.salida-unidad-resource.pages.salida-unidad';

    protected static ?string $navigationLabel = 'Salida Unidad Transfusional';

    protected static ?string $navigationParentItem = 'Almacenamiento Unidades Transfusionales';

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()
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
                            ->prefixIcon('healthicons-f-blood-rh-p')
                            ->options(fn() => TipoHemocomponente::all()->pluck('nombre_tipo_hemocomponente', 'id_tipo_hemocomponente'))
                            ->searchable(true)
                            ->searchDebounce(debounce: 200)
                            ->required()
                            ->validationAttribute('Tipo Hemocomponente')
                            ->columnStart([
                                'sm' => 1,
                                'xl' => 1,
                                '2xl' => 1,
                            ])
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Get $get, Set $set, ?string $state) {

                                $result = UnidadTransfusionalController::searchNumberSerie($state, $get('numero_componente'));

                                return $set('verificar', $result);
                            }),

                        TextInput::make('numero_componente')
                            ->label('Número de serie')
                            ->placeholder('Escriba el número de serie')
                            ->required()
                            ->prefixIcon('tabler-droplet-search')
                            ->suffixIcon(function (Get $get) {
                                return match ($get('verificar')) {
                                    'error' => 'codicon-error',
                                    'success' => 'clarity-success-standard-line',
                                    default => 'bi-question-circle',
                                };
                            })
                            ->suffixIconColor(function (Get $get) {
                                return match ($get('verificar')) {
                                    'error' => 'danger',
                                    'success' => 'success',
                                    default => 'info',
                                };
                            })
                            ->hint(function (Get $get) {
                                return match ($get('verificar')) {
                                    'error' => 'Número de unidad no encontrada',
                                    'success' => 'Número de unidad encontrada',
                                    default => '',
                                };
                            })
                            ->hintColor(function (Get $get) {
                                return match ($get('verificar')) {
                                    'error' => 'danger',
                                    'success' => 'success',
                                    default => 'info',
                                };
                            })
                            ->prefixActions([])
                            ->reactive()
                            ->debounce(600)
                            ->afterStateUpdated(function (Get $get, Set $set, ?string $state) {

                                $result = UnidadTransfusionalController::searchNumberSerie($get('tipo_hemocomponente_fk'), $state);

                                return $set('verificar', $result);
                            }),
                        Textarea::make('comentario')
                            ->autosize()
                            ->minLength(10)
                            ->maxLength(1000)

                            ->columnSpan([
                                'default' => 2,
                                'sm' => 2,
                                'md' => 2,
                                'lg' => 2,
                                'xl' => 2,
                                '2xl' => 2,
                            ]),


                    ])
            ])->statePath('data');
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
                                function (Model $selectedRecord) {

                                    $selectedRecord->withoutRevision()->update([
                                        'is_published' => 1,
                                        'published_at' => Carbon::now()
                                    ]);
                                    $selectedRecord->unidadtransfusional()->update([
                                        'IS_DELETE' => 1,
                                    ]);
                                }
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
            ->query(BitacoraUnidad::query()->where('IS_DELETE', 0)->where('EMPRESA', 1)->onlyDrafts())
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
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('comentario')
                    ->label('Comentario')
                    ->sortable(true)
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->copyable()
                    ->copyMessage('Comentario copiado')
                    ->copyMessageDuration(1500),
            ])
            ->groups([
                Group::make('unidadtransfusional.tipohemocomponente.nombre_tipo_hemocomponente')
                    ->label('Tipo Hemocomponente'),
            ])
            ->defaultGroup('unidadtransfusional.tipohemocomponente.nombre_tipo_hemocomponente')
            ->groupingSettingsHidden()
            ->groupingDirectionSettingHidden()
            ->filters([
                //
            ])
            ->striped()
            ->paginated(false)
            ->poll('2s')
            /* ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]) */;
    }


    public function create()
    {

        $form = $this->form->getState();

        try {
            DB::beginTransaction();

            $unidad = UnidadTransfusional::where('tipo_hemocomponente_fk', $form['tipo_hemocomponente_fk'])->where('numero_componente', $form['numero_componente'])->first();

            BitacoraUnidad::createDraft([
                'unidad_transfusional_fk' =>  $unidad->id_unidad_transfusional,
                'comentario' => $form['comentario'],
                'user_genera' => Auth::id(),
                'EMPRESA' => 1,
            ]);


            DB::commit();

            $this->form->fill();

            Notification::make()
                ->title('Salida de Unidad transfusional exitosa')
                ->success()
                ->send();
        } catch (\Throwable $th) {
            DB::rollback();

            Notification::make()
                ->title('Error al intentar la salida de la unidad transfusional')
                ->warning()
                ->persistent()
                ->body($th->getMessage())
                ->send();
        }
    }
}
