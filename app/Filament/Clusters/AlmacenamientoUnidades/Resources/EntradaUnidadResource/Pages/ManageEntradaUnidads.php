<?php

namespace App\Filament\Clusters\AlmacenamientoUnidades\Resources\EntradaUnidadResource\Pages;

use App\Filament\Clusters\AlmacenamientoUnidades\Resources\EntradaUnidadResource;
use App\Models\Fenotipo;
use App\Models\TipoRh;
use App\Models\UnidadTransfusional;
use App\Models\UnidadTransfusionalFenotipo;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Enums\MaxWidth;
use Guava\FilamentDrafts\Admin\Resources\Concerns\Draftable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ManageEntradaUnidads extends ManageRecords
{
    use Draftable;


    public ?array $data = [];
    protected static string $resource = EntradaUnidadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->using(function (array $data, string $model): UnidadTransfusional {
                    return $this->create($data);
                })
                ->successNotification(null)
                ->modalWidth(MaxWidth::Screen),
        ];
    }

    public static function getRelations(): array
    {
        return [
            /*    RelationManagers\PostsRelationManager::class, */];
    }

    public function create($form): UnidadTransfusional
    {
        Log::info('HOLA');


        $nombreFenotipo = null;
        $unidad = null;
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
                        'id_unidad_transfusional' => $unidad->id_unidad_transfusional,
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

        return $unidad;
    }
}
