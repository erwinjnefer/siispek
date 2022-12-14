<?php

namespace App\Http\Controllers;

use App\Pegawai;
use App\User;
use App\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PegawaiVendorController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }
    public function index(Request $r)
    {
        $vendor = User::find($r->id);
        $pegawai = Pegawai::where('users_id', $r->id)->get();
        return view('pegawai-vendor.view', compact('pegawai','vendor'));
    }

    public function load()
    {
        $data['pegawai'] = Pegawai::where('users_id', Auth::id())->orderBy('nama', 'asc')->get();
        return $data;
    }


    public function create(Request $r)
    {
        DB::beginTransaction();
        try {
            $v = new Pegawai();
            $v->nama = $r->nama;
            $v->username = $r->username;
            $v->password = $r->password;
            $v->jabatan = $r->jabatan;
            $v->no_wa = $r->no_wa;
            $v->no_identitas = $r->no_identitas;
            $v->jenis_identitas = $r->jenis_identitas;
            $v->sertifikasi = $r->sertifikasi;
            $v->users_id = $r->vendor_id;
            $v->save();
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
            $v = Pegawai::find($r->id);
            $v->nama = $r->nama;
            $v->username = $r->username;
            $v->password = $r->password;
            $v->jabatan = $r->jabatan;
            $v->no_wa = $r->no_wa;
            $v->no_identitas = $r->no_identitas;
            $v->jenis_identitas = $r->jenis_identitas;
            $v->sertifikasi = $r->sertifikasi;
            $v->save();
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
            $v = Pegawai::find($r->id);
            $v->delete();
            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }
}
