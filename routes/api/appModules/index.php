<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppModuleController;

Route::prefix('api')->middleware("auth")->group(function () {
    Route::get('/appModules', [AppModuleController::class, 'show']);
});

