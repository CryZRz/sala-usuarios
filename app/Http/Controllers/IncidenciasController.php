<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentSearchRequest;
use App\Models\Incidence;
use App\Models\Student;
use App\Models\StudentUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IncidenciasController extends Controller
{
    public function mostrarIncidencias()
    {
        $incidencias = Incidence::orderByDesc("fecha_actualización")->paginate(10);

        $data = [
            "incidencias" => $incidencias,
            "muestra" => "activas"
        ];

        return view("incidences.show", $data);
    }

    public function mostrarIncidenciasResueltas()
    {
        $incidencias = Incidence::onlyTrashed()->orderByDesc("fecha_actualización")->paginate(10);
        $data = [
            "incidencias" => $incidencias,
            "muestra" => "resueltas"
        ];

        return view("incidences.show", $data);
    }

    public function registrarIncidencia(Request $request)
    {
        $valido = Validator::make($request->all(), [
            "controlNumber" => ["required", "exists:student_updates,controlNumber"],
            "descripción" => ["required"]
        ]);

        if ($valido->fails()) {
            $this->validate($request, [
                "name" => ["required"],
                "lastName" => ["required"],
                "semester" => ["required"],
                "career" => ["required"]
            ]);
        }

        //Relacionar con los datos del estudiante más recientes al momento
        $actualizacionActual = StudentUpdate::where("controlNumber", $request->controlNumber)->orderByDesc("created_at")->first();
        if (!isset($actualizacionActual)) {
            $actualizacionActual = StudentController::createStudent($request->toArray());
        }

        $dataIncidencia = [
            "student_update_id" => $actualizacionActual->id,
            "descripción" => $request->descripción,
            "estatus" => "Pendiente",
            "user_id" => auth()->user()->id
        ];
        Incidence::create($dataIncidencia);
        return response()->json([
            'redireccion' => route("incidence.show")
        ], 200);
    }

    public function actualizarIncidencia(Request $request)
    {
        //Revisar si la incidencia está activa
        $incidencia = Incidence::withTrashed()->where("id", $request->id)->first();
        if (isset($incidencia)) {
            $incidencia->descripción = $request->descripción;
            $incidencia->save();
        }
        return redirect()->back();
    }

    public function buscarEstudiante(StudentSearchRequest $request)
    {
        $data = $request->validated();

        if (!isset($data)) {
            return response()->json($request->messages(), 200);
        }
        //Buscar al estudiante, para tomar en cuenta todas las incidencias a través de los cambios de su información
        $actualizacionActual = StudentUpdate::where("controlNumber", $request->controlNumber)->orderByDesc("created_at")->first();
        $alumno = Student::where("id", $actualizacionActual->student()->first()->id)->first();
        $actualizacionesAlumno = StudentUpdate::where("student_id", $alumno->id)->get();

        $idsActualizaciones = $actualizacionesAlumno->map(fn($alumno) => $alumno->id);
        $incidencias = Incidence::withTrashed()->whereIn("student_update_id", $idsActualizaciones)->orderByDesc("fecha_actualización")->get();

        $data = [
            "incidencias" => $incidencias,
            "muestra" => "estudiante"
        ];
        return view("incidences.show", $data);
    }

    public function terminarIncidencia(int $id)
    {
        Incidence::where('id', $id)->update(['estatus' => 'Resuelta']);
        Incidence::destroy($id);
        return redirect()->route("incidence.show");
    }
}