<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    use HasFactory;

    protected $fillable = [
        "file_name",
        "hash_file",
        "period_id"
    ];

    public function period()
    {
        return $this->belongsTo(Period::class);
    }
}
