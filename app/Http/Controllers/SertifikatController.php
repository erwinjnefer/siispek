<?php

namespace App\Http\Controllers;

use App\Sertifikat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SertifikatController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }
    
    public function index()
    {
        $sertifikat = Sertifikat::all();
        return view('sertifikat.view', compact('sertifikat'));
    }
    
    public function getByJp(Request $r)
    {
        $data['sertifikat'] = Sertifikat::where('jenis_pekerjaan', $r->jp)->orderBy('jenis_pekerjaan', 'asc')->get();
        return $data;
    }
    
    public function getById(Request $r)
    {
        $data = Sertifikat::find($r->id);
        return $data;
    }
    
    
    public function create(Request $r)
    {
        DB::beginTransaction();
        try {
            $file = $r->file('file');
            
            $v = new Sertifikat();
            $v->jenis = $r->jenis;
            $v->pegawai_id = $r->pegawai_id;
            $v->file = 'file/' . date('YmdHis') . '-' . $file->getClientOriginalName();
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
            
            $v = Sertifikat::find($r->id);
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
            $v = Sertifikat::find($r->id);
            $v->delete();
            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }
}
