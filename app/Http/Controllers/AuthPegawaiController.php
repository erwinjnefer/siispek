<?php

namespace App\Http\Controllers;

use App\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthPegawaiController extends Controller
{
    
    public function login(Request $r){
        $auth = Pegawai::where('username', $r->username)->where('password', $r->password)->first();
        if($auth != null){
            Session::put('auth', $auth);
            return ['msg' => 'success', 'user' => $auth]; 
        }else{
            return ['msg' => 'failed'];
        }
    }

    public function logout(Request $r){
        $r->session()->flush();
        return redirect('login');
    }
}
