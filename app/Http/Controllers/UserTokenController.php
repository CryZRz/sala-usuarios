<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserTokenController extends Controller
{
    public function show(){
        return view('tokens.show');
    }

    public function generateToken(Request $request){
        $token = Auth::user()->createToken("Token personal para acceso a los servicios");

        return response()->json(["token" => $token->accessToken]);
    }
}
