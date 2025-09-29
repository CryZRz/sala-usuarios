<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\Loan;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    public function show()
    {
        return view("auth.login");
    }

    public function store(LoginRequest $request)
    {
        $data = $request->validated();

        if (!auth()->attempt($data)) {
            return redirect()
                ->route("login.show")
                ->with("error", "E-mail o contraseña incorrectos");
        }

        return redirect()->route("dashboard.show");
    }

    public function logout(Request $request)
    {
        $loans = Loan::where("created_by", auth()->id())->get();

        if (!$loans->isEmpty()) {
            $loans->map(fn ($loan) => $loan->delete());
        }

        auth()->logout();

        return response(null, 202);
    }
}
