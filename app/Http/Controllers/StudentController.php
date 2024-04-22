<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Http\Requests\StudentSearchRequest;
use App\Http\Requests\StudentUpdateRequest;
use App\Http\Utils\CareersE;
use App\Models\Period;
use App\Models\Student;
use App\Models\StudentUpdate;

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

    public static function search(string $numControl)
    {
        //Buscar el registro más reciente de los datos actualizados del estudiante con su núm. control
        $alumno = StudentUpdate::where("controlNumber", "=", $numControl)
            ->orderBy("created_at", "desc")
            ->first();
        if ($alumno != null) {
            //Añadir los datos no cambiantes del alumno.
            $datosAlumno = $alumno->student()
                ->select("name", "lastName")
                ->first();
            $alumno = collect($alumno)->merge($datosAlumno);
        }
        return $alumno;
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
