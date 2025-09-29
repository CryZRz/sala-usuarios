<?php

namespace App\Http\Controllers;

use App\Models\AppModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppModuleController extends Controller
{
    public function show(Request $request){
        $find = strtolower($request->get("find"));
        $query = AppModule::query();

        if ($find) {
            $query->where(DB::raw("LOWER(display_name)"), 'like', '%' . $find . '%');
        }

        $appModules = $query->paginate(5);

        return response()->json($appModules);
    }
}
