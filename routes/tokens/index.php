<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserTokenController;

Route::middleware(["auth"])->group(function () {
   Route::get("/tokens", [UserTokenController::class, "show"])
       ->name("tokens.show");
   Route::post("/obtener-token", [UserTokenController::class, "generateToken"])
       ->name("token.get");
});
