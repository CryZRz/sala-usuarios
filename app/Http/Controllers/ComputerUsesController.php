<?php

namespace App\Http\Controllers;

use App\Http\Utils\Interfaces\HasModule;
use App\Models\Application;
use Illuminate\Http\Request;

class ComputerUsesController extends Controller implements HasModule
{

    public function hasModule() : string{
        return "computerUses";
    }

    public function show() {
        $usos = Application::orderBy("name")->get();

        $data = [
            "usos" => $usos
        ];

        return view("uses.show", $data);
    }

    public function create() {
        return view("uses.create");
    }

    public function edit(int $idUso) {
        $uso = Application::find($idUso);
        $data = [
            "uso" => $uso
        ];
        return view("uses.edit", $data);
    }

    public function store(Request $request){
        $uso = new Application();
        $uso->name = $request->nombre;
        $uso->save();
        return redirect()->route("computer.showUses");
    }

    public function update(Request $request){
        $uso = Application::find($request->id);
        $uso->name = $request->nombre;
        $uso->save();
        return redirect()->route("computer.showUses");
    }

    public function destroy(int $idUso){
        $uso = Application::find($idUso);
        $uso->delete();
        return redirect()->route("computer.showUses");
    }
}
