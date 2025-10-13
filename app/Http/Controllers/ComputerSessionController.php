<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentUpdateResource;
use App\Http\Utils\CareersE;
use App\Http\Utils\Interfaces\HasModule;
use App\Http\Utils\SessionU;
use App\Models\Application;
use App\Models\Computer;
use App\Models\Loan;
use App\Models\Student;
use App\Models\StudentUpdate;
use App\Http\Utils\TimeFormatU;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ComputerSessionController extends Controller implements HasModule
{

    public function hasModule() :string {
        return 'computerSession';
    }

    public function show(Request $request)
    {
        $find = strtolower($request->get("find"));

        $query = Loan::with("student")
            ->orderByRaw('ADDTIME(startTime, timeAssigment) ASC');

        if ($find) {
            $query->where(function ($q) use ($find) {
                $q->whereHas("studentUpdate", function ($querySUpdate) use ($find) {
                    $querySUpdate->where("controlNumber", $find);
                })->orWhereHas("student", function ($queryStudent) use ($find) {
                    $queryStudent->where(DB::raw("LOWER(CONCAT(name, ' ', lastName))"), "LIKE", "%$find%");
                })->orWhereHas("computer", function ($queryComputer) use ($find) {
                    $queryComputer->where("computer_number", $find);
                });
            });
        }

        $paginated = $query->paginate(10);

        $paginated->getCollection()->transform(function($session){
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
            "sesiones" => $paginated,
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

        $data = [
            "usesPrograms" => $usesPrograms,
        ];

        return view("session.nuevaSesion", $data);
    }

    public function cargarEquipos(Request $request)
    {
        $find = $request->get("find");
        $computers = SessionU::getListComputersFree();

        if($find){
            $computers->where("computer_number", $find);
        }

        $computers = $computers->paginate(10);

        return response()->json($computers);
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

            //Verificamos si el estudiante esta activo
            if(!$student->active){
                return response()->json(["error" => "estudiante no activo"], 422);
            }

            //Buscar si el estudiante tiene una sesión de préstamo activa
            $session = Loan::where("student_id", $student->student_id)->first();
            if ($session != null) {
                return response()
                    ->json(["error" => "El estudiante tiene una sesión activa"], 409);
            }
            return new StudentUpdateResource($student);
        }

        return response()->json(["error" => "El estudiante no esta registrado"], 404);
    }

    public function store(Request $request)
    {
        $computer = Computer::getByComputerNumber($request->get("computer"));

        if (! $computer) {
            return back()->withErrors(['computer' => 'La computadora no existe']);
        }

        $request->merge(['computerId' => $computer->id]);

        $this->validate($request, [
            "controlNumber" => ["required", "string", "exists:student_updates,controlNumber"],
            "application" => ["required", "exists:applications,id"],
            "computer" => ["required", "exists:computers,computer_number"],
            "computerId" => ["required", Rule::unique("loans", "computer_id")->whereNull("endTime")],
            "timeAssigment" => ["required", "date_format:H:i:s"],
        ]);

        $controlNumber = $request->get("controlNumber");
        $studentData = StudentUpdate::getLastByControlNumber($controlNumber);
        $student = $studentData->student;
        $loan = Loan::where("student_update_id", $student->id)->first();

        if ($loan != null){
            return redirect()
                ->route("session.store")
                ->with("alert", "El estudiante ya esta en una sesión");
        }

        Loan::create([
            "student_id" => $student->id,
            "student_update_id" => $studentData->id,
            "computer_id" => $computer->id,
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

        return response()->json(["activeSessions" => $activeSessionsCount], 200);
    }
}
