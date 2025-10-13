<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "key",
    ];

    public static function getByKey($key){
        return self::where("key", $key)->first();
    }
}
