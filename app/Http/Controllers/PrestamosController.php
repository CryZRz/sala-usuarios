<?php

namespace App\Http\Controllers;

use App\Http\Utils\CareersE;
use App\Models\Application;
use App\Models\Computer;
use App\Models\Loan;
use App\Models\Period;
use App\Models\Student;
use App\Http\Controllers\StudentController;
use App\Models\StudentUpdate;
use App\Http\Utils\TimeFormatU;
use Carbon\Carbon;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;

class PrestamosController extends Controller
{
    public static function calcularHorario(Carbon $horaInicio, string $tiempoAsignado)
    {
        $tiempos["horario"] = $horaInicio->format("H:i");
        $tiempoAsignado = new DateTime($tiempoAsignado);
        $tiempos["horaFin"] = TimeFormatU::sumTimeToDate(
            $horaInicio,
            hours: $tiempoAsignado->format("H"),
            minutes: $tiempoAsignado->format("i")
        );
        $tiempos["horario"] = $tiempos["horario"] . " - " . $tiempos["horaFin"]->format("H:i");
        return $tiempos;
    }

    /** Convierte una hora a un timeInterval (Ej.: PT1H30M)
     * para hacer sumas o diferencias de tiempo. */
    private static function convertirAIntervalo(string $hora)
    {
        //Reemplaza una hora 01:30 por 01H30; 
        $horaFormato = str_replace(':', 'H', $hora);
        return new DateInterval('PT' . $horaFormato . 'M');
    }

    public static function calcularTiempoRestante(Carbon $tiempoFin)
    {
        $horaActual = Carbon::now();

        if ($tiempoFin <= $horaActual) {
            $tiempoRestante = "00:00:00";
        } else {
            $tiempoRestante = TimeFormatU::subtractTimeToDate(
                $tiempoFin,
                hours: $horaActual->format("H"),
                minutes: $horaActual->format("i")
            )->format("H:i:00");
        }
        return $tiempoRestante;
    }

    public function mostrarSesiones()
    {
        $sesiones = Loan::orderByRaw('(startTime + timeAssigment) ASC')->get();

        //Si la redirección se encadenó tras autenticación 
        if (session("autenticacion") == true) {
            //Si hay sesiones activas del administrador anterior
            if (isset($sesiones)) {
                //Asignar al nuevo administrador como "propietario"
                foreach ($sesiones as $sesion) {
                    if ($sesion->created_by != auth()->user()->id) {
                        Loan::where('id', $sesion->id)->update(['created_by' => auth()->user()->id]);
                        $sesion->owner->name = auth()->user()->name;
                        $sesion->owner->email = auth()->user()->email;
                    }
                }
            }
            //Indicar no necesitar volver a revisarlo en el resto de la sesión.
            session()->put("autenticacion", false);
        }

        $data = [
            "sesiones" => $sesiones
        ];

        return view("session.show", $data);
    }

    /**
     * Reasignar mediante la navbar usa el núm. de control del alumno;
     * desde la tabla de sesiones usa el núm. de sesión.
     */
    public function reasignarEquipo(Request $request, int $numSesion = null)
    {
        //Revisar si hay alguna sesión activa con el equipo deseado asignado,
        $sesionNuevoEquipo = Loan::where("computer_id", $request->numEquipo)->first();

        if (isset($sesionNuevoEquipo)) {
            return response()->json([
                'error' => 'Hay una sesión con el equipo ' . $request->numEquipo . ' asignado.'
            ], 200);
        } else {
            //Obtener la sesión dependiendo si se llamó desde el menú o desde la tabla.
            if (isset($numSesion)) { //Desde la tabla, con su núm. de sesión
                $sesion = Loan::where("id", $numSesion)->first();
            } else { //Desde el menú, con núm. de control
                $estudiante = StudentUpdate::where("controlNumber", "=", $request->numControl)->first();
                if (!isset($estudiante)) {
                    return response()->json([
                        'error' => 'El número de control ' . $request->numControl . ' no está registrado.'
                    ], 200);
                } else {
                    $sesion = Loan::where("student_id", $estudiante->student_id)->first();
                }
            }

            if (!isset($sesion)) {
                return response()->json([
                    'error' => 'El alumno ' . $request->numControl . ' no tiene una sesión activa.'
                ], 200);
            } else {
                //Asignar el nuevo equipo a la sesión.
                $sesion->computer_id = $request->numEquipo;
                $sesion->save();

                return response()->json([
                    'redireccion' => route("session.show")
                ], 200);
            }
        }
    }

