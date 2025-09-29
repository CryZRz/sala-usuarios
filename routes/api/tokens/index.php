<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserTokenController;

Route::prefix('api')->group(function () {
   Route::middleware('auth')->group(function () {
        Route::get("/tokens", [UserTokenController::class, "showApi"])
        ->name("tokens.showApi");
   });

    Route::post("/generar-token", [UserTokenController::class, "generateToken"])
        ->name("token.generate");

    Route::delete("/eliminar-token/{uuid}", [UserTokenController::class, "deleteToken"])
        ->name("token.delete");
});
