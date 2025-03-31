<?php

use App\Http\Controllers\UnidadTransfusionalController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('entrada')->name('entrada.')
        ->group(function () {
            Route::controller(UnidadTransfusionalController::class)->group(function () {
                Route::get('generar-bitacora-entrada-pdf/{record}', 'generarPDF')->name('bitacora.generar-pdf'); // Incident Reports
            });
        });
});
