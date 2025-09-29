<?php

namespace App\Http\Controllers;

use App\Http\Utils\Interfaces\HasModule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller implements HasModule
{

    public function hasModule(): string
    {
        return "users";
    }

    public function show(Request $request){
        $find = $request->input('find');
        $query = User::query();

        if ($find){
            $query->where(DB::raw("CONCAT(name,' ', last_name)"), 'like', '%'.$find.'%');
        }

        $users = $query->paginate(10)->appends(request()->query());

        $data = [
            "users" => $users
        ];

        return view("users.show", $data);
    }
}
