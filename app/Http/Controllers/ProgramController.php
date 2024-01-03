<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function show() {
        $programs = Program::paginate(10);

        $data = [
            "programs" => $programs
        ];
        
        return view("program.show", $data);
    }

    public function showApi() {
        $programs = Program::paginate(10);

        return response()->json($programs);
    }

    public function create(Request $request) {
        return view("program.create");
    }

    public function store(Request $request) {
        $this->validate($request, [
            "name" => ["required", "min:5"],
            "version" => ["required"]
        ]);

        Program::create([
            "name" => $request->get("name"),
            "version" => $request->get("version")
        ]);

        return redirect()->route("program.show");
    }

    public function edit(Program $program) {
        $data= [
            "program" => $program,
        ];

        return view("program.create", $data); 
    }

    public function update(Request $request) {
        $this->validate($request, [
            "id" => ["required", "exists:programs,id"],
            "name" => ["required", "min:5"],
            "version" => ["required"]
        ]);

        $id = $request->get("id");
        $name = $request->get("name");
        $version = $request->get("version");

        $program = Program::find($id);
        $program->name = $name;
        $program->version = $version;
        $program->update();

        return redirect()->route("program.show");
    }
}
