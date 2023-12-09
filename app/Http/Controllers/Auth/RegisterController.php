<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{

    public function show() {
        return view("auth.register");
    }

    public function store(LoginRequest $request) {
        $data = $request->validated();
        
        $user = User::create([
            "name" => $data["name"],
            "email" => $data["email"],
            "password" => $data["password"]
        ]);
        if (auth()->attempt(["email" => $data["email"], "password" => $data["password"]])) {
            return redirect("/home", 200);
        }
        return redirect("/login")->with("errors", "ocurrio un error al intentar registrarse");
    }
}
