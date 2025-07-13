<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "description",
        "created_by",
    ];

    public function roles(){
        return $this->belongsToMany(Role::class, "permision_role", "role_id", "permission_id");
    }
}
