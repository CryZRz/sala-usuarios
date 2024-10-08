<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Period extends Model{
    use HasFactory;

    protected $fillable = [
        "name"
    ];

    public static function getLastPeriod()
    {
        return self::latest()->first();
    }
}
