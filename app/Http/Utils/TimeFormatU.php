<?php

namespace App\Http\Utils;

use Carbon\Carbon;

class TimeFormatU{

    private Carbon $initialDate;
    private Carbon $finalDate;
    private float $totalHoursDiff;
    private float $totalMinutesDiff;
    private float $totalSecondsDiff;

    public static function stringToTime(String $time): Carbon{
        return new Carbon($time);
    }

    public static function sumTimeToDate(Carbon $date, int $hours = 0, int $minutes = 0, int $seconds = 0): Carbon
    {
        $sumTimeDate = $date->copy();
        $sumTimeDate->addHours($hours);
        $sumTimeDate->addMinutes($minutes);
        $sumTimeDate->addSeconds($seconds);

        return $sumTimeDate;
    }

    public static function subtractTimeToDate(Carbon $date, int $hours = 0, int $minutes = 0, int $seconds = 0){
        $subTimeDate = $date->copy();
        $subTimeDate->subHours($hours);
        $subTimeDate->subMinutes($minutes);
        $subTimeDate->subSeconds($seconds);

        return $subTimeDate;
    }

    public static function diffMinutesInDates(Carbon $dateMain, Carbon $dateDiff){
        $instance = new self();
        $instance->initialDate = $dateMain;
        $instance->finalDate = $dateDiff;
        $instance->totalMinutesDiff = $dateMain->floatDiffInMinutes($dateDiff);
        return $instance;
    }

    public static function diffHoursInDates(Carbon $dateMain, Carbon $dateDiff){
        $instance = new self();
        $instance->initialDate = $dateMain;
        $instance->finalDate = $dateDiff;
        $instance->totalHoursDiff = $dateMain->floatDiffInHours($dateDiff);
        return $instance;
    }

    public static function diffSecondsInDates(Carbon $dateMain, Carbon $dateDiff){
        $instance = new self();
        $instance->initialDate = $dateMain;
        $instance->finalDate = $dateDiff;
        $instance->totalSecondsDiff = $dateMain->floatDiffInSeconds($dateDiff);
        return $instance;
    }

    public static function getHoursFromSeconds(int $seconds){
        $dateMain = Carbon::parse("00:00:00");
        $dateDiff = Carbon::parse("00:00:00")->addSeconds($seconds);
        return self::diffHoursInDates($dateMain, $dateDiff);
    }

    public static function getMinutesFromSeconds(int $seconds){
        $dateMain = Carbon::parse("00:00:00");
        $dateDiff = Carbon::parse("00:00:00")->addSeconds($seconds);
        return self::diffMinutesInDates($dateMain, $dateDiff);
    }

    public function formatHMS(){
        $diff = $this->initialDate->diff($this->finalDate);

        $totalHours = $diff->days * 24 + $diff->h;
        $minutes = $diff->i;
        $seconds = $diff->s;

        return sprintf('%02d:%02d:%02d', $totalHours, $minutes, $seconds);
    }

    public function getInitialDate(): Carbon
    {
        return $this->initialDate;
    }

    public function getFinalDate(): Carbon
    {
        return $this->finalDate;
    }

    public function getTotalHoursDiff(): float
    {
        return $this->totalHoursDiff;
    }

    public function getTotalMinutesDiff(): float
    {
        return $this->totalMinutesDiff;
    }

    public function getTotalSecondsDiff(): float
    {
        return $this->totalSecondsDiff;
    }
}
