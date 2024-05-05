<?php

namespace App\Http\Utils\reports\excelExports;

use App\Models\Loan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ToExportLoan implements FromCollection, WithHeadings, WithColumnWidths
{
    public function collection()
    {
        $loans = Loan::withTrashed()->get();

        $dataStudent = $loans->map(function ($loan) {
            $studentInfoUpdate = $loan->studentUpdate;
            $studentInfo = $loan->student;
            $computerInfo = $loan->computer;
            $applicationInfo = $loan->application;
            $createdByInfo = $loan->owner;
            return [
                "id session" => $loan->id,
                "tiempo incio" => $loan->startTime,
                "tiempo final" => $loan->endTime,
                "tiempo asignado" => $loan->timeAssigment,
                "nombre" => $studentInfo->name ?? null,
                "apellidos" => $studentInfo->lastName ?? null,
                "numero de control" => $studentInfoUpdate->controlNumber ?? null,
                "carrera" => $studentInfoUpdate->career ?? null,
                "semestre" => $studentInfoUpdate->semester ?? null,
                "id computadora" => $computerInfo->id,
                "ram" => $computerInfo->ram,
                "cpu" => $computerInfo->cpu,
                "uso" => $applicationInfo->name,
                "Nombre admin" => $createdByInfo->name,
                "Correo admin" => $createdByInfo->email
            ];
        });

        return $dataStudent;
    }

    public function headings(): array
    {
        return [
            "Id session",
            "Tiempo incio",
            "Tiempo final",
            "Tiempo asignado",
            "Nombre",
            "Apellidos",
            "Numero de control",
            "Carrera",
            "Semestre",
            "Id computadora",
            "Ram",
            "Cpu",
            "Uso",
            "Nombre admin",
            "Correo admin"
        ];
    }

    public function columnWidths(): array
    {
        return [
            'B' => 25,
            "C" => 25,
            "D" => 25,
            "E" => 25,
            "F" => 25,
            "G" => 20,
            "H" => 50,
            "L" => 30,
            "N" => 25,
            "O" => 30
        ];
    }

}
