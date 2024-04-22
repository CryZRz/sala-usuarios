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

    public function store(RegisterRequest $request) {
        $data = $request->validated();
        
        if(!isset($data)){
            return redirect()->back()->withInput();
        }

        $user = User::create([
            "name" => $data["name"],
            "email" => $data["email"],
            "password" => $data["pass"]
        ]);
        if (auth()->attempt(["email" => $data["email"], "password" => $data["pass"]])) {
            return redirect()->route("session.show");
        }
        return redirect()
                ->route("register.show")
                ->with("errors", "Ocurrió un error al intentar registrarse.");
    }
}
