<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UseProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        "application_id",
        "program_id"
    ];
}
