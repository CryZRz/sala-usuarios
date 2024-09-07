<?php

namespace App\Imports;

use App\Http\Utils\CareersE;
use App\Models\Period;
use App\Models\Student;
use App\Models\StudentUpdate;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StudentsImport implements ToModel, WithHeadingRow, WithValidation, WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $studentInfo = StudentUpdate::getLastByControlNumber($row['numero_control']);

        if ($studentInfo != null) {
            $studentInfo->student->update([
                "name" => $row["nombres"],
                "lastName" => $row["primer_apellido"] . " " . $row["segundo_apellido"],
            ]);

            StudentUpdate::create([
                "student_id" => $studentInfo->student_id,
                "career" => $row["nombre_plan"],
                "controlNumber" => $row["numero_control"],
                "semester" => intval($row["semestre"]),
                "period_id" => Period::getLastPeriod()->id
            ]);
        }else{
            $student = Student::create(
                [
                    "name" => $row["nombres"],
                    "lastName" => $row["primer_apellido"] . " " . $row["segundo_apellido"],
                ]
            );

            StudentUpdate::create([
                "student_id" => $student->id,
                "career" => $row["nombre_plan"],
                "controlNumber" => $row["numero_control"],
                "semester" => intval($row["semestre"]),
                "period_id" => Period::getLastPeriod()->id
            ]);
        }

        return null;
    }

    public function rules(): array
    {
        return [
            "clave_plan_estudios_view" => ["required", "string"],
            "nombre_plan" => ["required", "string", Rule::in(CareersE::getCareers())],
            "numero_control" => ["required", "min:8"],
            "primer_apellido" => ["required", "string"],
            "segundo_apellido" => [
                "nullable",
                function($attribute, $value, $fail) {
                    if (!is_string($value) && $value !== 0 && $value !== "") {
                        $fail("El campo $attribute debe ser una cadena o el valor '0'.");
                    }
                }
            ],
            "nombres" => ["required", "string"],
            "anio_ingreso" => ["required", "numeric"],
            "clave_periodo_ingreso" => ["required", "string"],
            "semestre" => ["required", "numeric", "min:0", "max:14"],
            "email" => ["required", "string", "email"],
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
