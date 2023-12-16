<?php

namespace App\Http\Controllers;

use App\Http\Requests\ComputerRequest;
use App\Http\Requests\ComputerUpdateRequest;
use App\Models\Computer;
use App\Models\Port;
use App\Models\Program;
use App\Models\ProgramComputer;
use Illuminate\Http\Request;

class ComputerController extends Controller
{
    public function show() {
        $Computers = Computer::paginate(10);

        $data = [
            "computers" => $Computers
        ];
        
        return view("computer.show", $data);
    }

    public function create() {
        return view("computer.create");
    }

    public function store(ComputerRequest $request) {
        $data = $request->validated();
        $dataComputer = $data["dataComputer"];
        $ports = $dataComputer["ports"];
        $programs = $dataComputer["programs"];

        $computer = Computer::create([
            "ram" => $dataComputer["ram"],
            "cpu" => $dataComputer["name"]
        ]);

        foreach ($ports as $port) {
            Port::create([
                "type" => $port["name"],
                "amount" => $port["amount"],
                "computer_id" => $computer->id
            ]);
        }
        foreach ($programs as $program) {
            ProgramComputer::create([
                "program_id" => $program,
                "computer_id" => $computer->id
            ]);
        }

        return response(null, 203);
    }

    public function edit(Computer $computer) {
        $programs = ProgramComputer::where("computer_id", $computer->id)
            ->get()
            ->map(function($query) {
                    return $query->program_id;
        });
        $listPrograms = Program::whereNotIn("id", $programs)->get();
        
        $data = [
            "computer" => $computer,
            "programsEditable" => $listPrograms
        ];
        
        return view("computer.edit", $data);
    }

    public function removePorgram(int $id){
        $program = ProgramComputer::find($id);
        if ($program) {
            $program->delete();

            return response(null, 203);
        }

        return response("el prgrama no se encontro", 404);
    }

    public function updatePort(int $id, Request $request) {
        $this->validate($request, [
            "type" => ["required"],
            "amount" => ["required"],
        ]);

        $port = Port::find($id);
        $port->type = $request->get("type");
        $port->amount = $request->get("amount");
        $port->save();

        return response(null, 203);
    }

    public function removePort(int $id){
        $port = Port::find($id);
        $port->delete();

        return response(null, 203);
    }

    public function update(Computer $computer, ComputerUpdateRequest $request) {
        $data = $request->validated();
        $dataComputer = $data["dataComputer"];
        
        $computer->cpu = $dataComputer["name"];
        $computer->ram = $dataComputer["ram"];
        if(count($dataComputer["ports"]) > 0){
            array_map(function($port) use($computer) {
                Port::create([
                    "type" => $port["name"],
                    "amount" => $port["amount"],
                    "computer_id" => $computer->id
                ]);
            }, $dataComputer["ports"]);
        }
        if(count($dataComputer["programs"]) > 0){
            array_map(function($port) use($computer) {
                ProgramComputer::create([
                    "program_id" => $port,
                    "computer_id" => $computer->id
                ]);
            }, $dataComputer["programs"]);
        }
        $computer->save();

        return response(null, 203);
    }

    public function destroy(Computer $computer) {
        $computer->delete();

        return redirect("/equipos");
    }
}
