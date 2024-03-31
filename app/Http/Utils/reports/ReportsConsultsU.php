<?php

namespace App\Http\Utils\reports;

use App\Http\Utils\TimeFormatU;
use App\Models\Loan;

class ReportsConsultsU{

    public static function sumTimeEntitysArr(array $listEntity, string $key){
        return array_reduce($listEntity, fn($acum, $item) => $acum+=$item[$key], 0);
    }

    public static function getTotalTimeStudentsByCareerAndSemesterDeatil(
        int $semester, string $career, int $periodId
    )
    {
        return Loan::withTrashed()
            ->join("student_updates", "loans.student_update_id", "student_updates.id")
            ->where("semester", $semester)
            ->where("career", $career)
            ->where("student_updates.period_id", $periodId)
            ->get();
    }

    public static function getTotalTimeUseCareersByPeriod(int $periodId){
        return Loan::withTrashed()
            ->join("student_updates", "loans.student_update_id", "student_updates.id")
            ->selectRaw('
                    student_updates.career,
                    SUM(loans.timeAssigment) as totalTimeSeconds,
                    SEC_TO_TIME(SUM(loans.timeAssigment)) as totalTime
                    ')
            ->groupBy("student_updates.career", "student_updates.period_id")
            ->where("student_updates.period_id", $periodId)
            ->get();
    }

    public static function getTimeUseStudentByPeriodDetail(int $periodId, bool $grup = false){
        $data = Loan::withTrashed()
            ->join("student_updates", "loans.student_update_id", "student_updates.id")
            ->where("student_updates.period_id", $periodId)
            ->get();

        if ($grup){
            return $data->reduce(function ($acum, $data){
                $findDataInAcum = array_filter($acum, fn($item) => $item["career"] == $data->career);

                if (empty($findDataInAcum)){
                    $acum[] = ["career" => $data->career, "data" => [$data]];
                }else{
                    $key = key($findDataInAcum);
                    $acum[$key]["data"][] = $data;
                }

                return $acum;
            }, []);
        }

        return $data;
    }

    public static function getTimeUseComputerByCareer(int $periodId, bool $group = false){
        $listTimeUseComputerByCareer = Loan::withTrashed()
            ->join("student_updates", "loans.student_update_id", "student_updates.id")
            ->selectRaw('
                        student_updates.career,
                        loans.computer_id,
                        SUM(loans.timeAssigment) as totalTimeSeconds,
                        SEC_TO_TIME(SUM(loans.timeAssigment)) as totalTime
                        ')
            ->groupBy("loans.computer_id", "student_updates.career")
            ->where("student_updates.period_id", $periodId)
            ->get();

        if ($group){
            return $listTimeUseComputerByCareer->reduce(function ($acum, $report){

                $findInAcum = array_filter($acum, fn ($item) => $item["computerId"] == $report->computer_id);
                if (empty($findInAcum)){
                    $acum[] = [
                        "computerId" => $report->computer_id,
                        "careersUse" => [[
                            "career" => $report->career,
                            "timeUse" => $report->totalTime,
                            "timeUseInHours" => TimeFormatU::getHoursFromSeconds($report->totalTimeSeconds)
                                ->getTotalHoursDiff()
                        ]]
                    ];
                }else{
                    $key = key($findInAcum);
                    $acum[$key]["careersUse"][] = [
                        "career" => $report->career,
                        "timeUse" => $report->totalTime,
                        "timeUseInHours" => TimeFormatU::getHoursFromSeconds($report->totalTimeSeconds)
                            ->getTotalHoursDiff()
                    ];
                }

                return $acum;
            }, []);
        }

        return $listTimeUseComputerByCareer;
    }

    public static function getApplicationsMostUsedByCareer(int $periodId, bool $group = false){
        $listApplicationMostUsedByCareer = Loan::withTrashed()
            ->join("student_updates", "loans.student_update_id", "student_updates.id")
            ->selectRaw('student_updates.career, loans.application_id, COUNT(loans.application_id) as countUse')
            ->groupBy("loans.application_id", "student_updates.career")
            ->where("student_updates.period_id", $periodId)
            ->get();

        if ($group){
            return $listApplicationMostUsedByCareer->reduce(function ($acum, $report){
                $findInAcum = array_filter($acum, fn ($item) => $item["application"]["id"] == $report->application_id);

                if (empty($findInAcum)){
                    $acum[] = [
                        "application" => [
                            "id" => $report->application_id,
                            "value" => $report
                        ],
                        "careersUse" => [
                            [
                                "career" => $report->career,
                                "countUse" => $report->countUse,
                            ]
                        ]
                    ];
                }else{
                    $key = key($findInAcum);
                    $acum[$key]["careersUse"][] = [
                        "career" => $report->career,
                        "countUse" => $report->countUse,
                    ];
                }

                return $acum;
            }, []);
        }

        return $listApplicationMostUsedByCareer;
    }
}
