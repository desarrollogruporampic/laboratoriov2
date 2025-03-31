<?php

namespace App\Filament\Clusters\AlmacenamientoUnidades\Resources\TrazabilidadUnidadResource\Widgets;

use App\Http\Controllers\UnidadTransfusionalController;
use App\Models\TipoHemocomponente;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists\Components\TextEntry;
use Filament\Widgets\Widget;
use Guava\FilamentDrafts\Admin\Resources\Concerns\Draftable;

class SearchUnidadWidget extends Widget implements HasForms

{
    use InteractsWithForms;
    use Draftable;

    public ?array $data = [];
    protected static string $view = 'filament.clusters.almacenamiento-unidades.resources.trazabilidad-unidad-resource.widgets.search-unidad-widget';

    protected int | string | array $columnSpan = 'full';

    protected static bool $isLazy = false;

    protected static ?string $pollingInterval = null;

    /*     protected static ?string $navigationParentItem = 'Almacenamiento Unidades Transfusionales'; */

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
                                $set('unidad', $result['unidad']);

                                return $set('verificar', $result['state']);
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
                                $set('unidad', $result['unidad']);

                                return $set('verificar', $result['state']);
                            }),
                        Section::make(function (Get $get) {
                            if ($get('unidad')) {
                                return $get('unidad')->tipohemocomponente->nombre_tipo_hemocomponente;
                            } else {
                                return '';
                            }
                        })
                            ->description('Información de la busqueda')
                            ->icon('healthicons-f-blood-rh-p')
                            ->schema([])
                            ->visible(function (Get $get) {
                                return match ($get('verificar')) {
                                    'error' => false,
                                    'success' => true,
                                    default => false,
                                };
                            }),


                    ])
            ])->statePath('data');
    }
}
