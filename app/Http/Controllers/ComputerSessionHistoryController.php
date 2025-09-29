<?php

namespace App\Http\Controllers;

use App\Http\Utils\Interfaces\HasModule;
use App\Models\Application;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComputerSessionHistoryController extends Controller implements HasModule
{

    public function hasModule(): string
    {
        return "computerSessionHistory";
    }

    public function show(Request $request){
        $student = strtolower($request->get("student"));
        $admin = strtolower($request->get("admin"));
        $computerNumber = $request->get("computerNumber");
        $createdAt = $request->get("createdAt");
        $career = $request->get("career");
        $semester = $request->get("semester");

        $applications = Application::all();
        $sessions = Loan::onlyTrashed();

        if (!empty($student)) {
            $sessions->whereHas("student", function ($query) use ($student) {
                $query->where(DB::raw("LOWER(CONCAT(name, ' ', lastName))"), "LIKE", "%$student%");
            });
            $sessions->orWhereHas("studentUpdate", function ($query) use ($student) {
                $query->where("controlNumber", $student);
            });
        }

        if (!empty($admin)) {
            $sessions->whereHas("owner", function ($query) use ($admin) {
                $query->where("name", "LIKE", "%$admin%");
            });
        }

        if (!empty($computerNumber)) {
            $sessions->whereHas("computer", function ($query) use ($computerNumber) {
                $query->where("computer_number", $computerNumber);
            });
        }

        if (!empty($createdAt)) {
            $sessions->whereDate("startTime", "=", $createdAt);
        }

        if (!empty($career)) {
            $sessions->whereHas("studentUpdate", function ($query) use ($career) {
                $query->where("career", $career);
            });
        }

        if (!empty($semester)) {
            $sessions->whereHas("studentUpdate", function ($query) use ($semester) {
                $query->where("semester", $semester);
            });
        }

        $sessionsPag = $sessions->paginate(10)->appends(request()->query());

        $data = [
            "sessions" => $sessionsPag,
            "applications" => $applications,
        ];

        return view('sessionHistory.show', $data);
    }
}
