<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use Illuminate\Support\Facades\Route;

Route::middleware("guest")->group(function(){
    Route::get("/login", [LoginController::class, "show"])->name("login.show");
    Route::post("/login", [LoginController::class, "store"])->name("login.store");
    Route::get("/recuperar-contraseña",[ForgotPasswordController::class, "show"])
    ->name("forgotPassword.show");
    Route::post("/recuperar-contraseña",[ForgotPasswordController::class, "store"])
    ->name("forgotPassword.store");
    Route::get("/restabler-contraseña/{token}", [ResetPasswordController::class, "show"])
    ->name("resetPassword.show");
    Route::post("/restabler-contraseña", [ResetPasswordController::class, "store"])
    ->name("resetPassword.store");
});


Route::middleware("auth")->group(function(){
    Route::get("/registro", [RegisterController::class, "show"])->name("register.show");
    Route::post("/registro", [RegisterController::class, "store"])->name("register.store");
    Route::delete("/login", [LoginController::class, "destroy"])->name("login.destroy");
    Route::delete("/logout", [LoginController::class, "logout"])->name("login.logout");
});
