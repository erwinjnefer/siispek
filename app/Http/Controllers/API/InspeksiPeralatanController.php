<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\InspeksiPeralatan;
use App\MapRef;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InspeksiPeralatanController extends Controller
{
    public function view(Request $r)
    {
        if(Auth::user()->status == 'Vendor'){
            $inspeksi = InspeksiPeralatan::with('users')->with('mapRef')->where('users_id', Auth::id())->orderBy('id','desc')->get();
        }else{
            $inspeksi = InspeksiPeralatan::with('users')->with('mapRef')->orderBy('id','desc')->get();
        }

        return compact('inspeksi');
    }

    public function loadGardu(Request $r)
    {
        $map_ref = MapRef::all();
        return compact('map_ref');
    }

    public function create(Request $r)
    {
        DB::beginTransaction();
        try {
            $foto = $r->file('foto');

            $inspeksi = new InspeksiPeralatan();
            $inspeksi->date = date('Y-m-d');
            $inspeksi->time = date('H:i:s');
            $inspeksi->users_id = Auth::id();
            $inspeksi->map_ref_id = $r->map_ref_id;
            $inspeksi->nama_peralatan = $r->nama_peralatan;
            $inspeksi->koordinat = $r->koordinat;
            $inspeksi->kondisi = $r->kondisi;
            $inspeksi->ket = $r->ket;
            $inspeksi->foto = 'file/' . date('YmdHis') . '-' . $foto->getClientOriginalName();
            $inspeksi->save();

            $foto->move('file', $inspeksi->foto);

            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }
}
