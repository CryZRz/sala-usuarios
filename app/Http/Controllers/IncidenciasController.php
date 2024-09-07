<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentSearchRequest;
use App\Models\Incidence;
use App\Models\Student;
use App\Models\StudentUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IncidenciasController extends Controller
{
    public function show()
    {

        $incidencias = Incidence::orderByDesc("updated_at")->paginate(10);

        $data = [
            "incidencias" => $incidencias,
            "muestra" => "activas"
        ];

        return view("incidences.show", $data);
    }

    public function showOne(int $id)
    {
        $incidence = Incidence::withTrashed()->find($id);

        $data = [
            "incidence" => $incidence,
        ];

        return view("incidences.showOne", $data);
    }

    public function create()
    {
        return view("incidences.create");
    }

    public function mostrarIncidenciasResueltas()
    {
        $incidencias = Incidence::onlyTrashed()
            ->orderByDesc("updated_at")
            ->paginate(10);

        $data = [
            "incidencias" => $incidencias,
            "muestra" => "resueltas"
        ];

        return view("incidences.show", $data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            "description" => ["required"],
            "controlNumber" => ["required", "min:8", "exists:student_updates,controlNumber"],
        ]);

        $controlNumber = $request->get("controlNumber");
        $description = $request->get("description");
        $studentData = StudentUpdate::getLastByControlNumber($controlNumber);

        Incidence::create([
            "student_update_id" => $studentData->id,
            "student_id" => $studentData->student->id,
            "description" => $description,
            "created_by" => auth()->user()->id
        ]);

        return redirect()->route("incidence.show");
    }

    public function update(int $incidenceId, Request $request)
    {
        $this->validate($request, [
           "description" => ["required"]
        ]);

        $incidence = Incidence::withTrashed()->find($incidenceId);

        if ($incidence != null) {
            $description = trim($request->get("description"));
            $incidence->update([
                "description" => $description,
            ]);

            return redirect()->back();
        }

        return redirect()->back()->withErrors("Incidencia no encontrada");
    }

    public function buscarEstudiante(Request $request)
    {
        $this->validate($request, [
            "controlNumber" => ["required", "min:8", "exists:student_updates,controlNumber"],
        ]);

        $controlNumber = $request->get("controlNumber");
        $infoStudent = StudentUpdate::getLastByControlNumber($controlNumber);

        $incidencesStudent = Incidence::withTrashed()
            ->where("student_id", $infoStudent->student->id)
            ->orderByDesc("updated_at")
            ->paginate(10);

        $data = [
            "incidencias" => $incidencesStudent,
            "infoStudent" => $infoStudent,
            "muestra" => "estudiante"
        ];

        return view("incidences.show", $data);
    }

    public function destroy(Incidence $incidence)
    {
        if (!$incidence->status){
            $incidence->update([
               "status" => true
            ]);
            $incidence->delete();
            return redirect()->route("incidence.show");
        }

        return redirect()
            ->route("incidence.show")
            ->with("message", "Incidencia ya finalizada");
    }
}
