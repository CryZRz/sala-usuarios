<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{

    public function show() {
        return view("auth.register");
    }

    public function store(RegisterRequest $request) {
        $data = $request->validated();

        $user = User::create([
            "username" => trim($data["username"]),
            "name" => strtoupper(trim($data["name"])),
            "last_name" => strtoupper(trim($data["lastName"])),
            "email" => trim($data["email"]),
            "password" => trim($data["pass"])
        ]);
        if ($user != null) {
            $user->roles()->attach($data["roleId"], ["created_by" => Auth::user()->id]);
            return redirect()->route("session.show");
        }
        return redirect()
                ->route("register.show")
                ->with("errors", "Ocurrió un error al intentar registrarse.");
    }
}
