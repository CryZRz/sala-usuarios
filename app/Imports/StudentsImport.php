<?php

namespace App\Imports;

use App\Http\Utils\Students\StudentU;
use App\Models\Career;
use App\Models\Period;
use App\Models\Student;
use App\Models\StudentUpdate;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StudentsImport implements ToModel, WithHeadingRow, WithValidation, WithChunkReading
{
    private array $headers;
    public function __construct(array $headers){
        //La implementacion de WithHeadingRow cambia los headers a mayusculas nose por que xd
        $this->headers = array_map(fn($header) => strtolower($header), $headers);
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $name = $row[$this->headers['name']];
        $lastName = $row[$this->headers['lastName']];
        $careerName = $row[$this->headers['careerName']];
        $careerKey = $row[$this->headers['careerKey']];
        $controlNumber = $row[$this->headers['controlNumber']];
        $semester = $row[$this->headers['semester']];
        $curp = $row[$this->headers['curp']];

        $studentInfo = Student::getByCurp($curp);
        $careerInfo = Career::getByKey($careerKey);

        if ($careerInfo == null) {
            $careerInfo = Career::create([
                "key" => $careerKey,
                "name" => $careerName,
            ]);
        }

        if ($studentInfo != null) {
            StudentUpdate::create([
                "student_id" => $studentInfo->id,
                "career_id" => $careerInfo->id,
                "controlNumber" => $controlNumber,
                "semester" => intval($semester),
                "period_id" => Period::getLastPeriod()->id,
                "active" => true,
            ]);
        }else{
            $student = Student::create(
                [
                    "name" => $name,
                    "lastName" => $lastName,
                    "curp" => $curp,
                ]
            );

            StudentUpdate::create([
                "student_id" => $student->id,
                "career_id" => $careerInfo->id,
                "controlNumber" => $controlNumber,
                "semester" => intval($semester),
                "period_id" => Period::getLastPeriod()->id,
                "active" => true,
            ]);
        }

        return null;
    }

    public function rules(): array
    {
        return [
            $this->headers["name"] => ["required", "string", "max:100"],
            $this->headers["careerName"] => ["required", "string", "max:100"],
            $this->headers["controlNumber"] => ["required", "min:8"],
            $this->headers["lastName"] => ["required", "string", "max:100"],
            $this->headers["semester"] => ["required", "numeric", "min:0"],
            $this->headers["curp"] => ["required"],
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
