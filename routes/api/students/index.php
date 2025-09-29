<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth:api")->group(function () {
    Route::get("/estudiantes/{period}", [StudentController::class, "getStudents"])
    ->middleware("hasPermission:view");
});
