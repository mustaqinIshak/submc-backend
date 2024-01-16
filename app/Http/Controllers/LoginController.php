<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    //
    public function login(Request $request) {
        $this->validate($request, [
            "username" => "required",
            "password" => "required",
        ]);

        $credentials = request(["username", "password"]);

        if(! $token = auth()
        ->setTTL(60*24)
        ->attempt($credentials)){
            return response()->json([
                "status" => false,
                "error" => 'Unauthorized',
            ], 401);
        }

        return response()->json([
            "status" => true,
            "token" => $token
        ]);

    }
}
