<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "description",
    ];

    public function permissions(){
        return $this->belongsToMany(Permission::class, "permission_role", "role_id", "permission_id");
    }

    //Accessors
    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->format('d/m/y');
    }

    public function getUpdatedAtAttribute($value){
        return Carbon::parse($value)->format('d/m/y');
    }

    public function getAllPermissionsAndDependencies()
    {
        $sql = DB::select("
        WITH RECURSIVE role_dependencies AS (
            SELECT rp.permission_id AS current_id
            FROM permission_role rp
            WHERE rp.role_id = :role_id

            UNION

            SELECT pd.depends_on_permission_id AS current_id
            FROM role_dependencies rd
            JOIN permission_dependencies pd
              ON pd.permission_id = rd.current_id
        )
        SELECT DISTINCT current_id
        FROM role_dependencies
    ", [
            'role_id' => $this->id
        ]);

        return self::hydrate($sql);
    }

    public function getAllPermissionsAndDependenciesExcept($excludePermissionId)
    {
        $sql = DB::select("
            WITH RECURSIVE role_dependencies AS (
                SELECT rp.permission_id AS current_id
                FROM permission_role rp
                WHERE rp.role_id = :role_id
                  AND rp.permission_id != :exclude_id

                UNION

                SELECT pd.depends_on_permission_id AS current_id
                FROM role_dependencies rd
                JOIN permission_dependencies pd
                  ON pd.permission_id = rd.current_id
            )
            SELECT DISTINCT current_id
            FROM role_dependencies
        ", [
            'role_id' => $this->id,
            'exclude_id' => $excludePermissionId
        ]);

        return self::hydrate($sql);
    }
}
