<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortController;

Route::prefix("api")
    ->middleware("auth")
    ->group(function () {
    Route::post("/puerto/{port}", [PortController::class, "update"])
        ->middleware("hasPermission:update");
    Route::delete("/puerto/{port}", [PortController::class, "destroy"])
        ->middleware("hasPermission:delete");
});
