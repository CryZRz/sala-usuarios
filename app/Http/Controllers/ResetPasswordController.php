<?php

namespace App\Http\Controllers;

use App\Http\Utils\ForgotPasswordU;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function show(string $token) {
        $findToken = DB::table("password_reset_tokens")->where("token", $token)->first();
        if (!$findToken) {
            return redirect()->route("forgotPassword.show")->with("message", "Token invalido");
        }

        $data = [
            "token" => $findToken->token,
            "email" => $findToken->email
        ];

        return view("resetPassword.show", $data);
    }

    public function store(Request $request){
        $this->validate($request, [
            "email" => ["required", "email", "exists:users,email"],
            "password" => ["required", "string", "min:6", "confirmed"],
            "token" => ["exists:password_reset_tokens,token"],
            "password_confirmation" => ["required"]
        ]);

        $email = $request->get("email");
        $password = $request->get("password");

        User::where("email", $email)->update([
            "password" => Hash::make($password)
        ]);

        ForgotPasswordU::removeTokenDb($email);

        return redirect()->route("login.show");
    }
}
