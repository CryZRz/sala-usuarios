<?php

use App\Http\Controllers\PeriodsController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth")->group(function () {
    Route::get("/periods", [PeriodsController::class, "index"])
        ->name("periods.index");

    Route::get("/period/{period}", [PeriodsController::class, "getById"])
        ->name("period.findById");
});
