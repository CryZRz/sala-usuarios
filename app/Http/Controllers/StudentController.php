<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Http\Requests\StudentSearchRequest;
use App\Http\Requests\StudentUpdateRequest;
use App\Http\Resources\StudentResource;
use App\Http\Utils\CareersE;
use App\Models\Incidence;
use App\Models\Loan;
use App\Models\Period;
use App\Models\Student;
use App\Models\StudentUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{

    public function showAll()
    {
        $students = Student::paginate(10);
        $data = [
            "students" => $students,
            "paginate" => true
        ];
        return view("student.showAll", $data);
    }

    public function show()
    {
        $careers = CareersE::getCareers();

        $data = [
            "careers" => $careers
        ];

        return view("student.show", $data);
    }

    public function search(string $numControl)
    {
        $student = StudentUpdate::getLastByControlNumber($numControl);

        if ($student != null) {
            return new StudentResource($student);
        }

        return response()->json(["error" => "estudiante no registrado"], 404);
    }

    public function findAll(Request $request)
    {
        $textFind = $request->get("textFind");
        $pattern = "/^(?:\d+|(?=\d*\D{1,2}\d*$)[A-Za-z\d]+)$/";

        if (!preg_match($pattern, $textFind)) {
            $students = Student::where(DB::raw('CONCAT(name, " ", lastname)'), 'LIKE', "%{$textFind}%")
                    ->paginate(10);

            $students->appends(['textFind' => $textFind]);

            $data = [
                "students" => $students,
                "paginate" => true
            ];

            return view("student.showAll", $data);
        }

        $students = StudentUpdate::getLastByControlNumber($textFind);

        $data = [
            "students" => $students != null ? [$students->student] : [],
            "paginate" => false
        ];

        return view("student.showAll", $data);
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
        $this->createStudent($data);

        return redirect()->route("student.showAll");
    }

    public static function createStudent(array $data)
    {
        $periodoActual = Period::getLastPeriod();
        $student = Student::create([
            "name" => $data["name"],
            "lastName" => $data["lastName"]
        ]);
        return StudentUpdate::create([
            "student_id" => $student["id"],
            "period_id" => $periodoActual->id,
            "controlNumber" => $data["controlNumber"],
            "career" => $data["career"],
            "semester" => $data["semester"]
        ]);
    }

    public function update(string $controlNumber, StudentUpdateRequest $request)
    {
        $data = $request->validated();

        $student = StudentUpdate::getLastByControlNumber($controlNumber)->student;

        $student->update([
            "name" => $data["name"],
            "lastName" => $data["lastName"]
        ]);

        StudentUpdate::create([
            "controlNumber" => $data["controlNumber"],
            "career" => $data["career"],
            "semester" => $data["semester"],
            "student_id" => $student->id,
            "period_id" => Period::getLastPeriod()->id,
        ]);

        return redirect()->route("student.showAll");
    }

    public function edit(string $controlNumber)
    {
        $updatedDetails = StudentUpdate::getLastByControlNumber($controlNumber);

        $data = [
            "student" => $updatedDetails->student,
            "updatedDetails" => $updatedDetails,
            "careers" => CareersE::cases()
        ];

        return view("student.edit", $data);
    }
}
