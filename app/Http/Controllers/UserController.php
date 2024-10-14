<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login(Request $request){
        $email = $request->input('email');
        $password = $request->input('password');
        $user = User::where('email', $email)->where('password','=', $password)->first();
        $expiresAt = Carbon::now()->addSeconds(60);
        if($user && Hash::check($password, $user->password)){
            $token=$user->createToken('api-token',['*'])->expiresAt($expiresAt)->plainTextToken;
            return response()->json([
                "user"=>$email,
                "token"=>$token,
                "expires_at"=>$expiresAt->toDateTimeString()
                //"password"=>$token
            ], 200);
        }
        return response()->json(["message"=>"You are not Authorized"], 401);
       
    }
    // public function refreshToken(){
    //     $user = Auth::user();
    //     if(!$user->tokenCan('api-token')){
    //     return response()->json(['message'=>'Token invalido o expirado'], 401);
    // }
    // $user->token('api-token')->expiresAt(Carbon::now()->addSeconds(60));
    // return response()->json(['message'=>'Token renovado']);
    // }
    public function users_by_year(Request $request){
        $year = $request->input('year');
        if(!$year){
                $year = request()->year;
        }
        $users = User::select([
        'id', 'name', 'email', 'created_at'
        ])->whereYear('created_at', $year)->get();
        if(count($users)>0){
        return response()->json($users, 200);
        }
        return response()->json([], 400);
       
    }
    public function users_by_month(Request $request){
        $month = $request->input('month');
        if(!$month){
            $month = request()->month;
        }
        $users = User::select([
            'id','name','email','created_at'
        ])->whereMonth('created_at', $month)->get();
        if(count($users)>0){
            return response()->json($users, 200);
        }
        return response()->json([],400);
    }
    public function users_by_week(){
        $usuariosPorSemana=DB::table('users')->select(
            DB::raw('YEAR(created_at) as anio'),
            DB::raw('WEEK(created_at) as semana'),
            DB::raw('COUNT(*) as total_usuarios'))
            ->groupBy('anio', 'semana')->get();
        return response()->json($usuariosPorSemana);
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
    public function update_email(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'email'=>'required|string'
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>'Validation Error',
                'errors'=>$validator->errors()
            ]);
        }
        $user = User::find($id);
        $user->email=$request->input('email');
        $user->update();
        return response()->json(['message'=>'Email succesfully updated']);
    }
    public function update_password(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'password'=>'required|string'
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>'Validation Error',
                'errors'=>$validator->errors()
            ]);
        }
        $user = User::find($id);
        $user->password = $request->input('password');
        $user->update();
        return response()->json(['message'=>'password succesfully updated']);
    }
}
