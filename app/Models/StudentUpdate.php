<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentUpdate extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    protected $fillable = [
        "student_id",
        "career",
        "controlNumber",
        "semester",
        "period_id",
        "active",
    ];

    public function student(){
        return $this->belongsTo(Student::class);
    }

    public function period(){
        return $this->belongsTo(Period::class);
    }

    public static function getLastByControlNumber($controlNumber)
    {
        return self::where('controlNumber', $controlNumber)
            ->orderBy('created_at', 'desc')
            ->first();
    }

    public static function getByLastPeriod(){
        $lastPeriod = Period::getLastPeriod();

        return self::where("period_id", $lastPeriod->id);
    }
}
