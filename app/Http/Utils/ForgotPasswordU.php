<?php

namespace App\Http\Utils;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordU {
    private string $token;
    private string $email;

    public function  __construct(string $email){
        $this->email = $email;
        $this->token = Str::random(64);
    }

    private function findToken(){
        $tokenDb = DB::table("password_reset_tokens")
            ->where("email", $this->email)
            ->get()
            ->first();

        return $tokenDb ? true : null;
    }

    private function findDataUser(){
        return User::where("email", $this->email)->get()->first();
    }

    private function createTokenOnDb(){
        $tokenDb = $this->findToken();

        if ($tokenDb) {
            DB::table("password_reset_tokens")
                    ->where("email", $this->email)
                    ->update(["token" => $this->token
            ]);
        }else{
            DB::table("password_reset_tokens")->insert([
                "email" => $this->email,
                "token" => $this->token,
                "created_at" => Carbon::now()
            ]);
        }

    }

    public static function removeTokenDb(string $email){
        DB::table("password_reset_tokens")->where("email", $email)->delete();
    }

    private function sendEmailForgotPasssword(){
        $dataUser = $this->findDataUser();
        Mail::send(
            "forgotPassword.email",
            [
                "token" => $this->token,
                "name" => $dataUser->name
            ],
            function($message){
                $message->to($this->email);
                $message->subject('Reset Password');
            }
        );
    }

    public function sendForgotPassword(){
        $this->createTokenOnDb();
        $this->sendEmailForgotPasssword();
    }
}
