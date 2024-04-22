<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentSearchRequest;
use App\Models\Student;
use App\Models\StudentUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ImporteController extends Controller
{
    public function mostrar(){
        return view("importe.index");
    }
}   