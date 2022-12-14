<?php

namespace App\Http\Controllers;

use App\Hirarc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HirarcController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }
    
    public function index()
    {
        $hirarc = Hirarc::all();
        return view('hirarc.view', compact('hirarc'));
    }
    
    public function getByJp(Request $r)
    {
        $data['hirarc'] = Hirarc::where('jenis_pekerjaan', $r->jp)->orderBy('jenis_pekerjaan', 'asc')->get();
        return $data;
    }
    
    public function getById(Request $r)
    {
        $data = Hirarc::find($r->id);
        return $data;
    }
    
    
    public function create(Request $r)
    {
        DB::beginTransaction();
        try {
            $file = $r->file('file');
            
            $v = new Hirarc();
            $v->jenis_pekerjaan = $r->jenis_pekerjaan;
            $v->file = 'file/' . date('YmdHis') . '-' . $file->getClientOriginalName();
            $v->ket = $r->ket;
            $v->save();
            
            $file->move('file', $v->file);
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
            $file = $r->file('file');
            
            $v = Hirarc::find($r->id);
            $v->jenis_pekerjaan = $r->jenis_pekerjaan;
            $v->ket = $r->ket;
            if($file != null){
                $v->file = 'file/' . date('YmdHis') . '-' . $file->getClientOriginalName();
            }
            $v->save();
            if($file != null){
                $file->move('file', $v->file);
            }
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
            $v = Hirarc::find($r->id);
            $v->delete();
            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }
}
