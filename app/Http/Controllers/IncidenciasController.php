<?php

namespace App\Http\Controllers;

use App\Http\Utils\Interfaces\HasModule;
use App\Models\Incidence;
use App\Models\StudentUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class IncidenciasController extends Controller implements HasModule
{


    public function __construct(){
        View::share("module", $this->hasModule());
    }
    public function hasModule(): string
    {
        return "incidences";
    }

    public function show(Request $request)
    {
        $find = $request->get("find");
        $active = $request->get("active");

        $incidences = Incidence::query()
            ->orderByDesc("updated_at");

        if($active == "0"){
            $incidences->onlyTrashed();
        }
        if($find){
            $incidences->whereHas("studentUpdate", function($query) use ($find){
                $query->where("controlNumber", "like", "%".$find."%")
                    ->orWhereHas("student", function($q) use ($find){
                        $q->where(DB::raw("CONCAT(name, ' ', lastName)"), "like", "%".$find."%");
                });
            })->with("studentUpdate.student");
        }

        $data = [
            "incidences" => $incidences->paginate(10),
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

    public function update(Incidence $incidence, Request $request)
    {
        $this->validate($request, [
            "description" => ["required"],
        ]);

        $incidence->update([
            "description" => trim($request->get("description")),
        ]);

        return redirect()->route("incidence.show");
    }

    public function edit(Incidence $incidence){
        $data = [
            "incidence" => $incidence,
        ];

        return view("incidences.edit", $data);
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
