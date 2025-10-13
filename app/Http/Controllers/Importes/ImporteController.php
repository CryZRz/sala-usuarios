<?php

namespace App\Http\Controllers\Importes;

use App\Http\Controllers\Controller;
use App\Http\Utils\Interfaces\HasModule;
use App\Imports\StudentsImport;
use App\Models\Import;
use App\Models\PendingImport;
use App\Models\Period;
use App\Models\Student;
use App\Models\StudentUpdate;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ImporteController extends Controller implements HasModule
{

    public function hasModule(): string
    {
        return "ImportStudents";
    }

    public function show()
    {
        $importPeriod = Import::where("period_id", Period::getLastPeriod()->id)->first();

        if ($importPeriod != null) {
            $data = [
                "period" => Period::getLastPeriod(),
                "valid" => false
            ];

            return view("import.show", $data);
        }

        return view("import.show");
    }

    public function destroyPendingImport(string $id){
        $pendingImport = PendingImport::find($id);
        $pendingImport->delete();

        return response(null, 204);
    }

    private function getListHeadersFile($file): array
    {
        $firstRowCheck = new FirstRowCheckImport();
        Excel::import($firstRowCheck, $file);

        return $firstRowCheck->headers;
    }

    public function pendingImport(string $id, Request $request)
    {
        $pendingImport = PendingImport::find($id);

        if ($pendingImport?->is_pending) {
            $file = Storage::disk("imports")->path($pendingImport->filename);
            $headers = $this->getListHeadersFile($file);

            return view("import.bindColumns", ["headers" => $headers, "id" => $id]);
        }
    }

    public function importPending(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);
        $file = request()->file('file');

        if (count($this->getListHeadersFile($file)) > 0) {
            $fileHash = md5_file($file->getRealPath());

            if (Import::where("hash_file", $fileHash)->exists()) {
                return redirect()->route("import.show")->with("error", "El archivo ya se ha subido anteriormente");
            }

            $fileKey = $fileHash."-". Period::getLastPeriod()->name.".".$file->getClientOriginalExtension();

            Storage::disk("imports")->put(
                $fileKey,
                File::get($file)
            );

            $pendingImport = PendingImport::create([
                "filename" => $fileKey,
                "hash_file" => $fileHash,
            ]);

            return redirect()->route("import.showPending", $pendingImport->id);
        }else{
            return redirect()->route("import.show")->with("error", "El archivo no contiene encabezados");
        }
    }

    public function store($id, Request $request)
    {
        $cancel = $request->get("cancel");
        $pendingImport = PendingImport::find($id);

        if ($cancel) {
            $pendingImport->destroy($id);

            return redirect()->route("import.show");
        }

        $request->validate([
            "name" => ["required",],
            "lastName" => ["required"],
            "controlNumber" => ["required"],
            "careerName" => ["required"],
            "careerKey" => ["required"],
            "semester" => ["required"],
            "curp" => ["required"],
        ]);

        if(count($request->all()) != count(array_unique($request->all()))){
            return redirect()->route("import.showPending", $id)->with(
                ["duplicate" => "No debe haber repetidos"]
            );
        }

        $fileHash = PendingImport::find($id);
        $filePath = Storage::disk("imports")->path($fileHash->filename);

        Excel::import(new StudentsImport($request->all()), $filePath);

        Import::create([
            "hash_file" => $fileHash->hash_file,
            "file_name" => $fileHash->filename,
            "period_id" => Period::getLastPeriod()->id,
        ]);

        $pendingImport->is_pending = false;
        $pendingImport->save();
        $this->dropStudents();

        return redirect()->route("import.show");
    }

    private function dropStudents(){
        $lastPeriod = Period::getLastPeriod();

        Student::whereHas("latestStudentUpdate", function($query) use ($lastPeriod) {
            $query->where('period_id', '!=', $lastPeriod->id);
        })
            ->get()
            ->map(function ($student) use ($lastPeriod) {
            if ($student->lastInfo->active) {
                StudentUpdate::create([
                    "student_id" => $student->id,
                    "career" => $student->lastInfo->career,
                    "controlNumber" => $student->lastInfo->controlNumber,
                    "semester" => $student->lastInfo->semester+1,
                    "period_id" => $lastPeriod->id,
                    "active" => false,
                ]);
            }
        });
    }
}
