<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Http\Requests\StudentUpdateRequest;
use App\Http\Resources\StudentUpdateResource;
use App\Http\Utils\CareersE;
use App\Http\Utils\Interfaces\HasModule;
use App\Http\Utils\Students\excelExports\ToExportStudents;
use App\Http\Utils\Students\StudentU;
use App\Models\Career;
use App\Models\Incidence;
use App\Models\Loan;
use App\Models\Period;
use App\Models\Student;
use App\Models\StudentUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller implements HasModule
{

    public function __construct(){
        View::share("module", $this->hasModule());
    }
    public function hasModule(): string
    {
        return "student";
    }

    private function getFilteredStudents($request){
        $query = StudentUpdate::query();

        $textFind = $request->get("textFind");
        $semester = $request->get("semester");
        $period = $request->get("periodId");
        $career = $request->get("career");
        $lastPeriod = Period::getLastPeriod();


        if (!empty($textFind)) {
            $query->whereHas("student", function ($query) use ($textFind) {
                $query->where(DB::raw('CONCAT(name, " ", lastname)'), 'LIKE', "%{$textFind}%")
                    ->orWhere("controlNumber", $textFind);
            });
        }


        if ($semester != -1 && !empty($semester)) {
            $query->where("semester", $semester);
        }

        if ($career != -1 && !empty($career)){
            $query->where("career_id", $career);
        }

        if (!empty($period)) {
            $query->where("period_id", $period);
        }else{
            $query->where("period_id", $lastPeriod->id);
        }

        return $query;
    }

    public function showAll(Request $request)
    {
        $query = $this->getFilteredStudents($request);

        $data = [
            "students" => $query->paginate(10)->appends(request()->query()),
            "semester" => $request->get("semester") ?? -1,
            "career" => $request->get("career") ?? -1,
        ];

        return view("student.showAll", $data);
    }

    public function show()
    {
        /*Se tiene previsto que la cantidad
          de carreras no sean muy grande por eso
          se hace esto
        */
        $careers = Career::all();

        $data = [
            "careers" => $careers
        ];

        return view("student.show", $data);
    }

    public function findOne(string $numControl)
    {
        $student = StudentUpdate::getLastByControlNumber($numControl);

        if ($student != null) {
            return new StudentUpdateResource($student);
        }

        return response()->json(["error" => "estudiante no registrado"], 404);
    }

    public function showOneSessions(string $numControl)
    {
        $studentInfo =StudentUpdate::getLastByControlNumber($numControl);
        $studentSessions = Loan::withTrashed()
            ->where("student_id", $studentInfo->student->id)
            ->paginate(15);

        $data = [
            "studentInfo" => $studentInfo,
            "student" => $studentInfo->student,
            "sessions" => $studentSessions,
        ];

        return view("student.showOne", $data);
    }

    public function showOneIncidences(string $numControl)
    {
        $studentInfo =StudentUpdate::getLastByControlNumber($numControl);
        $studentIncidences = Incidence::withTrashed()
            ->where("student_id", $studentInfo->student->id)
            ->paginate(15);

        $data = [
            "studentInfo" => $studentInfo,
            "student" => $studentInfo->student,
            "incidences" => $studentIncidences,
        ];

        return view("student.showOne", $data);
    }

    public function store(StudentRequest $request)
    {
        $data = $request->validated();

        $lastPeriod = Period::getLastPeriod();

        $student = Student::create([
            "name" => $data["name"],
            "lastName" => $data["lastName"],
            "curp" => $data["curp"],
        ]);

        StudentUpdate::create([
            "student_id" => $student["id"],
            "period_id" => $lastPeriod->id,
            "controlNumber" => $data["controlNumber"],
            "career_id" => $data["career"],
            "semester" => $data["semester"],
            "active" => true,
        ]);

        return redirect()->route("student.showAll");
    }

    public function update(string $controlNumber, StudentUpdateRequest $request)
    {
        $data = $request->validated();

        $student = StudentUpdate::getLastByControlNumber($controlNumber)->student;

        $student->update([
            "name" => $data["name"],
            "lastName" => $data["lastName"],
        ]);

        StudentUpdate::create([
            "controlNumber" => $data["controlNumber"],
            "career_id" => $data["career"],
            "semester" => $data["semester"],
            "student_id" => $student->id,
            "period_id" => Period::getLastPeriod()->id,
            "active" => true,
        ]);

        return redirect()->route("student.showAll");
    }

    public function edit(string $controlNumber)
    {
        $updatedDetails = StudentUpdate::getLastByControlNumber($controlNumber);

        $data = [
            "student" => $updatedDetails->student,
            "updatedDetails" => $updatedDetails,
            "careers" => Career::all()
        ];

        return view("student.edit", $data);
    }

    public function exportToExcel(Request $request){
        $query = $this->getFilteredStudents($request);

        return Excel::download(new ToExportStudents($query), 'estudiantes.xlsx');
    }

    //API
    public function getStudents(string $period, Request $request){
        $paginate = $request->get("por_pagina", 50);
        $students = StudentUpdate::with("period")
            ->whereHas("period", fn($query) => $query->where("abbreviation", $period))
            ->paginate(min($paginate, 500))
            ->appends(request()->query());

        return StudentUpdateResource::collection($students);
    }
}
