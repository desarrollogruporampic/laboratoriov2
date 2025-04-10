<?php

namespace App\Filament\Clusters\AlmacenamientoUnidades\Resources\TrazabilidadUnidadResource\Widgets;

use App\Enums\TipoAccion;
use App\Http\Controllers\UnidadTransfusionalController;
use App\Models\EntradaUnidad;
use App\Models\TipoHemocomponente;
use App\Models\UnidadTransfusional;
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
use Filament\Infolists\Components\IconEntry\IconEntrySize;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Widgets\Widget;
use Guava\FilamentDrafts\Admin\Resources\Concerns\Draftable;
use Illuminate\Support\Facades\Log;
use JaOcero\ActivityTimeline\Components\ActivityDate;
use JaOcero\ActivityTimeline\Components\ActivityDescription;
use JaOcero\ActivityTimeline\Components\ActivityIcon;
use JaOcero\ActivityTimeline\Components\ActivitySection;
use JaOcero\ActivityTimeline\Components\ActivityTitle;
use JaOcero\ActivityTimeline\Enums\IconAnimation;

class SearchUnidadWidget extends Widget implements HasForms

{
    use InteractsWithForms;
    use Draftable;

    public ?array $data = [];
    protected static string $view = 'filament.clusters.almacenamiento-unidades.resources.trazabilidad-unidad-resource.widgets.search-unidad-widget';

    protected int | string | array $columnSpan = 'full';

    protected static bool $isLazy = false;

    protected static ?string $pollingInterval = null;


    public ?UnidadTransfusional $hemocomponente = null;

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
                            ->options(fn() => TipoHemocomponente::all()->pluck('nombre_tipo_hemocomponente', 'id'))
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

                    ])
            ])->statePath('data');
    }

    public function buscarHemocomponente(): void
    {
        $codigo = $this->data['numero_componente'] ?? null;
        $this->hemocomponente = UnidadTransfusional::with('bitacora', 'tipohemocomponente')->where('numero_componente', $codigo)->first();
    }

    public function infolist(Infolist $infolist): ?Infolist
    {
        if (!$this->hemocomponente) {
            return null;
        }
        Log::info($this->hemocomponente);
        return $infolist
            ->record($this->hemocomponente)
            ->schema([
                ActivitySection::make('bitacora')
                    ->label(fn() => $this->hemocomponente->tipohemocomponente->nombre_tipo_hemocomponente)
                    ->description('These are the activities that have been recorded.')
                    ->schema([
                        ActivityTitle::make('nombre_bitacora')
                            ->placeholder('No title is set')
                            ->allowHtml(), // Be aware that you will need to ensure that the HTML is safe to render, otherwise your application will be vulnerable to XSS attacks.
                        ActivityDescription::make('comentario')
                            ->placeholder('No description is set')
                            ->allowHtml(),
                        ActivityDate::make('created_at')
                            ->date('F j, Y', 'American/Costa_Rica')
                            ->placeholder('No date is set.'),
                        ActivityIcon::make('tipo_bitacora')
                            /*
                            You can animate icon with ->animation() method.
                            Possible values : IconAnimation::Ping, IconAnimation::Pulse, IconAnimation::Bounce, IconAnimation::Spin or a Closure
                         */
                            ->animation(IconAnimation::Bounce)

                    ])
                    /*  ->showItemsCount(10) // Show up to 2 items
                    ->showItemsLabel('Ver') // Show "View Old" as link label
                    ->showItemsIcon('heroicon-m-chevron-down') // Show button icon
                    ->showItemsColor('gray') // Show button color and it supports all colors */

                    ->aside(true)
                    ->headingVisible(true) // make heading visible or not
                    ->extraAttributes(['class' => 'my-new-class']) // add extra class
            ]);
    }

    protected function getViewData(): array
    {
        return [
            'hemocomponente' => $this->hemocomponente,
            'infolist' => $this->infolist(app(Infolist::class)),
        ];
    }
}
