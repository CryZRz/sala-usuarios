<?php

use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\NotiTecController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route("dashboard.show");
})->middleware("auth");

Route::get("/dashboard", [DashboardController::class, "index"])
    ->middleware("auth")
    ->name("dashboard.show");

Route::resource("/api/notitec", NotitecController::class);

Route::get("/herramientas", fn() => view("utils.show"))
    ->middleware("auth")
    ->name("utils.index");

Route::get("/sinPermisos", fn() => view("alerts.notPermissions"))->name("notPermissions");
Route::get("/sinModulo", fn() => view("alerts.notModule"))->name("notModule");

require __DIR__ . "/programs/index.php";
require __DIR__ . "/computer/index.php";
require __DIR__ . "/student/index.php";
require __DIR__ . "/session/index.php";
require __DIR__ . "/incidences/index.php";
require __DIR__ . "/auth/index.php";
require __DIR__ . "/reports/index.php";
require __DIR__ . "/import/index.php";
require __DIR__ . "/uses/index.php";
require __DIR__ . "/tokens/index.php";
require __DIR__ . "/profile/index.php";
require __DIR__ . "/profile/index.php";
require __DIR__ . "/roleManager/index.php";
require __DIR__ . "/users/index.php";


require __DIR__ . "/api/ports/index.php";
require __DIR__ . "/api/session/index.php";
require __DIR__ . "/api/periods/index.php";
require __DIR__ . "/api/programs/index.php";
require __DIR__ . "/api/appModules/index.php";
require __DIR__ . "/api/permissions/index.php";
require __DIR__ . "/api/roleManager/index.php";
require __DIR__ . "/api/tokens/index.php";
