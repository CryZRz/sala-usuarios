<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Loan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "student_id",
        "computer_id",
        "application_id", 
        "timeAssigment"
    ];

    /**
     * Personalización de los nombres al insertar tuplas y hacer borrado suave: 
     */ 
    protected $dateFormat = "Y/m/d H:i:s";
    public const CREATED_AT = 'startTime';
    public const UPDATED_AT = 'updateTime';
    public const DELETED_AT = "endTime";
}
