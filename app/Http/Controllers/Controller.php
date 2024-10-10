<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

abstract class Controller
{
    public function login(Request $request){
        $email = $request->input('email');
        $password = $request->input('password');
        $user = User::where('email', $email)->where('password','=', $password)->first();
        return response()->json([
            "user"=>$email
            //"password"=>$token
        ], 200);
    }
}
