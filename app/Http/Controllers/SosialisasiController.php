<?php

namespace App\Http\Controllers;

use App\MapRef;
use App\Sosialisasi;
use App\SosialisasiFoto;
use App\SosialisasiVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SosialisasiController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }
    
    public function view(Request $r){
        $sosialisasi = Sosialisasi::orderBy('id','desc')->get();
        return view('sosialisasi.view', compact('sosialisasi'));
    }

    public function detail(Request $r){
        $sosialisasi = Sosialisasi::find($r->id);
        return view('sosialisasi.detail', compact('sosialisasi'));
    }
    
    public function create(Request $r){
        DB::beginTransaction();
        try {

            $s = new Sosialisasi();
            $s->date = date('Y-m-d', strtotime($r->date));
            $s->kategori = $r->kategori;
            $s->judul = $r->judul;
            $s->lokasi = $r->lokasi;
            $s->koordinat = $r->koordinat;
            $s->pemilik = $r->pemilik;
            $s->id_pel_no_tiang = $r->id_pel_no_tiang;
            $s->users_id = Auth::id();
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

    

    public function deleteFoto(Request $r)
    {
        $if = SosialisasiFoto::find($r->id);
        $if->delete();
        return 'success';
    }


    public function delete(Request $r){
        DB::beginTransaction();
        try {

            $s = Sosialisasi::find($r->id);
            $s->delete();

            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }

    public function gardu(){
        $map_ref = MapRef::where('koordinat_x','!=', NULL)->limit(2300)->get();
        // return $map_ref;
        return view('sosialisasi.map-gardu', compact('map_ref'));
    }

    public function map(){
        $sos = Sosialisasi::all();
        $map_ref = MapRef::where('koordinat_x','!=', NULL)->limit(2000)->get();
        // return $map_ref;
        return view('sosialisasi.map', compact('sos','map_ref'));
    }

    public function sosMap(Request $r){
        $sos = Sosialisasi::find($r->id);
        $map_ref = MapRef::where('koordinat_x','!=', NULL)->limit(2000)->get();
        // return $sos;
        return view('sosialisasi.sos-map', compact('sos','map_ref'));
    }

    public function submitSos(Request $r){
        DB::beginTransaction();
        try {

            $sos = Sosialisasi::find($r->id);
            $sos->submit = 1;
            $sos->save();
            
            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }


}
