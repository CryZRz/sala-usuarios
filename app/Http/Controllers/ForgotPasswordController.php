<?php

namespace App\Http\Controllers;

use App\Http\Utils\ForgotPasswordU;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function show(){
        return view("forgotPassword.show");
    }

    public function store(Request $request){
        $this->validate($request, [
            "email" => ["email", "exists:users,email"]
        ], [
            "email.exists" => "El email no ha sido registrado"
        ]);

        $email = trim($request->get("email"));
        $forgotPass = new ForgotPasswordU($email);
        $forgotPass->sendForgotPassword();

        return redirect()->route("forgotPassword.show")->with("success", "Correo enviado correctamente");
    }
}
