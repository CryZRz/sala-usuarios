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
        //Indicador para que al mostrar las sesiones por primera vez, cambie de propietario las activas.
        session()->put("autenticacion", true);
        return redirect()->route("login.show");
    }

    public function destroy(Request $request)
    {
        $this->validate($request, [
            "option" => ["required", "numeric", "min:1", "max:2"]
        ]);

        $option = $request->get("option");

        if ($option == 2) {
            Loan::where("created_by", auth()->id())->delete();
        }

        auth()->logout();

        return redirect()->route("login.show");
    }

    public function logout(Request $request)
    {
        $loans = Loan::where("created_by", auth()->id())->get();
        if (!$loans->isEmpty()) {
            return response()
                ->json(
                    ["errors" => "No puedes cerrar sesion con sesiones activas sin resolver"],
                    403);
        }
        auth()->logout();

        return response("", 202);
    }
}
