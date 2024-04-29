<?php

namespace App\Http\Controllers\Importes;

use App\Models\Student;
use App\Models\StudentUpdate;
use App\Models\Period;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImporteAlumnos implements ToCollection
{
    private $numRegistrados = 0;

    public function collection(Collection $filas)
    {
        $idPeriodo = self::getPeriodo();
        $encabezados = [];
        foreach ($filas as $fila) { //Encabezados
            if (empty($encabezados)) {
                $indice = 0;
                foreach ($fila as $encabezado) {
                    $encabezados = array_merge($encabezados, [$encabezado => $indice++]);
                }
            } else {
                $colNombre = $encabezados['Nombre'] ?? $encabezados['Nombres'];
                $colApellido = $encabezados['Apellidos'] ?? $encabezados['Apellido'];
                $colNumControl = $encabezados['NControl'] ?? $encabezados['NumControl'] ?? $encabezados['NumeroControl'] ?? $encabezados['Num Control'];
                $colCarrera = $encabezados['Carrera'];
                $colSemestre = $encabezados['Semestre'];

                $nombre = $fila[$colNombre];
                $apellido = $fila[$colApellido];
                $numControl = $fila[$colNumControl];
                $carrera = $fila[$colCarrera];
                $semestre = $fila[$colSemestre];
                $alumno = Student::where(['name' => $nombre, 'lastName' => $apellido])->first();

                if (!isset($alumno)) {
                    $alumno = Student::create([
                        'name' => $nombre,
                        'lastName' => $apellido
                    ]);
                }

                try {
                    StudentUpdate::create([
                        'controlNumber' => $numControl,
                        'career' => $carrera,
                        'semester' => $semestre,
                        'student_id' => $alumno->id,
                        'period_id' => $idPeriodo
                    ]);
                    $this->numRegistrados++;
                } catch (\Throwable $th) { //Ignorar error si es registro repetido y continuar.
                    continue;
                }
            }
        }
    }

    private function getPeriodo()
    {
        $fechaActual = Carbon::now();
        $nombrePeriodo = "";
        if ($fechaActual->month >= 1 && $fechaActual->month <= 6) {
            $nombrePeriodo = "ENE-JUN";
        } else {
            $nombrePeriodo = "AGO-DIC";
        }
        $nombrePeriodo = $nombrePeriodo . " " . $fechaActual->year;
        $periodo = Period::where('name', $nombrePeriodo)->first();

        if (!isset($periodo)) {
            $periodo = Period::create(["name" => $nombrePeriodo]);
        }
        return $periodo->id;
    }

    public function getNumRegistrados(){
        return $this->numRegistrados;
    }
}