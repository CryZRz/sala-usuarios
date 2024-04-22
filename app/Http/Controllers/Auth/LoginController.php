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
        if ($request->get("accion") == "finalizar") {
            //Cerrar todas las sesiones.
            $prestamosActivos = Loan::all();
            foreach ($prestamosActivos as $prestamo) {
                $prestamo->delete();
            }
        }

        auth()->logout();

        return redirect()->route("login.show");
    }
}
