<?php

namespace App\Filament\Clusters\AlmacenamientoUnidades\Resources;

use App\Filament\Clusters\AlmacenamientoUnidades;
use App\Filament\Clusters\AlmacenamientoUnidades\Resources\SalidaUnidadResource\Pages;
use App\Http\Controllers\UnidadTransfusionalController;
use App\Models\BitacoraUnidad;
use App\Models\EntradaUnidad;
use App\Models\TipoHemocomponente;
use Carbon\Carbon;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Grouping\Group;

use Illuminate\Database\Eloquent\Model;

use Filament\Tables\Actions\Action as ActionButton;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Table;
use Guava\FilamentDrafts\Admin\Resources\Concerns\Draftable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class SalidaUnidadResource extends Resource
{
    use Draftable;
    use InteractsWithTable;

    protected static ?string $model = BitacoraUnidad::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = AlmacenamientoUnidades::class;

    protected static ?string $pluralLabel = 'Crear Salida';

    protected static ?string $label = 'Salida Unidades';

    protected static ?string $navigationGroup = 'Salida Unidades';

    /* protected static SubNavigationPosition $subNavigationPosition  = SubNavigationPosition::Top; */


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
                                'tipo_unidad' => 'salida'
                            ]);

                            $selectedRecords->each(function (Model $selectedRecord) use ($entrada) {
                                UnidadTransfusionalController::sacarEntradaUnidad($selectedRecord, $entrada);
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
            ->query(BitacoraUnidad::query()->with('unidadtransfusional')->where('IS_DELETE', 0)->where('EMPRESA', 1)->onlyDrafts())
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


    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSalidaUnidads::route('/'),
        ];
    }
}
