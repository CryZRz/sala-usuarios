<?php

namespace App\Http\Controllers;

use App\Http\Utils\updateStudentsU\UpdateStudentsU;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Student;

class UpdateStudentsController extends Controller{
    public function show(){
        return view("updateStudents.show");
    }

    public function store(Request $request){
        /*TODO*/
    }
}
