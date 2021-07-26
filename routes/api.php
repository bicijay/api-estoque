<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\TitulosController;
use \App\Http\Controllers\ImportacaoCNABController;


Route::prefix("titulos")->group(function () {
    Route::get("/", [TitulosController::class, 'search']);
    Route::get("/{uid}", [TitulosController::class, 'get']);
});


Route::prefix("importacao")->group(function () {
    Route::post("cnab", [ImportacaoCNABController::class, 'import']);
});
