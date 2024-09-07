<?php

namespace App\Http\Controllers\Importes;

use App\Http\Controllers\Controller;
use App\Imports\StudentsImport;
use App\Models\Import;
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

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $importPeriod = Import::where("period_id", Period::getLastPeriod()->id)->first();

        if ($importPeriod != null) {
            $data = [
                "period" => Period::getLastPeriod(),
                "valid" => false
            ];
            return view("import.show", $data);
        }

        $file = request()->file('file');
        $fileHash = md5_file($file->getRealPath());

        $fileInDb = Import::where('hash_file', $fileHash)->first();

        if ($fileInDb != null) {
            return back()->withErrors(["file" => "Ya existe un registro con el mismo archivo"]);
        }else{
            Excel::import(new StudentsImport(), $request->file('file'));

            Import::create([
                "hash_file" => $fileHash,
                "file_name" => $file->getClientOriginalName(),
                "period_id" => Period::getLastPeriod()->id,
            ]);

            Storage::disk("imports")->put(
                $fileHash."-". Period::getLastPeriod()->name.".xlsx",
                File::get($file)
            );
        }

        return back();
    }
}
