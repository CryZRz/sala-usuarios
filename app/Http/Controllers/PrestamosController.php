<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentResource;
use App\Http\Utils\CareersE;
use App\Http\Utils\SessionU;
use App\Models\Application;
use App\Models\Computer;
use App\Models\Loan;
use App\Models\Student;
use App\Models\StudentUpdate;
use App\Http\Utils\TimeFormatU;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PrestamosController extends Controller
{

    public function mostrarSesiones()
    {
        $sesiones = Loan::orderByRaw('(startTime + timeAssigment) ASC')->get();


        $sessionAddData = $sesiones->map(function($session){
            $finishTime = SessionU::calculateEndTimeSession(
                $session->startTime,
                new Carbon($session->timeAssigment)
            );
            $timeIntervalFormat = $session->startTime->format("H:i")."-".$finishTime->format("H:i");

            $session->timeInterval = $timeIntervalFormat;
            $session->remainingTime = SessionU::calculateRemainingTime($finishTime);
            $session->finishTime = $finishTime->format("H:i");

            return $session;
        });

        $data = [
            "sesiones" => $sessionAddData
        ];

        return view("session.show", $data);
    }


    public function reasignarEquipo(Request $request)
    {
        $this->validate($request, [
            "computerNumber" => ["required", "numeric", "exists:computers,computer_number"],
            "sessionId" => ["required", "exists:loans,id"]
        ]);

        $computerId = $request->get("computerNumber");
        $sessionId = $request->get("sessionId");

        $computer = Computer::where("computer_number",$computerId)->first();
        $session = Loan::where("computer_id",$computer->id)->first();

        if ($session != null) {
          return redirect()
              ->route("session.show")
              ->with("alert", "la computadora seleccionada esta en uso");
        }

        Loan::find($sessionId)->update(["computer_id"=> $computer->id]);

        return redirect()
            ->route("session.show")
            ->with("alert", "la session se ha actualizado correctamente");
    }

    public function terminarSesion(Request $request)
    {
        $this->validate($request, [
            "sessionId" => ["required", "numeric", "exists:loans,id"]
        ]);

        $sessionId = $request->get("sessionId");
        Loan::find($sessionId)->delete();

        return redirect()->route("session.show");
    }

    public function terminarSesionNumEquio(Request $request)
    {
        $this->validate($request, [
           "computerNumber" => ["required", "numeric", "exists:computers,computer_number"]
        ]);

        $computerNumber = $request->get("computerNumber");
        $computerId = Computer::where("computer_number", $computerNumber)->first()->id;

        Loan::where("computer_id", $computerId)->first()->delete();

        return redirect()
            ->route("session.show")
            ->with("alert", "session terminada correctamente");
    }

    public function terminarSesionNumControl(Request $request)
    {
        $this->validate($request, [
            "controlNumber" => ["required", "numeric", "exists:student_updates,controlNumber"]
        ]);

        $controlNumber = $request->get("controlNumber");
        $student = StudentUpdate::getLastByControlNumber($controlNumber);

        $session = Loan::where("student_id", $student->student_id)->first();

        if ($session != null) {
            $session->delete();
            return redirect()
                ->route("session.show")
                ->with("alert", "session terminada correctamente");
        }

        return redirect()
            ->route("session.show")
            ->with("alert", "El numero de control no tiene una sesión activa");
    }

    public function terminarMultiples(Request $request)
    {
        $this->validate($request, [
            "listSessions" => ["required", "array"],
            "listSessions.*" => ["required", "integer" ,"exists:loans,id"],
        ]);

        $listSessionsIds = $request->get("listSessions");

        foreach ($listSessionsIds as $sessionId) {
            $sessionDb = Loan::find($sessionId);

            $sessionDb->timeAssigment = TimeFormatU::diffHoursDates(
                Carbon::now(),
                new Carbon($sessionDb->startTime)
            );

            $sessionDb->save();
            $sessionDb->delete();
        }

        return response()->json(null, 204);
    }

    public function create()
    {
        $usesPrograms = Application::orderBy('name')->get();
        $careers = CareersE::getCareers();
        $listComputers = SessionU::getListComputersFree();

        $data = [
            "usesPrograms" => $usesPrograms,
            "careers" => $careers,
            "listComputers" => $listComputers
        ];

        return view("session.nuevaSesion", $data);
    }

    public function cargarEquipos()
    {
        return response()->json(SessionU::getListComputersFree());
    }

    public function cargarEquiposUso()
    {
        //Se necesita traer de las sesiones todas aquellas que aun no han terminado
        $loansInUse = Loan::whereNull("endTime")
            ->get()
            ->map(fn($query) => $query->computer_id);

        //Buscamos todas las computadoras que esten en uso
        $computers = Computer::whereIn("id", $loansInUse)->get();

        return response()->json($computers);
    }

    public function getInfoStudentForSession(string $numControl)
    {
        $student = StudentUpdate::getLastByControlNumber($numControl);

        if ($student != null) {
            //Buscar si el estudiante tiene una sesión de préstamo activa
            $session = Loan::where("student_id", $student->student_id)->first();
            if ($session != null) {
                return response()
                    ->json(["error" => "El estudiante tiene una sesión activa"], 409);
            }
            return new StudentResource($student);
        }

        return response()->json(["error" => "El estudiante no esta registrado"], 404);
    }

    public function registrarSesion(Request $request)
    {
        $this->validate($request, [
            "controlNumber" => ["required", "string", "exists:student_updates,controlNumber"],
            "application" => ["required", "exists:applications,id"],
            "computer" => ["required", "exists:computers,id"],
            "timeAssigment" => ["required"],
        ]);

        $controlNumber = $request->get("controlNumber");
        $studentData = StudentUpdate::getLastByControlNumber($controlNumber);
        $student = $studentData->student;
        $loan = Loan::where("student_id", $student->id)->first();

        if ($loan != null){
            return redirect()
                ->route("session.store")
                ->with("alert","El estudiante ya esta en una sesión");
        }

        Loan::create([
            "student_id" => $student->id,
            "student_update_id" => $studentData->id,
            "computer_id" => $request->get("computer"),
            "application_id" => $request->get("application"),
            "timeAssigment" => $request->get("timeAssigment"),
            "created_by" => auth()->user()->id,
        ]);

        return redirect()->route("session.show");
    }

    public  function createSessionAndStudent(Request $request){
        $this->validate($request, [
           "controlNumber" => ["required", "unique:student_updates,controlNumber", "min:8"],
            "name" =>["required"],
            "lastName" => ["required"],
            "career" => ["required", Rule::in(CareersE::getCareers())],
            "semester" => ["required", "numeric", "min:1", "max:13"],
            "application" => ["required", "exists:applications,id"],
            "computer" => ["required", "exists:computers,id"],
            "timeAssigment" => ["required"],
        ]);

        $student = Student::create([
            "name" => $request->get("name"),
            "lastName" => $request->get("lastName"),
        ]);

        $studentData = StudentUpdate::create([
            "student_id" => $student->id,
            "career" => $request->get("career"),
            "controlNumber" => $request->get("controlNumber"),
            "semester" => $request->get("semester"),
            "period_id" => $request->get("application"),
        ]);

        Loan::create([
            "student_id" => $student->id,
            "student_update_id" => $studentData->id,
            "computer_id" => $request->get("computer"),
            "application_id" => $request->get("application"),
            "timeAssigment" => $request->get("timeAssigment"),
            "created_by" => auth()->user()->id,
        ]);

        return redirect()->route("session.show");
    }

    public function actualizarTiempo(Request $request)
    {
        $this->validate($request, [
            "idSession" => ["required", "numeric", "exists:loans,id"],
            "timeSession" => ["required"],
        ]);

        $idSesion = $request->get("idSession");
        $sesion = Loan::find($idSesion);
        $timeToAdd = new Carbon($request->get("timeSession"));


        //Ajustar la asignación de tiempo
        $sesion->timeAssigment = TimeFormatU::sumTimeToDate(
            TimeFormatU::diffHoursDates(Carbon::now(), new Carbon($sesion->startTime)),
            hours: $timeToAdd->format("H"),
            minutes: $timeToAdd->format("i")
        )->format("H:i");

        $sesion->save();

        return redirect()->route("session.show");
    }

    public function checkSessionsActiveUser(Request $request){
        $activeSessionsCount = Loan::where("created_by", auth()->user()->id)->count();

        if ($activeSessionsCount > 0){
            return response()->json(["activeSessions" => $activeSessionsCount], 202);
        }

        return response()->json(["activeSessions" => 0], 404);
    }
}
