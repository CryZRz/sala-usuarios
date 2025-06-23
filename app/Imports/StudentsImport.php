<?php

namespace App\Imports;

use App\Models\Period;
use App\Models\Student;
use App\Models\StudentUpdate;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Ramsey\Uuid\Uuid;

class StudentsImport implements ToModel, WithHeadingRow, WithValidation, WithChunkReading
{
    private const BASE_UUID = "6ba7b810-9dad-11d1-80b4-00c04fd430c8";
    private array $headers;
    public function __construct(array $headers){
        //La implementacion de WithHeadingRow cambia los headers a minuscula
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
        $fullName = $name." ".$lastName;
        $career = $row[$this->headers['career']];
        $controlNumber = $row[$this->headers['controlNumber']];
        $semester = $row[$this->headers['semester']];

        //Quitamos todos los caracteres especiales que tenga el nombre completo
        $texto = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $fullName);
        //Tomamos como base un uuid para generar un uuid en base a el nombre sin caracteres especiales
        $namesPaceUuidObject = Uuid::fromString(self::BASE_UUID);

        //SI DOS PERSONAS TIENEN EL MISMO NOMBRE Y APELLIDOS JODE LAS COSAS !!!!
        $uuid = UUID::uuid5($namesPaceUuidObject, $texto);

        $studentInfo = Student::getByUUid($uuid);

        if ($studentInfo != null) {
            StudentUpdate::create([
                "student_id" => $studentInfo->id,
                "career" => $career,
                "controlNumber" => $controlNumber,
                "semester" => intval($semester),
                "period_id" => Period::getLastPeriod()->id
            ]);
        }else{
            $student = Student::create(
                [
                    "name" => $name,
                    "lastName" => $lastName,
                    "uuid" =>  $uuid,
                ]
            );

            StudentUpdate::create([
                "student_id" => $student->id,
                "career" => $career,
                "controlNumber" => $controlNumber,
                "semester" => intval($semester),
                "period_id" => Period::getLastPeriod()->id
            ]);
        }

        return null;
    }

    public function rules(): array
    {
        return [
            $this->headers["name"] => ["required", "string"],
            $this->headers["career"] => ["required", "string"],
            $this->headers["controlNumber"] => ["required", "min:8"],
            $this->headers["lastName"] => ["required", "string"],
            $this->headers["semester"] => ["required", "numeric", "min:0"],
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
