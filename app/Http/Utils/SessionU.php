<?php

namespace App\Http\Utils;

use App\Models\Computer;
use App\Models\Loan;
use Carbon\Carbon;

class SessionU
{
    public static function getListComputersFree(){
        //Se necesita traer de las sesiones todas aquellas que aun no han terminado
        $loansInUse = Loan::whereNull("endTime")
            ->get()
            ->map(fn($query) => $query->computer_id);

        //Buscamos todas las computadoras que no esten en uso
        $computers = Computer::whereNotIn("id", $loansInUse)->get();

        return $computers;
    }

    public static function calculateEndTimeSession(Carbon $horaInicio, Carbon $timeAssigment)
    {
        $endTimeFormat = TimeFormatU::sumTimeToDate(
            $horaInicio,
            hours: $timeAssigment->format("H"),
            minutes: $timeAssigment->format("i")
        );

        return $endTimeFormat;
    }

    public static function calculateRemainingTime(Carbon $endTime)
    {
        $nowDate = Carbon::now();

        if ($endTime <= $nowDate) {
            $time = "00:00:00";
        } else {
            $time = TimeFormatU::subtractTimeToDate(
                $endTime,
                hours: $nowDate->format("H"),
                minutes: $nowDate->format("i")
            )->format("H:i:00");
        }
        return $time;
    }
}
