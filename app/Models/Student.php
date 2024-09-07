<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "lastName",
    ];

    public function studentUpdates(){
        return $this->hasMany(StudentUpdate::class);
    }

    public function latestStudentUpdate()
    {
        return $this->studentUpdates()->latest()->first();
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
