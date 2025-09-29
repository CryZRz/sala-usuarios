<?php

namespace App\Http\Utils\Students\excelExports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

/*
 * Habrá que ver si mejorar en caso de que la plantilla
 * de alumnos crezca
 * */
class ToExportStudents implements FromQuery, WithHeadings, WithMapping
{
    private $query;

    public function __construct($query){
        $this->query = $query;
    }

    public function query()
    {
        return $this->query;
    }

    public function headings(): array
    {
        return [
            "Nombres",
            "Apellidos",
            "Numero de control",
            "Semestre",
            "Carrera",
            "Periodo",
        ];
    }

    public function map($row): array
    {
        return [
            $row->student->name,
            $row->student->lastName,
            $row->controlNumber,
            $row->semester,
            $row->career,
            $row->period->name,
        ];
    }
}
