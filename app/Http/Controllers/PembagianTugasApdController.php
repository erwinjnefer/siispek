<?php

namespace App\Http\Controllers;

use App\Jsa;
use App\JsaPegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembagianTugasApdController extends Controller
{
    //
    public function form(Request $r){
        $data['jsa'] = Jsa::find($r->jsa_id);
        return view('pembagian-tugas-apd.form', $data);
    }
    
    public function save(Request $r){
        // return $r->all();
        DB::beginTransaction();
        try {
            $p = JsaPegawai::find($r->id);
            $p->kondisi = $r->kondisi;
            $p->apd1 = $r->apd1;
            $p->apd2 = $r->apd2;
            $p->apd3 = $r->apd3;
            $p->apd4 = $r->apd4;
            $p->apd5 = $r->apd5;
            $p->apd6 = $r->apd6;
            $p->apd7 = $r->apd7;
            $p->apd8 = $r->apd8;
            $p->apd9 = $r->apd9;
            $p->apd10 = $r->apd10;
            $p->apd11 = $r->apd11;
            $p->apd12 = $r->apd12;
            $p->tugas = $r->tugas;
            $p->save();
            
            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }
}