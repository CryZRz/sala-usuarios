<?php

namespace App\Http\Controllers\Importes;

use App\Http\Controllers\Controller;
use App\Imports\StudentsImport;
use App\Models\Import;
use App\Models\PendingImport;
use App\Models\Period;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ImporteController extends Controller
{
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

    private function getListHeadersFile($file)
    {
        $data = Excel::toArray([], $file);
        $headers = $data[0][0];

        if (count($headers) > 0) {
            $headersFilter = array_filter($headers, fn($header) => $header != null);

            if (count($headersFilter) > 0) {
                return $headersFilter;
            }
        }

        return [];
    }

    public function pendingImport(string $id, Request $request)
    {
        $pendingImport = PendingImport::find($id);

        if ($pendingImport?->is_pending) {
            $file = Storage::disk("imports")->path($pendingImport->hash_file);

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
            $fileKey = $fileHash."-". Period::getLastPeriod()->name.".xlsx";

            Storage::disk("imports")->put(
                $fileKey,
                File::get($file)
            );

            $pendingImport = PendingImport::create([
                "filename" => $file->getFilename(),
                "hash_file" => $fileKey,
            ]);

            return redirect()->route("import.showPending", $pendingImport->id);
        }else{

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
            "career" => ["required"],
            "semester" => ["required"],
        ]);

        if(count($request->all()) != count(array_unique($request->all()))){
            return redirect()->route("import.showPending", $id)->with(
                ["duplicate" => "No debe haber repetidos"]
            );
        }

        $fileHash = PendingImport::find($id);
        $filePath = Storage::disk("imports")->path($fileHash->hash_file);

        Excel::import(new StudentsImport($request->all()), $filePath);

        Import::create([
            "hash_file" => $fileHash->hash_file,
            "file_name" => $fileHash->filename,
            "period_id" => Period::getLastPeriod()->id,
        ]);

        $pendingImport->is_pending = false;
        $pendingImport->save();

        return redirect()->route("import.show");
    }
}
