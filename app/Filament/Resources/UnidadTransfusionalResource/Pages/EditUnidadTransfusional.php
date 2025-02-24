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
use Filament\Actions;
use Filament\Actions\Action as ActionsAction;

use Filament\Resources\Pages\EditRecord;
use Guava\FilamentDrafts\Admin\Resources\Concerns\Draftable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;

class EditUnidadTransfusional extends EditRecord
{
    use Draftable;
    protected static string $resource = UnidadTransfusionalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
