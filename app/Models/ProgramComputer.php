<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramComputer extends Model
{
    use HasFactory;

    protected $table = "programs_computer";

    protected $fillable = [
        "program_id",
        "computer_id"
    ];
    
    public function program() {
        return $this->belongsTo(Program::class);
    }
}
