<?php

namespace App\Http\Controllers;

use App\Unit;
use App\User;
use App\UsersUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index()
    {
        $user = User::all();
        $unit = Unit::all();
        return view('user.index', compact('user','unit'));
    }
    
    public function load()
    {
        $data['user'] = User::orderBy('name', 'asc')->get();
        return $data;
    }
    
    
    public function create(Request $r)
    {
        DB::beginTransaction();
        try {
            $user = new User();
            $user->name = $r->name;
            $user->email = $r->email;
            $user->password = Hash::make($r->password);
            $user->status = $r->status;
            $user->save();
            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }
    
    
    public function update(Request $r)
    {
        DB::beginTransaction();
        try {
            $user = User::find($r->id);
            $user->name = $r->name;
            $user->email = $r->email;
            $user->password = Hash::make($r->password);
            $user->status = $r->status;
            $user->save();
            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }
    
    
    
    public function delete(Request $r)
    {
        DB::beginTransaction();
        try {
            $user = User::find($r->id);
            $user->delete();
            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }
    
    public function updateLevelBidang(Request $r){
        $user = User::find($r->id);
        $user->level = $r->level;
        $user->bidang = $r->bidang;
        $user->save();
        return 'success';
    }

    public function validasi(Request $r){
        $user = User::find($r->id);
        $user->status = $r->status;
        $user->save();
        return 'success';
    }

    public function inputNoWa(Request $r){
        $user = User::find($r->id);
        $user->no_wa = $r->no_wa;
        $user->save();
        return 'success';
    }

    public function unitCreate(Request $r){
        // return $r->all();
        $uu = new UsersUnit();
        $uu->users_id = $r->user_id;
        $uu->unit_id = $r->unit_id;
        $uu->save();

        return 'success';
    }
    
    public function unitUpdate(Request $r){
        // return $r->all();
        $uu = UsersUnit::find($r->id);
        $uu->unit_id = $r->unit_id;
        $uu->save();

        return 'success';
    }
}
