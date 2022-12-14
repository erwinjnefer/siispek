<?php

namespace App\Http\Controllers;

use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnitController extends Controller
{
    public function index()
    {
        $unit = Unit::all();
        return view('unit.view', compact('unit'));
    }

    public function load()
    {
        $data['unit'] = Unit::orderBy('nama', 'asc')->get();
        return $data;
    }


    public function create(Request $r)
    {
        DB::beginTransaction();
        try {
            $v = new Unit();
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
            $v = Unit::find($r->id);
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
            $v = Unit::find($r->id);
            $v->delete();
            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }
}
