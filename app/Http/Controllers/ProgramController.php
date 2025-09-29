<?php

namespace App\Http\Controllers;

use App\Http\Utils\Interfaces\HasModule;
use App\Models\Computer;
use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller implements HasModule
{

    public function hasModule(): string
    {
        return "program";
    }

    public function show(Request $request) {
        $textFind = $request->get('textFind');
        $programsQuery = Program::query()->orderBy('created_at', 'desc');

        if (!empty($textFind)) {
            $programsQuery->where('name', 'like', '%' . $textFind . '%');
        }

        $programs = $programsQuery->paginate(10)->appends($request->query());

        $data = [
            "programs" => $programs
        ];

        return view("program.show", $data);
    }

    public function showApi(Request $request) {
        $find = $request->get("find");
        if ($find) {
            $programs = Program::where("name", "like", "%$find%")->paginate(10);

            return response()->json($programs);
        }

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

    public function destroy(Request $request) {
        $id = $request->get("id");
        Program::destroy($id);

        return redirect()->route("program.show");
    }

    public function getByComputer(Computer $computer, Request $request) {
        $find = $request->get("find");
        if ($find) {
            $programs = $computer->programs()->where("name", "like", "%$find%")->paginate(10);

            return response()->json($programs);
         }

        $programs = $computer->programs()->paginate(10);

        return response()->json($programs);
    }
}
