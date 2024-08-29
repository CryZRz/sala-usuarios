<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentUpdate extends Model
{
    use HasFactory;

    const UPDATED_AT = null; //No incluir columna de tiempo de última actualización.

    protected $fillable = [
        "student_id",
        "career",
        "controlNumber",
        "semester",
        "period_id"
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
}
