<?php

namespace App\Http\Controllers;

use App\Unit;
use App\UnitPelaksana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnitPelaksanaController extends Controller
{
    //

    public function index()
    {
        $unit = UnitPelaksana::all();
        return view('unit-pelaksana.view', compact('unit'));
    }

    public function load()
    {
        $data['unit'] = UnitPelaksana::orderBy('nama', 'asc')->get();
        return $data;
    }


    public function create(Request $r)
    {
        DB::beginTransaction();
        try {
            $v = new UnitPelaksana();
            $v->nama = $r->nama;
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
            $v = UnitPelaksana::find($r->id);
            $v->nama = $r->nama;
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
            $v = UnitPelaksana::find($r->id);
            $v->delete();
            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }
}
