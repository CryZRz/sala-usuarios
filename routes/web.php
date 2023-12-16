<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ComputerController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\StudentController;
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

Route::get("/programas", [ProgramController::class, "show"])->name("program.show");
Route::get("/programa", [ProgramController::class, "create"])->name("program.create");
Route::post("/programa", [ProgramController::class, "store"])->name("program.store");
Route::get("/programa/{program}", [ProgramController::class, "edit"])->name("program.edit");
Route::put("/programa", [ProgramController::class, "update"])->name("program.update");

Route::get("/equipos", [ComputerController::class, "show"])->name("equiment.show");
Route::get("/equipo", [ComputerController::class, "create"])->name("Computer.create");
Route::post("/equipo", [ComputerController::class, "store"])->name("Computer.store");
Route::get("/equipo/{computer}", [ComputerController::class, "edit"])->name("Computer.edit");
Route::delete("/equipo-programa/{id}", [ComputerController::class, "removePorgram"]);
Route::post("/equipo-puerto/{id}", [ComputerController::class, "updatePort"]);
Route::delete("/equipo-puerto/{id}", [ComputerController::class, "removePort"]);
Route::delete("/equipo/{computer}", [ComputerController::class, "destroy"])->name("Computer.edit");
Route::post("/equipo/{computer}", [ComputerController::class, "update"])->name("Computer.update");

Route::get("/estudiantes", [StudentController::class, "showAll"])->name("student.store");
Route::get("/estudiante", [StudentController::class, "show"])->name("student.show");
Route::post("/estudiante", [StudentController::class, "store"])->name("student.store");
Route::get("/estudiante/{student}", [StudentController::class, "edit"])->name("student.edit");
Route::post("/estudiante/{student}", [StudentController::class, "update"])->name("student.update");
Route::delete("/estudiante/{student}", [StudentController::class, "destroy"])->name("student.destroy");