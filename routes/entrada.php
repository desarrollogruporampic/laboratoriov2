<?php

use App\Http\Controllers\UnidadTransfusionalController;
use Illuminate\Support\Facades\Route;


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::prefix('unidad')->name('unidad.')
        ->group(function () {
            Route::controller(UnidadTransfusionalController::class)->group(function () {
                Route::get('generar-pdf/{record}', 'generarPDF')->name('unidad.generar-pdf'); // Incident Reports
            });
        });
});
