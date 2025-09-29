<?php

namespace App\Http\Controllers;

use App\Models\Period;
use Illuminate\Http\Request;

class PeriodsController extends Controller
{
    public function index(Request $request){
        $name = $request->input('name');
        $query = Period::query()->orderBy("created_at", "desc");

        if ($name) {
            $query->where("name", "like", "%".$name."%");
        }

        $periods = $query->paginate(5)->appends(request()->query());

        return response()->json($periods);
    }

    public function getById(Period $period){
        return response()->json($period);
    }
}
