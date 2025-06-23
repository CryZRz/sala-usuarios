<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "name",
        "lastName",
        "curp",
        "uuid",
    ];

    public static function getByUUid($uuid)
    {
        return self::where("uuid", $uuid)->first();
    }

    public function studentUpdates(){
        return $this->hasMany(StudentUpdate::class);
    }

    public function latestStudentUpdate()
    {
        return $this->hasOne(StudentUpdate::class)
            ->latest('created_at');
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
}
