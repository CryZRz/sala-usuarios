<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportesController;

Route::middleware("auth")->group(function () {
    Route::get("/reportes", [ReportesController::class, "show"])->name("reports.show");

    Route::get("/reporte1", [ReportesController::class, "reportTotalTimeBySemesterAndCareerDetail"])
        ->name("report1");

    Route::get("/reporte2", [ReportesController::class, "reportTotalTimeByCareer"])
        ->name("report2");

    Route::get("/reporte3", [ReportesController::class, "reportTotalTimeByCareerDetail"])
        ->name("report3");

    Route::get("/reporte4", [ReportesController::class, "reportApplicationsComputerByCareer"])
        ->name("report4");

    Route::get("/reporte5", [ReportesController::class, "reportApplicationMostUsedByCareer"])
        ->name("report5");
});
