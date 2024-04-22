<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Incidence extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "student_update_id",
        "user_id",
        "descripción",
        "estatus"
    ];

    public function studentUpdate(){
        return $this->belongsTo(StudentUpdate::class);
    }
    public function owner(){
        return $this->belongsTo(User::class, "user_id", "id");
    }

    /**
     * Personalización de los nombres al insertar tuplas y hacer borrado suave:
     */
    protected $dateFormat = "Y/m/d H:i:s";
    public const CREATED_AT = 'fecha_alta';
    public const UPDATED_AT = 'fecha_actualización';
    public const DELETED_AT = "fecha_baja";
}