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
        return $this->belongsToMany(Program::class, "programs_computer", "computer_id", "program_id");
    }

    public function ports(){
        return $this->hasMany(Port::class);
    }

    public static function getByComputerNumber($computerNumber){
        return self::where("computer_number", $computerNumber)->first();
    }
}
