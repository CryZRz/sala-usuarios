<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Token;

class UserTokenController extends Controller
{
    public function show(){
        $tokens = DB::table('oauth_access_tokens')->where('user_id', Auth::id())->paginate(10);

        $data = [
            "user" => Auth::user(),
            "tokens" => $tokens
        ];

        return view('profile.tokens', $data);
    }

    public function showApi(Request $request){
        $tokens = Auth::user()->tokens()
            ->paginate(10);

        return response()->json($tokens);
    }

    public function generateToken(Request $request){
        $this->validate($request, [
            "title" => ["required", "string", "max:100"],
        ]);
        $title = $request->get("title");

        $tokens = Auth::user()->tokens()->count();

        if ($tokens >= 10) {
            return response()->json(["message" => "limite de tokens exedido"], 404);
        }

        $token = Auth::user()->createToken($title)->accessToken;

        return response()->json($token);
    }

    public function deleteToken(Request $request,$uuid){
        $token = Token::where('uuid', $uuid)->first();

        if ($token->user_id === Auth::id()) {
            $token->delete();
            return response()->json(["message" => "Token eliminado"], 200);
        }

        return response()->json(["message" => "El token no se puede eliminar"], 404);
    }

    public function create(Request $request){
        return view('profile.createToken', ["user" => Auth::user()]);
    }
}
