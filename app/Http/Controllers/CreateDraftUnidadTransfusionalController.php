<?php

namespace App\Http\Controllers;

use App\Models\UnidadTransfusional;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CreateDraftUnidadTransfusionalController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, UnidadTransfusional $unidadTransfisional)
    {
        Log::info($request);

        Log::info($unidadTransfisional);

        Notification::make()
            ->title('Unidad transfusional agregada')
            ->success()
            ->send();
    }
}
