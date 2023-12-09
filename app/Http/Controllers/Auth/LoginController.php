<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function show() {
        return view("auth.login");
    }

    public function store(LoginRequest $request) {
        $data = $request->validated();

        if (!auth()->attempt($data)) {
            return redirect("/login")->with("erros", "Email o contraseña incorrectos");
        }
        return redirect("/inicio");
    }

    public function destroy(Request $request) {
        auth()->logout();
    }
}
