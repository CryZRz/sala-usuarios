<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppModule extends Model
{
    use HasFactory;

    protected $table = "modules";

    protected $fillable = [
        "name",
        "description",
        "display_name",
    ];
}
