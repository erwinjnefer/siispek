<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public $successStatus = 200;
    
    
    public function login(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $auth = Auth::user();
            $user = User::with('usersUnit.unit')->find($auth->id);
            $success['token'] =  $user->createToken('nApp')->accessToken;
            $success['user'] = $user;
            $success['auth'] = 'success';
            return response()->json(['res' => $success], $this->successStatus);
        }
        else{
            return response()->json(['auth' => 'Failed','error'=>'Unauthorised'], 401);
        }
    }

    public function register(Request $request)
    {

        DB::beginTransaction();
        try {
            //code...\
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->no_wa = $request->no_wa;
            $user->save();
            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return "Registrasi gagal !";
        }
        
    }

    public function updateAccount(Request $r){
        DB::beginTransaction();
        try {
            $u = User::find($r->id);
            $u->name = $r->name;
            $u->email = $r->email;
            $u->no_wa = $r->no_wa;
            $u->password = Hash::make($r->password);
            $u->save();
            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            //throw $th
            DB::rollBack();
            return "Error : ".$th->getMessage();
        }
    }

    public function logout(Request $request)
    {
        $logout = $request->user()->token()->revoke();
        if($logout){
            return response()->json([
                'message' => 'Successfully logged out'
            ]);
        }
    }

    public function details()
    {
        $user = Auth::user();
        return response()->json($user, $this->successStatus);
    }
}
