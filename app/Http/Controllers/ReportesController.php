<?php

namespace App\Http\Controllers;

use App\Http\Utils\reports\ReportsConsultsU;
use App\Http\Utils\TimeFormatU;
use App\Models\Period;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReportesController extends Controller{

    public function show(){
        //todo
        $periods = Period::all();

        $data = [
          "periods" => $periods
        ];

        return view("reportes.index", $data);
    }

    public function reportTotalTimeBySemesterAndCareerDetail(Request $request){
        $career = $request->get("career");
        $semester = intval($request->get("semester"));
        $periodId = intval($request->get("periodId"));

        $listReports = ReportsConsultsU::getTotalTimeStudentsByCareerAndSemesterDeatil(
            $semester,$career,$periodId
        );

        $sumTime =  $listReports->reduce(function ($acum, $item){
           $acum += TimeFormatU::diffSecondsInDates(
                            Carbon::parse("00:00:00"),
                            Carbon::parse($item->timeAssigment))
                            ->getTotalSecondsDiff();
           return $acum;
        }, 0);
        $period = Period::find($periodId);

        $data = [
          "listReports" => $listReports,
          "totalTime" => TimeFormatU::getHoursFromSeconds($sumTime)->formatHMS(),
          "career" => $career,
          "semester" => $semester,
          "period" => $period
        ];

        return view('reportes.reportesPdfViews.timeUse', $data);
    }

    public function reportTotalTimeByCareer(Request $request){
        $periodId = intval($request->get("periodId"));
        $listReports = ReportsConsultsU::getTotalTimeUseCareersByPeriod($periodId);

        $sumTime = ReportsConsultsU::sumTimeEntitysArr($listReports->toArray(), "totalTimeSeconds");
        $labels = $listReports->map(fn ($item) => $item->career);
        $dataLabels = $listReports->map(fn ($item) => TimeFormatU::getHoursFromSeconds($item->totalTimeSeconds)
                                                        ->getTotalHoursDiff());
        $period = Period::find($periodId);

        $data = [
            "listReports" => $listReports,
            "sumTotalTime" => TimeFormatU::getHoursFromSeconds($sumTime)->formatHMS(),
            "dataJs" => [
                "labels" => $labels,
                "data" => $dataLabels,
            ],
            "period" => $period
        ];

        return view("reportes.reportesPdfViews.totalTimeCareer", $data);
    }

    public function reportTotalTimeByCareerDetail(Request $request){
        $periodId = intval($request->get("periodId"));
        $listReports = ReportsConsultsU::getTotalTimeUseCareersByPeriod($periodId);
        $studentsReport = ReportsConsultsU::getTimeUseStudentByPeriodDetail($periodId, true);

        $sumTime = ReportsConsultsU::sumTimeEntitysArr($listReports->toArray(), "totalTimeSeconds");
        $labels = $listReports->map(fn ($item) => $item->career);
        $dataLabels = $listReports->map(fn ($item) => TimeFormatU::getHoursFromSeconds($item->totalTimeSeconds)
                                                        ->getTotalHoursDiff());
        $period = Period::find($periodId);

        $data = [
            "listReports" => $listReports,
            "sumTotalTime" => TimeFormatU::getHoursFromSeconds($sumTime)->formatHMS(),
            "dataJs" => [
                "labels" => $labels,
                "data" => $dataLabels,
            ],
            "studentsReport" => $studentsReport,
            "period" => $period
        ];

        return view("reportes.reportesPdfViews.totalTimeCareer", $data);
    }

    public function reportApplicationsComputerByCareer(Request $request){
        $periodId = intval($request->get("periodId"));
        $listTimeUseComputerPerCareer = ReportsConsultsU::getTimeUseComputerByCareer($periodId, true);
        $period = Period::find($periodId);

        $data = [
          "listReports" => $listTimeUseComputerPerCareer,
          "period" => $period
        ];

        return view("reportes.reportesPdfViews.totalTimeUseComputer", $data);
    }

    public function reportApplicationMostUsedByCareer(Request $request){
        $periodId = intval($request->get("periodId"));
        $listApplicationMostUsedByCareer = ReportsConsultsU::getApplicationsMostUsedByCareer($periodId, true);
        $period = Period::find($periodId);

        $data = [
            "listReports" => $listApplicationMostUsedByCareer,
            "period" => $period
        ];

        return view("reportes.reportesPdfViews.countApplicationByCareer", $data);
    }
}