    public function terminarSesion(Request $request, int $numSesion = null)
    {
        //Si se llamó con el número de sesión (desde la tabla de sesiones)
        if (isset($numSesion)) {
            $sesion = Loan::where("id", $numSesion)->first();
        } else { //Se llamó desde la navbar o del menú de acciones.
            if ($request->opcionBuscar == "numControl") { //Si se buscó con el número de control
                $estudiante = StudentUpdate::where("controlNumber", "=", $request->finNumControl)->first();
                if (!isset($estudiante)) { //Alumno no está en la BD.
                    return response()->json([
                        'error' => 'El número de control ' . $request->finNumControl . ' no está registrado.'
                    ], 200);
                } else { //Alumno indicado no tiene sesión activa
                    $sesion = Loan::where("student_id", $estudiante->student_id)->first();
                    if (!isset($sesion)) {
                        return response()->json([
                            'error' => 'El alumno ' . $request->finNumControl . ' no tiene una sesión activa.'
                        ], 200);
                    }
                }
            } else { //Se buscó con id de equipo
                $sesion = Loan::where("computer_id", $request->finNumEquipo)->first();
            }
        }
        if (isset($sesion)) { //No hay problemas; ajustar el tiempo transcurrido total
            $sesion->timeAssigment = $this->calcularTiempoTranscurrido($sesion->startTime);
            $sesion->save();
            $sesion->delete();
        }
        //Regresar a la vista de sesiones aunque la sesión ya hubiera estado eliminada. 
        return response()->json(['redireccion' => route("session.show")]);
    }

    public function calcularTiempoTranscurrido(Carbon $horaInicio)
    {
        $horaActual = Carbon::now();

        return TimeFormatU::subtractTimeToDate(
            $horaActual,
            hours: $horaInicio->format("H"),
            minutes: $horaInicio->format("i")
        );
    }

    public function terminarMultiples(string $jsonNumsSesion)
    {
        $jsonNumsSesion = json_decode($jsonNumsSesion);
        foreach ($jsonNumsSesion as $numSesion) {
            $sesion = Loan::find($numSesion);
            if (isset($sesion)) { //Ajustar el tiempo transcurrido total
                $sesion->timeAssigment = $this->calcularTiempoTranscurrido($sesion->startTime);
                $sesion->save();
                $sesion->delete();
            }
        }
        return redirect(route("session.show"));
    }

    public function mostrarCreacion()
    {
        return view("session.nuevaSesion");
    }

    public function cargarUsos()
    {
        return response()->json(Application::orderBy('name')->get());
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

    public function cargarAlumno(string $numControl)
    {
        $alumno = StudentController::search($numControl);

        if ($alumno != null) {
            //Buscar si el estudiante tiene una sesión de préstamo activa
            $prestamo = Loan::where("student_id", "=", $alumno['student_id'])->first();
            if ($prestamo != null) {
                $alumno['prestamo'] = $prestamo->computer_id;
            }
        }
        return response()->json($alumno);
    }

    public function registrarSesion(Request $request)
    {
        $dataSesion = [
            "student_id" => null,
            "student_update_id" => null,
            "computer_id" => $request->equipo,
            "application_id" => $request->uso,
            "timeAssigment" => $request->tiempo,
            "created_by" => auth()->user()->id
        ];

        //Si el número de control ya está registrado
        $actualizacionActual = StudentUpdate::where("controlNumber", $request->numControl)->first();
        if (isset($actualizacionActual)) {
            $dataSesion["student_id"] = $actualizacionActual->student_id;
            $dataSesion["student_update_id"] = $actualizacionActual->id;
        } else {
            $periodoActual = Period::orderByDesc('created_at')->first();

            $alumno = new Student();
            $alumno->name = $request->nombre;
            $alumno->lastName = $request->apellidos;
            $alumno->save();
            $actualizacionActual = new StudentUpdate();
            $actualizacionActual->student_id = $alumno->id;
            $actualizacionActual->controlNumber = $request->numControl;
            $actualizacionActual->career = $request->carrera;
            $actualizacionActual->semester = $request->semestre;
            $actualizacionActual->period_id = $periodoActual->id;
            $actualizacionActual->save();
            $dataSesion["student_id"] = $alumno->id;
            $dataSesion["student_update_id"] = $actualizacionActual->id;
        }
        Loan::create($dataSesion);
        return redirect()->route("session.show");
    }

    public function actualizarTiempo(Request $request)
    {
        $idSesion = $request->get("idSession");
        $sesion = Loan::find($idSesion);
        $extensionTiempo = new Carbon($request->get("timeSession"));

        if ($sesion == null) {
            return response(404);
        }
        $tiempoTranscurrido = $this->calcularTiempoTranscurrido($sesion->startTime);

        //Ajustar la asignación de tiempo 
        $sesion->timeAssigment = TimeFormatU::sumTimeToDate(
            $tiempoTranscurrido,
            hours: $extensionTiempo->format("H"),
            minutes: $extensionTiempo->format("i")
        )->format("H:i");

        $sesion->save();

        return redirect()->route("session.show");
    }

    public function contarSesiones()
    {
        return Loan::count();
    }
}
