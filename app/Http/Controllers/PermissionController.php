<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function getByModuleId(int $module, Request $request){
        $find = $request->get("find");
        $query = Permission::query();

        $query->where("module_id", $module);

        if($find){
            $query->where("display_name", "like", "%$find%");
        }

        $permissions = $query->paginate(4);

        return response()->json($permissions);
    }

    public function getPermissionDependencies(Permission $permission){
        $dependencies = $permission->getWithDependencies();

        return response()->json($dependencies);
    }
}
