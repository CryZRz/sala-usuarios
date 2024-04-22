<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class UsosController extends Controller
{
    public function mostrar() {
        $usos = Application::orderBy("name")->get();

        $data = [
            "usos" => $usos
        ];
        
        return view("uses.show", $data);
    }

    public function mostrarCrear() {
        return view("uses.create");
    }

    public function mostrarEditar(int $idUso) {
        $uso = Application::find($idUso);
        $data = [
            "uso" => $uso
        ];
        return view("uses.edit", $data);
    }

    public function crear(Request $request){
        $uso = new Application();
        $uso->name = $request->nombre;
        $uso->save();
        return redirect()->route("computer.showUses");
    }

    public function editar(Request $request){
        $uso = Application::find($request->id);
        $uso->name = $request->nombre;
        $uso->save();
        return redirect()->route("computer.showUses");
    }

    public function eliminar(int $idUso){
        $uso = Application::find($idUso);
        $uso->delete();
        return redirect()->route("computer.showUses");
    }
}
