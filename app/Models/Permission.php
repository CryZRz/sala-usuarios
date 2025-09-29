<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "description",
        "created_by",
        "display_name",
        "module_id",
    ];

    public function roles(){
        return $this->belongsToMany(Role::class, "permision_role", "role_id", "permission_id");
    }

    public static function getWithDependenciesById($id){
        $sql = "
            WITH RECURSIVE permission_tree AS (
                SELECT depends_on_permission_id AS id
                FROM permission_dependencies
                WHERE permission_id = ?

                UNION

                SELECT pd.depends_on_permission_id AS id
                FROM permission_dependencies pd
                INNER JOIN permission_tree pt ON pt.id = pd.permission_id
            )
            SELECT p.*
            FROM permissions p
            JOIN permission_tree pt ON p.id = pt.id
        ";

        return self::hydrate(DB::select($sql, [$id]));
    }

    public static function getDependentsById($id) {
        $sql = "
        WITH RECURSIVE dependents_tree AS (
            SELECT permission_id AS id
            FROM permission_dependencies
            WHERE depends_on_permission_id = ?

            UNION

            SELECT pd.permission_id AS id
            FROM permission_dependencies pd
            INNER JOIN dependents_tree dt ON dt.id = pd.depends_on_permission_id
        )
        SELECT p.*
        FROM permissions p
        JOIN dependents_tree dt ON p.id = dt.id
    ";

        return self::hydrate(DB::select($sql, [$id]));
    }

    public function getWithDependencies(){
        return self::getWithDependenciesById($this->id);
    }

    public static function dependenciesIds($permissionId){
        return self::getWithDependenciesById($permissionId)->pluck("id");
    }

    public function getWithDependenciesIds(){
        return self::dependenciesIds($this->id);
    }

}
