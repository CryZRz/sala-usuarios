<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Utils\Students\StudentU;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "name",
        "lastName",
        "curp",
    ];

    public static function getByUUid($uuid)
    {
        return self::where("uuid", $uuid)->first();
    }

    public static function getByCurp($curp){
        return self::where("curp", $curp)->first();
    }

    public function studentUpdates(){
        return $this->hasMany(StudentUpdate::class);
    }

    public function latestStudentUpdate()
    {
        return $this->hasOne(StudentUpdate::class)->latestOfMany('created_at');
    }

    public function lastInfo(){
        return $this->latestStudentUpdate();
    }

    public static function withLastInfo(){
        return self::whereHas("lastInfo", function($query){
            return $query->where("period_id", "=", Period::getLastPeriod()->id);
        });
    }

    public static function wherePeriodInfo($periodId){
        return self::whereHas("lastInfo", function($query) use ($periodId){
            $query->where("period_id", "=", $periodId);
        });
    }

    //Accessors
    public function getFullNameAttribute()
    {
        return "{$this->name} {$this->lastName}";
    }

    public function getLastNameFirstAttribute()
    {
        return "{$this->lastName} {$this->name}";
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtoupper(StudentU::unaccentedText(trim($value)));
    }

    public function setLastNameAttribute($value)
    {
        $this->attributes['lastName'] = strtoupper(StudentU::unaccentedText(trim($value)));
    }
}
