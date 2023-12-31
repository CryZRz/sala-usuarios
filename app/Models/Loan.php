<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        "student_id",
        "computer_id",
        "application_id",
        "status",
        "timeAssigment",
        "startTime",
        "endTime",
    ];
}
