<?php

namespace App\Http\Controllers;

use App\Http\Utils\Interfaces\HasModule;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;

class ProfileController extends Controller implements HasModule
{

    public function __construct(){
        View::share('module', $this->hasModule());
    }

    public function hasModule(): string
    {
        return 'users';
    }

    public function show(){
        $data = [
            "user" => Auth::user(),
        ];

        return view("profile.show", $data);
    }

    public function showOne(User $user){
        $data = [
            "user" => $user,
        ];

        return view("profile.show", $data);
    }

    public function changePassword(User $user){
        $data = [
            "user" => $user,
        ];

        return view("profile.changePassword", $data);
    }

    public function storePassword(Request $request, User $user){
        $this->validate($request, [
            "password" => ["required", "min:8", "confirmed"],
            "currentPassword" => ["nullable", "string"],
        ]);

        if (Auth::user()->id === $user->id){
            $tempPassword = Hash::make($request->get("currentPassword"));
            if (Auth::user()->password === $tempPassword){
                Auth::user()->update([
                    "password" => $tempPassword
                ]);
            }else{
                return redirect()->route("profile.changePassword", $user->id)
                    ->with("error", "Contraseña incorrecta");
            }
        }else{
            $user->update([
                "password" => $request->get("password")
            ]);
        }

        return redirect()->route("profile.show", $user->id)
            ->with("success", "Contraseña actualizada correctamente.");
    }

    public function  editRoles(Request $request, User $user){
        $roles = $user->roles;

        $data = [
            "user" => $user,
            "roles" => $roles
        ];

        return view("profile.editRoles", $data);
    }

    public function addRoles(Request $request, User $user){
        $this->validate($request, [
            "roles" => ["required", "array"],
            "roles.*" => ["required", "exists:roles,id"],
        ]);

        $roles = $request->get("roles");

        $rolesToAdd = collect($roles)->mapWithKeys(function($role) {
           return [$role => ["created_by" => Auth::user()->id]];
        });

        $user->roles()->syncWithoutDetaching($rolesToAdd);

        return response(null, 203);
    }

    public function removeRole(Request $request, User $user, Role $role){
        if ($user->roles->count() === 1 && $user->roles()->first()->id === $role->id){
            return redirect()->route("profile.viewRoles", $user->id)
               ->with("error", "No puedes dejar un usuario sin roles");
        }

        $user->roles()->detach($role);
        return redirect()->route("profile.viewRoles", $user->id);
    }

    public function update(Request $request, User $user){
        $this->validate($request, [
            "name" => ["required", "string"],
            "lastName" => ["required", "string"],
            "username" => [
                "required",
                "string",
                Rule::unique("users", "username")->ignore($user->id)
            ],
            "email" => [
                "required",
                "string",
                "email",
                Rule::unique("users", "email")->ignore($user->id)],
        ]);

        $user->update([
            "name" => $request->get("name"),
            "last_name" => $request->get("lastName"),
            "username" => $request->get("username"),
            "email" => $request->get("email"),
        ]);

        return redirect()->route("profile.show", $user->id);
    }
}
