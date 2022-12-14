<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Sosialisasi;
use App\SosialisasiFoto;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SosialisasiController extends Controller
{
    public function view(Request $r){
        $sosialisasi = Sosialisasi::with('users')->with('sosialisasiFoto')->orderBy('id','desc')->get();
        return compact('sosialisasi');
    }

    public function detail(Request $r){
        $sosialisasi = Sosialisasi::with('users')->with('sosialisasiFoto')->find($r->id);
        return $sosialisasi;
    }

    public function create(Request $r){
        DB::beginTransaction();
        try {
            $user = User::find($r->users_id);

            $s = new Sosialisasi();
            $s->date = date('Y-m-d');
            $s->judul = $r->judul;
            $s->lokasi = $r->lokasi;
            $s->koordinat = $r->koordinat;
            $s->pemilik = $r->pemilik;
            $s->users_id = $user->id;
            $s->save();

            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }

    public function uploadFoto(Request $r){
        // return $r->all();
        DB::beginTransaction();
        try {

            $foto = $r->file('foto');
            $i = 0;
            foreach ($foto as $f) {
                $if = new SosialisasiFoto();
                $if->sosialisasi_id = $r->sosialisasi_id;
                $if->kategori = $r->kategori[$i];
                $if->foto = 'file/' . date('YmdHis') . '-' . $f->getClientOriginalName();
                $if->save();
                
                $f->move('file', $if->foto);

                $i++;
            }
            
            
            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }
}
