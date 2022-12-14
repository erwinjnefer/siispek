<?php

namespace App\Http\Controllers;

use App\ProsedurKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProsedurKerjaController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }
    
    public function index()
    {
        $prosedur_kerja = ProsedurKerja::all();
        return view('prosedur_kerja.view', compact('prosedur_kerja'));
    }
    
    public function getByJp(Request $r)
    {
        $data['prosedur_kerja'] = ProsedurKerja::where('jenis_pekerjaan', $r->jp)->orderBy('jenis_pekerjaan', 'asc')->get();
        return $data;
    }
    
    public function getById(Request $r)
    {
        $data = ProsedurKerja::find($r->id);
        return $data;
    }
    
    
    public function create(Request $r)
    {
        DB::beginTransaction();
        try {
            $file = $r->file('file');
            
            $v = new ProsedurKerja();
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
            
            $v = ProsedurKerja::find($r->id);
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
            $v = ProsedurKerja::find($r->id);
            $v->delete();
            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }
}
