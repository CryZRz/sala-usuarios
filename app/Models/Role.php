<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "description",
        "created_by",
    ];

    public function permissions(){
        return $this->belongsToMany(Permission::class, "permission_role", "role_id", "permission_id");
    }
}
