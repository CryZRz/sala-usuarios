<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Utils\CareersE;
use App\Models\Application;
use App\Models\Computer;
use App\Models\Loan;
use App\Models\Student;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;

class PrestamosController extends Controller
{
    public $sesionElegida;

    public function mostrarSesiones()
    {
        $sesiones = Loan::orderByRaw('(startTime + timeAssigment) ASC')->get();

        foreach ($sesiones as $sesion) {
            //Detalles del alumno
            $alumno = Student::where("controlNumber", $sesion->student_id)->first();
            $sesion["nombreAlumno"] = $alumno["lastName"] . " " . $alumno["name"];
            $sesion["numControl"] = $alumno["controlNumber"];
            $sesion["carrera"] = $alumno["career"];
            $sesion["semestre"] = $alumno["semester"];
            //Nombre del uso
            $uso = Application::where("id", $sesion["application_id"])->first();
            $sesion["uso"] = $uso["name"];
            //Quitar la fecha de los tiempos   
            $horaInicio = new DateTime($sesion["startTime"]);
            $sesion["horaInicio"] = $horaInicio->format("H:i");
            $sesion["timeAssigment"] = substr($sesion["timeAssigment"], 0, -3);
            $sesion["horaFin"] = $horaInicio->add(new DateInterval("PT" . str_replace(":", "H", $sesion["timeAssigment"]) . "M"))->format("H:i");
        }
        $info = [
            "sesiones" => $sesiones
        ];
        return view("session.show", $info);
    }

    /**
     * Reasignar mediante la navbar usa el núm. de control del alumno; 
     * desde la tabla de sesiones usa el núm. de sesión.
     */
    public function reasignarEquipo(Request $request, $numSesion = null)
    {
        //Revisar si hay alguna sesión activa con el equipo deseado asignado,
        $sesionEquipo = Loan::where("computer_id", $request->numEquipo)->first();
        if (!isset($sesionEquipo)) {
            //Obtener la sesión dependiendo si se llamó desde el menú o desde la tabla.
            if (isset($numSesion)) {
                $sesion = Loan::where("id", $numSesion)->first();
            } else {
                $sesion = Loan::where("student_id", $request->numControl)->first();
            }
            //Asignar el nuevo equipo a la sesión.
            $sesion->computer_id = $request->numEquipo;
            $sesion->save();
        }
        return redirect()->route("session.show");
    }

    public function terminarSesion(Request $request, $numSesion = null)
    { 
        //Si se llamó con el número de sesión (desde la tabla de sesiones)
        if (isset($numSesion)) {
            $sesion = Loan::where("id", $numSesion)->first();
        } else { //Se llamó desde la navbar o del menú de acciones.
            if ($request->opcionBuscar == "numControl") { //Si se buscó con el número de control
                $sesion = Loan::where("student_id", $request->finNumControl)->first();
            } else {
                $sesion = Loan::where("computer_id", $request->finNumEquipo)->first();
            }
        }
        //Si se encontró la sesión
        if(isset($sesion)){
            $sesion->delete();
        } 

        return redirect(route("session.show"));
    }

    public function mostrarCreacion()
    {
        return view("session.nuevaSesion");
    }

    public function cargarUsos()
    {
        return response()->json(Application::all());
    }
    public function cargarEquipos()
    {
        $equipos = Computer::all();
        //Revisar cada equipo; que no estén en sesiones de préstamo activas
        $disponibles = array();
        foreach ($equipos as $equipo) {
            $prestamo = Loan::where("computer_id", $equipo->id)->first();
            if ($prestamo == null) {
                array_push($disponibles, $equipo->id);
            }
        }
        return $disponibles;
    }

    public function cargarEquiposUso()
    {
        $equipos = Computer::all();
        //Revisar cada equipo; que no estén en sesiones de préstamo activas
        $disponibles = array();
        foreach ($equipos as $equipo) {
            $prestamo = Loan::where("computer_id", $equipo->id)->first();
            if ($prestamo != null) {
                array_push($disponibles, $equipo->id);
            }
        }
        return $disponibles;
    }

    public function cargarCarreras()
    {
        return CareersE::getCareers();
    }

    public function cargarAlumno($numControl)
    {
        //Buscar el registro del estudiante
        $alumno = Student::where("controlNumber", $numControl)->first();
        $resultado = $alumno;
        if ($alumno != null) {
            //Buscar si el estudiante tiene una sesión de préstamo activa
            $prestamo = Loan::where(["student_id" => $numControl])->first();
            if ($prestamo != null) {
                $resultado['prestamo'] = $prestamo->computer_id;
            }
        }
        return response()->json($resultado);
    }

    public function registrarSesion(Request $request)
    {
        $sesion = new Loan();
        $registrado = $request->registrado;
        if (!$registrado) {
            $alumno = new Student();
            $alumno->id = $request->numControl;
            $alumno->controlNumber = $request->numControl;
            $alumno->name = $request->nombre;
            $alumno->lastName = $request->apellidos;
            $alumno->career = $request->carrera;
            $alumno->semester = $request->semestre;
            $alumno->save();
        }
        $sesion->student_id = $request->numControl;
        $sesion->computer_id = $request->equipo;
        $sesion->application_id = $request->uso;
        $sesion->timeAssigment = $request->tiempo;
        $sesion->save();
        return redirect()->route("session.show");
    }
    // public function cargarAlumno(Request $datosForm)
    // {
    //     $numControl = $datosForm -> numControl;
    //     $prestamo = Loan::where(["student_id" => $numControl, "status" => 1])->get();
    //     error_log($prestamo);
    //     if ($prestamo->isNotEmpty()) { 
    //         error_log("Hay una sesión activa para este alumno.");
    //     } else {
    //         error_log("wtf");
    //     }
    //     // $alumno = Student::find($numControl);

    // }
}
