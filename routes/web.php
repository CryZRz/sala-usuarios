<?php

use App\Models\Period;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\StudentUpdateResource;
use App\Models\StudentUpdate;

Route::get('/', function () {
    return redirect()->route("login.show");
})->middleware("guest");

Route::get('/test', function () {
    $lastPeriod = Period::getLastPeriod();

    $bajas = \App\Models\Student::whereHas("latestStudentUpdate",
        function($query) use ($lastPeriod) {
        return $query->where("period_id", "!=", $lastPeriod->id);
    })->get();

    dd($bajas->map(fn ($baja) => $baja->latestStudentUpdate->controlNumber));
});

require __DIR__ . "/programs/index.php";
require __DIR__ . "/computer/index.php";
require __DIR__ . "/student/index.php";
require __DIR__ . "/session/index.php";
require __DIR__ . "/incidences/index.php";
require __DIR__ . "/auth/index.php";
require __DIR__ . "/reports/index.php";
require __DIR__ . "/import/index.php";
require __DIR__ . "/uses/index.php";
require __DIR__ . "/api/ports/index.php";
require __DIR__ . "/api/session/index.php";
require __DIR__ . "/tokens/index.php";
