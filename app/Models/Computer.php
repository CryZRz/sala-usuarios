<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Computer extends Model
{
    use HasFactory;

    protected $table = "computers";

    protected $fillable = [
        "ram",
        "cpu",
        "computer_number"
    ];

    public function programs() {
        return $this->hasMany(ProgramComputer::class);
    }

    public function ports(){
        return $this->hasMany(Port::class);
    }
}
