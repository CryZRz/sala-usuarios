<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get("/login", [LoginController::class, "show"]);
Route::post("/login", [LoginController::class, "store"])->name("login.store");

Route::get("/register", [RegisterController::class, "show"]);
Route::post("/register", [RegisterController::class, "store"])->name("register.store");
Route::delete("/login", [LoginController::class, "destroy"])->name("login.destroy");