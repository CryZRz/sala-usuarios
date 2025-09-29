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
        $usos = Application::orderBy("created_at", "desc")->paginate(10);

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
        $this->validate($request, [
            "name" => "required",
        ]);

        $uso = new Application();
        $uso->name = $request->name;
        $uso->save();
        return redirect()->route("computer.showUses");
    }

    public function update(Request $request){
        $this->validate($request, [
            "name" => ["required"],
            "idUso" => ["required", "exists:applications,id"],
        ]);

        $uso = Application::find($request->idUso);
        $uso->name = $request->name;
        $uso->save();
        return redirect()->route("computer.showUses");
    }

    public function destroy(Request $request){
        $this->validate($request, [
            "idUso" => ["required", "exists:applications,id"],
        ]);

        $idUso = $request->get("idUso");
        $uso = Application::find($idUso);
        $uso->delete();

        return redirect()->route("computer.showUses");
    }
}
