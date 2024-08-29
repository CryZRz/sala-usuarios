<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Incidence extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "student_update_id",
        "created_by",
        "description",
        "status"
    ];

    public function studentUpdate(){
        return $this->belongsTo(StudentUpdate::class);
    }
    public function owner(){
        return $this->belongsTo(User::class, "created_by", "id");
    }


    //Accessors
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/y H:i');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/y H:i');
    }

    public function getStatusTextAttribute()
    {
        if ($this->status){
            return "Resuelta";
        }

        return "Pendiente";
    }
}
