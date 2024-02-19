<?php

namespace App\Http\Controllers;

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
    public static function calcularHorario($horaInicio, $tiempoAsignado)
    {
        $tiempos["horario"] = $horaInicio->format("H:i");
        $tiempos["horaFin"] = $horaInicio->add(new DateInterval('PT' . str_replace(':', 'H', substr($tiempoAsignado, 0, -3)) . 'M'))->format("H:i");
        $tiempos["horario"] = $tiempos["horario"] . " - " . $tiempos["horaFin"];
        return $tiempos;
    }

    public static function calcularRestante($horaFin)
    {
        $horaActual = date_create("now");
        $tiempoFin = date_create($horaFin);
        if ($horaActual >= $tiempoFin) {
            $tiempoRestante = "00:00:00";
        } else { 
            $tiempoRestante = $tiempoFin->sub(new DateInterval('PT' . str_replace(':', 'H', $horaActual->format("H:i")) . 'M'))->format("H:i:s");
        }
        return $tiempoRestante;
    }

    public function mostrarSesiones()
    {
        $sesiones = Loan::orderByRaw('(startTime + timeAssigment) ASC')->get();

        $data = [
            "sesiones" => $sesiones
        ];

        return view("session.show", $data);
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
                $studiante = Student::where("controlNumber", $request->numControl)->first();
                $sesion = Loan::where("student_id", $studiante->id)->first();
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
        if (isset($sesion)) {
            $sesion->delete();
        }

        return redirect(route("session.show"));
    }

    public function terminarMultiples($numsSesion)
    {
        $numsSesion = json_decode($numsSesion);
        foreach ($numsSesion as $numSesion) {
            Loan::find($numSesion)->delete();
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
        //Se necesita traer de las sesiones todas aquellas que aun no han terminado
        $loansInUse = Loan::all()
            ->map(fn($query) => $query->computer_id);

        //Buscamos todas las computadoras que no esten en uso
        $computers = Computer::whereNotIn("id", $loansInUse)->get();

        return response()->json($computers);
    }

    public function cargarEquiposUso()
    {
        //Se necesita traer de las sesiones todas aquellas que aun no han terminado
        $loansInUse = Loan::all()
            ->map(fn($query) => $query->computer_id);

        //Buscamos todas las computadoras que esten en uso
        $computers = Computer::whereIn("id", $loansInUse)->get();

        return response()->json($computers);
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
            $prestamo = Loan::where("student_id", $alumno->id)->first();
            if ($prestamo != null) {
                $resultado['prestamo'] = $prestamo->computer_id;
            }
        }
        return response()->json($resultado);
    }

    public function registrarSesion(Request $request)
    {
        $registrado = $request->registrado;
        $dataSesion = [
            "student_id" => null,
            "computer_id" => $request->equipo,
            "application_id" => $request->uso,
            "timeAssigment" => $request->tiempo
        ];
        if (!$registrado) {
            $alumno = new Student();
            $alumno->controlNumber = $request->numControl;
            $alumno->name = $request->nombre;
            $alumno->lastName = $request->apellidos;
            $alumno->career = $request->carrera;
            $alumno->semester = $request->semestre;
            $alumno->save();
            $dataSesion["student_id"] = $alumno->id;
            Loan::create($dataSesion);
        } else {
            $alumno = Student::where("controlNumber", $request->numControl)->first();
            $dataSesion["student_id"] = $alumno->id;
            Loan::create($dataSesion);
        }

        return redirect()->route("session.show");
    }

    public function actualizarTiempos(Request $request)
    {
        $this->validate($request, [
            "listSessions" => ["array", "required"],
            "listSessions.*.id" => ["required", "exists:loans,id"],
            "dataComputer.*.time" => ["required"],
        ]);

        $listSessionToUpdate = $request->get("listSessions");

        foreach ($listSessionToUpdate as $session) {
            $hours = $session["time"]["hours"];
            $minutes = $session["time"]["minutes"];

            $timeFormat = new DateTime("$hours:$minutes:00");
            $loan = Loan::find($session["id"]);
            $loan->timeAssigment = $timeFormat;
            $loan->save();
        }
        return response(null, 204);
    }

    public function actualizarTiempo(Request $request)
    {
        $idSession = $request->get("idSession");
        $session = Loan::find($idSession);
        $time = $request->get("timeSession");

        if ($session == null) {
            return response(404);
        }

        $session->timeAssigment = $time;
        $session->save();

        return redirect()->route("session.show");
    }
}
