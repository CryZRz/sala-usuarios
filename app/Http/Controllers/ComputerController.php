<?php

namespace App\Http\Controllers;

use App\Http\Requests\ComputerRequest;
use App\Http\Utils\Interfaces\HasModule;
use App\Models\Computer;
use App\Models\Port;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ComputerController extends Controller implements HasModule
{

    public function __construct(){
        View::share('module', $this->hasModule());
    }

    public function hasModule(): string
    {
        return "computer";
    }

    public function show(Request $request) {
        $data = [
            "computers" => null
        ];

        if ($request->get("find")) {
            $data["computers"] = Computer::where("computer_number", $request->get("find"))
                ->paginate(10)
                ->appends(request()->query());

            return view("computer.show", $data);
        }

        $data["computers"] = Computer::paginate(10);

        return view("computer.show", $data);
    }

    public function create() {
        return view("computer.create");
    }

    public function store(ComputerRequest $request) {
        $data = $request->validated();

        $ports = $data["ports"];
        $programs = $data["programs"];

        $computer = Computer::create([
            "ram" => $data["ram"],
            "cpu" => $data["name"],
            "computer_number" => $data["computerNumber"]
        ]);

        foreach ($ports as $port) {
            Port::create([
                "type" => $port["type"],
                "amount" => $port["amount"],
                "computer_id" => $computer->id
            ]);
        }

        $computer->programs()->attach($programs);


        return response(null, 203);
    }

    public function missingPrograms(Computer $computer, Request $request) {
        $find = $request->get("find");
        $programsComputer = $computer->programs()->pluck("programs.id");

        $listProgramsMissing = Program::whereNotIn("id", $programsComputer);

        if ($find) {
            $programsComputerFind = $listProgramsMissing->where("name", "like", "%$find%")->paginate(10);

            return response()->json($programsComputerFind);
        }

        return response()->json($listProgramsMissing->paginate(10));
    }

    public function edit(Computer $computer) {
        $data = [
            "computer" => $computer,
        ];

        return view("computer.edit", $data);
    }

    public function update(Computer $computer, Request $request) {
        $this->validate($request,[
            "cpu" => "required",
            "ram" => ["required", "integer", "min:1"],
        ]);

        $computer->cpu = $request->get("cpu");
        $computer->ram = $request->get("ram");

        $computer->save();

        return redirect()->route("computer.show");
    }

    public function destroy(Computer $computer) {
        $computer->delete();

        return redirect()->route("computer.show");
    }

    public function addPrograms(Computer $computer, Request $request) {
        $this->validate($request, [
            "programs" => ["required"],
            "programs.*" => ["required", "exists:programs,id"]
        ]);

        $computer->programs()->attach($request->get("programs"));

        return response(null, 203);
    }

    public function removeProgram(Computer $computer, Program $program) {
        $computer->programs()->detach($program);

        return response(null, 204);
    }
}
