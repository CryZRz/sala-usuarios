<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    public function show() {
        return view("auth.login");
    }

    public function store(LoginRequest $request) {
        $data = $request->validated();

        if (!auth()->attempt($data)) {
            return redirect()
                    ->route("login.show")
                    ->with("error", "Email o contraseña incorrectos");
        }
        return redirect()->route("home");
    }

    public function destroy(Request $request) {
        auth()->logout();

        return redirect()->route("home");
    }
}
