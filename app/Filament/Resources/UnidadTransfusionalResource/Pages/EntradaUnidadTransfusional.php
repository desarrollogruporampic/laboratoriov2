<?php

namespace App\Filament\Resources\UnidadTransfusionalResource\Pages;

use App\Filament\Resources\UnidadTransfusionalResource;
use App\Models\BodegaAlmacen;
use App\Models\GrupoSanguineo;
use App\Models\TipoHemocomponente;
use App\Models\TipoRh;
use App\Models\UnidadTransfusional;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction as ActionsEditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Table;
use Filament\Tables\Contracts\HasTable;
use Guava\FilamentDrafts\Admin\Resources\Concerns\Draftable;
use Illuminate\Support\Facades\Log;

class EntradaUnidadTransfusional extends Page implements HasTable
{

    use Draftable;
    use InteractsWithTable;
    public ?array $data = [];
    protected static string $resource = UnidadTransfusionalResource::class;

    protected static string $view = 'filament.resources.unidad-transfusional-resource.pages.entrada-unidad-transfusional';


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
                            ->required(),
                        DateTimePicker::make('fecha_donacion')
                            ->label('Fecha de donación')
                            ->required(),
                        DateTimePicker::make('fecha_caducidad')
                            ->label('Fecha de caducidad')
                            ->required(),
                        Select::make('grupo_sanguineo_fk')
                            ->label('Grupo sanguineo')
                            ->options(fn() => GrupoSanguineo::all()->pluck('nombre_grupo_sanguineo', 'id_grupo_sanguineo'))
                            ->searchable(true)
                            ->required(),
                        Select::make('tipo_rh_fk')
                            ->label('Tipo Rh')
                            ->options(fn() => TipoRh::all()->pluck('nombre_tipo_rh', 'id_tipo_rh'))
                            ->searchable(true)
                            ->searchDebounce(debounce: 200)
                            ->required(),
                        Select::make('bodega_fk')
                            ->label('Bodega')
                            ->options(fn() => BodegaAlmacen::where('IS_DELETE', 0)->where('EMPRESA', 1)->pluck('nombre_bodega_almacen', 'id_bodega_almacen'))
                            ->searchable(true)
                            ->searchDebounce(debounce: 200)
                            ->required(),
                        Builder::make('Fenotipos')
                            ->blocks([
                                Block::make('')
                                    ->schema([
                                        TextInput::make('')
                                            ->label('Heading')
                                            ->required(),
                                        Select::make('level')
                                            ->options([
                                                'h1' => 'Heading 1',
                                                'h2' => 'Heading 2',
                                                'h3' => 'Heading 3',
                                                'h4' => 'Heading 4',
                                                'h5' => 'Heading 5',
                                                'h6' => 'Heading 6',
                                            ])
                                            ->required(),
                                    ]),
                            ])


                    ])
            ])->statePath('data');
    }


    public function create()
    {

        Log::info($this->form->getState());

        UnidadTransfusional::createDraft($this->form->getState());
        $this->form->fill();

        Notification::make()
            ->title('Unidad transfusional agregada')
            ->success()
            ->send();
    }
    public function table(Table $table): Table
    {
        return $table
            ->query(UnidadTransfusional::query()->where('IS_DELETE', 0)->withDrafts())
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
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionsEditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
