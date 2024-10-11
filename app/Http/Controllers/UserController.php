<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
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
    public function users_by_year(Request $request){
        $year = $request->input('year');
        $user = User::where('year', $year);
       
    }
    public function add_user(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required|string|max:70',
            'email'=>'required|string|max:50',
            'password'=>'required|string|max:20',
            'administrador'=>'required|boolean'
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>'Validation Error',
                'Errors'=>$validator->errors(),
            ], 400);
        }
        $user = new User();
        $user->name=$request->input('name');
        $user->email=$request->input('email');
        $user->password=$request->input('password');
        $user->administrador=$request->input('administrador');
        $user->save();

        return response()->json(['message'=>'Successfully registered'], 201);
    }
}
