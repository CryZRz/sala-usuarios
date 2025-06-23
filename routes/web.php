<?php

use App\Models\Period;
use Illuminate\Support\Facades\Route;

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
