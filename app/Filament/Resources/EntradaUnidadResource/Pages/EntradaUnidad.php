<?php

namespace App\Filament\Resources\EntradaUnidadResource\Pages;

use App\Filament\Resources\EntradaUnidadResource;
use App\Models\EntradaUnidad as ModelsEntradaUnidad;
use App\Models\UnidadTransfusional;
use Filament\Resources\Pages\Page;
use Filament\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class EntradaUnidad extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string $resource = EntradaUnidadResource::class;

    protected static string $view = 'filament.resources.entrada-unidad-resource.pages.entrada-unidad';


    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Select::make('tipo_hemocomponente_fk')
                            ->label('Tipo Hemocomponente')
                            ->relationship('tipohemocomponente', 'nombre_tipo_hemocomponente')
                            ->searchable(true)
                            ->searchDebounce(debounce: 200)
                            ->required(),
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
                            ->relationship('gruposanguineo', 'nombre_grupo_sanguineo')
                            ->searchable(true)
                            ->required(),
                        Select::make('tipo_rh_fk')
                            ->label('Tipo Rh')
                            ->relationship('tiporh', 'nombre_tipo_rh')
                            ->searchable(true)
                            ->searchDebounce(debounce: 200)
                            ->required(),
                        Radio::make('is_fenotipo')
                            ->label('Fenotipo ?')
                            ->boolean()
                            ->inline()
                            ->inlineLabel(false)
                    ])
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(ModelsEntradaUnidad::query())
            ->columns([
                TextColumn::make(name: 'tipo_hemocomponente_fk'),
                TextColumn::make(name: 'numero_componente'),
                TextColumn::make(name: 'fecha_donacion'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
