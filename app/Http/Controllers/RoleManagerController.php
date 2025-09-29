<?php

namespace App\Http\Controllers;

use App\Http\Utils\Interfaces\HasModule;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleManagerController extends Controller implements HasModule
{

    public function hasModule(): string
    {
        return "roleManager";
    }

    public function show(Request $request){
        $find = $request->get("find");
        $query = Role::query();

        if ($find) {
            $query->where("name", "LIKE", "%$find%");
        }

        $roles = $query->paginate()->appends($request->query());

        $data = [
            "roles" => $roles
        ];

        return view('roleManager.show', $data);
    }

    public function create(){
        return view('roleManager.create');
    }

    public function store(Request $request){
        $this->validate($request, [
            "name" => "required",
            "description" => "required",
            "permissions" => "array",
            "permissions.*" => "integer|exists:permissions,id",
        ]);

        $permissions = $request->get("permissions");
        $name = $request->get("name");
        $description = $request->get("description");

        foreach ($permissions as $permission){
            $dependenciesRol = Permission::dependenciesIds($permission);

            if(!empty(array_diff($dependenciesRol->toArray(), $permissions))){
                return response()->json(["errors" => "falta depenedencia de permisos"], 403);
            }
        }

        $role = Role::create([
            "name" => $name,
            "description" => $description,
        ]);

        $role->permissions()->attach($permissions, ["created_by" => Auth::user()->id]);

        return response()->json(null, 203);
    }

    public function edit(Role $role){
        $data = [
            "role" => $role,
            "permissions" => $role->getAllPermissionsAndDependencies()->pluck("current_id")->toArray()
        ];

        return view('roleManager.edit', $data);
    }

    public function removePermission(Request $request, Role $role, Permission $permission){
        /*
         * Traemos todos los permisos y dependencias del rol
         * exeptuando las del permiso que querrmos quitar
        */
        $permissionsAndDependenciesRole = $role
                        ->getAllPermissionsAndDependenciesExcept($permission->id)
                        ->pluck('current_id')
                        ->toArray();

        /*
         * Traemos todos los permisos que dependen de este
         * */
        $dependentsPermission = Permission::getDependentsById($permission->id)
            ->pluck('id')
            ->toArray();

        foreach ($dependentsPermission as $dependentPermission){
            if (in_array($dependentPermission, $permissionsAndDependenciesRole)){
                return response()->json(
                    ["error" => "Otro permiso depende de este"],
                    409
                );
            }
        }

        /*
         * Traemos las dependecnias del permiso que queremos elimanr
         * */
        $dependenciesPermission = $permission->getWithDependencies()
            ->pluck("id")
            ->reject(fn($id) => $id == $permission->id)
            ->values()
            ->toArray();

        $permissionsToRemove = [];
        foreach ($dependenciesPermission as $dependencyPermission){
            //Si el permiso no esta en la lista de permisos y dependencias lo podemos borrar
            if (!in_array($dependencyPermission, $permissionsAndDependenciesRole)){
                $permissionsToRemove[] = $dependencyPermission;
            }
        }

        //nos agregamos asi mismos para eliminarnos también
        $permissionsToRemove[] = $permission->id;
        $role->permissions()->detach($permissionsToRemove);

        return response()->json([
            "blinzzia" => $permissionsToRemove,
        ]);
    }

    public function addPermission(Request $request, Role $role, Permission $permission){
        $dependencies = $permission->getWithDependenciesIds();
        $dependencies[] = $permission->id;

        $depToAdd = $dependencies->mapWithKeys(fn($dependency) => [
            $dependency => ["created_by" => Auth::id()]
        ]);

        $role->permissions()->syncWithoutDetaching($depToAdd);

        return response()->json([
            "blinzzia" => $dependencies,
        ], 202);
    }

    public function update(Request $request, Role $role){
        $this->validate($request, [
            "name" => ["required", "max:20"],
            "description" => ["required"],
        ]);

        $role->update([
            "name" => $request->get("name"),
            "description" => $request->get("description"),
        ]);

        return redirect()->route("roleManager.show");
    }

    public function index(Request $request,User $user){
        $find = $request->get("find");
        $userRoles = $user->roles()->pluck("roles.id")->toArray();

        $query = Role::query();

        $query->wherenotIn("id", $userRoles);

        if ($find){
            $query->where("name", "like", "%$find%");
        }

        $roles = $query->paginate(5);

        return response()->json($roles);
    }

    public function showApi(Request $request){
        $find = $request->get("find");
        $query = Role::query();

        if ($find) {
            $query->where("name", "LIKE", "%$find%");
        }

        $roles = $query->paginate()->appends($request->query());

        return response()->json($roles);
    }
}
