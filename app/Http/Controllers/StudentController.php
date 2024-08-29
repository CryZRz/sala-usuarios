<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Http\Requests\StudentSearchRequest;
use App\Http\Requests\StudentUpdateRequest;
use App\Http\Resources\StudentResource;
use App\Http\Utils\CareersE;
use App\Models\Period;
use App\Models\Student;
use App\Models\StudentUpdate;
use Illuminate\Http\Request;

class StudentController extends Controller
{

    public function showAll()
    {
        $students = Student::paginate(10);
        $data = [
            "students" => $students
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

    public function store(StudentRequest $request)
    {
        $data = $request->validated();
        $this->createStudent($data);

        return redirect()->route("student.showAll");
    }

    public static function createStudent(array $data)
    {
        $periodoActual = Period::orderByDesc('created_at')->first();
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

    public function update(Student $student, StudentUpdateRequest $request)
    {
        $data = $request->validated();

        $student->update([
            "name" => $data["name"],
            "lastName" => $data["lastName"]
        ]);

        StudentUpdate::create([
            "controlNumber" => $data["controlNumber"],
            "career" => $data["career"],
            "semester" => $data["semester"]
        ]);

        return redirect()->route("student.showAll");
    }

    public function edit(Student $student)
    {
        $updatedDetails = StudentUpdate::where("student_id", "=", $student->id)
            ->orderBy("created_at", "desc")
            ->first();

        $data = [
            "student" => $student,
            "updatedDetails" => $updatedDetails,
            "careers" => CareersE::cases()
        ];

        return view("student.edit", $data);
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route("student.showAll");
    }
}
