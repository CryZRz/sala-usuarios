<?php

namespace App\Http\Controllers;

use App\Models\Incidence;
use App\Models\Loan;
use App\Models\StudentUpdate;
use Illuminate\Http\Request;

class DashBoardController extends Controller
{
    public function index(){
        $sessions = Loan::withTrashed()->limit(3)->get();
        $activeSessions = Loan::all()->count();
        $activeIncidences = Incidence::all()->count();
        $students = StudentUpdate::getByLastPeriod()->where("active", true)->count();

        $data = [
            "sessions" => $sessions,
            "activeSessions" => $activeSessions,
            "activeIncidences" => $activeIncidences,
            "students" => $students
        ];

        return view("dashboard.index", $data);
    }
}
