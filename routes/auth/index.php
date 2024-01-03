<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::middleware("guest")->group(function(){
    Route::get("/login", [LoginController::class, "show"])->name("login.show");
    Route::post("/login", [LoginController::class, "store"])->name("login.store");
});


Route::middleware("auth")->group(function(){
    Route::get("/register", [RegisterController::class, "show"])->name("register.show");
    Route::post("/register", [RegisterController::class, "store"])->name("register.store");
    Route::delete("/login", [LoginController::class, "destroy"])->name("login.destroy");
});