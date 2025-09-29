<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;

Route::middleware("auth")->group(function () {
   Route::get("/usuarios", [UsersController::class, "show"])
       ->middleware("hasPermission:view")
        ->name("users.show");
});
