<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingImport extends Model
{
    use HasFactory;

    protected $fillable = [
        "filename",
        "hash_file",
        "is_pending",
    ];

    public static function getLast(){
        return self::orderBy("id", "desc")->first();
    }
}
