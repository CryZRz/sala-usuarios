<?php

namespace App\Http\Controllers\Importes;

use App\Http\Controllers\Importes\ImporteAlumnos;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImporteController extends Controller
{
    public function mostrar()
    {
        return view("importe.index");
    }

    public function subirRegistros(Request $request)
    {
        $rutaRequest = $request->file('archivo')->store('temp');
        $ruta = storage_path('app') . '/' . $rutaRequest;
        $importe = new ImporteAlumnos;
        Excel::import($importe, $ruta);  
        return back()->with('message', $importe->getNumRegistrados());
    }
}