<?php

namespace App\Http\Controllers;

use App\Imports\JsaTempImport;
use App\Jsa;
use App\JsaImport;
use App\JsaPegawai;
use App\Logs;
use App\Pegawai;
use App\Providers\Whatsapp;
use App\User;
use App\WorkOrder;
use App\WorkPermit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class JsaController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth')->except(['preview']);
    }
    
    public function index(Request $r)
    {
        $wp = WorkPermit::find($r->wp_id);
        $jsa = Jsa::find($wp->jsa->id);
        return view('jsa.view', compact('wp','jsa'));
    }

    public function preview(Request $r)
    {
        $jsa = Jsa::find($r->id);
        $wp = WorkPermit::find($jsa->work_permit_id);

        $pdf = PDF::loadView('jsa.export', compact('wp','jsa'));
        return $pdf->stream();
    }
    
    public function form(Request $r){
        $data['pegawai'] = Pegawai::where('users_id', Auth::id())->where('jabatan','Pelaksana Pekerjaan')->get();
        $data['wp'] = WorkPermit::find($r->wp_id);
        return view('jsa.form', $data);
    }

    public function create(Request $r){
        DB::beginTransaction();
        try {
            // return $r->all();
            // return implode(',', $r->tp5_rambu);
            
            $j = new Jsa();
            $j->work_permit_id = $r->wp_id;
            $j->apd_helm = $r->apd_helm;
            $j->apd_sepatu_safety = $r->apd_sepatu_safety;
            $j->apd_kacamata = $r->apd_kacamata;
            $j->apd_earplug = $r->apd_earplug;
            $j->apd_earmuff = $r->apd_earmuff;
            $j->apd_sarung_tangan_katun = $r->apd_sarung_tangan_katun;
            $j->apd_sarung_tangan_karet = $r->apd_sarung_tangan_karet;
            $j->apd_sarung_tangan_20kv = $r->apd_sarung_tangan_20kv;
            $j->apd_tabung_pernafasan = $r->apd_tabung_pernafasan;
            $j->apd_full_body_harness = $r->apd_full_body_harness;
            $j->apd_lain = $r->apd_lain;
            $j->apd_lain_v = $j->apd_lain == 'on' ? $r->apd_lain_v : '';
            $j->pkd_pemadam_api = $r->pkd_pemadam_api;
            $j->pkd_rambu_keselamatan = $r->pkd_rambu_keselamatan;
            $j->pkd_loto = $r->pkd_loto;
            $j->pkd_radio_komunikasi = $r->pkd_radio_komunikasi;
            $j->pkd_lain = $r->pkd_lain;
            $j->pkd_lain = $r->apd_lain;
            $j->pkd_lain_v = $j->pkd_lain == 'on' ? $r->pkd_lain_v : '';
            $j->lp1 = $r->lp1;
            $j->pbr1 = $r->pbr1;
            $j->tp1 = $r->tp1;
            $j->tp1_apd = $r->has('tp1_apd') ? implode(',', $r->tp1_apd) : '';
            $j->tp1_rambu = $r->has('tp1_rambu') ? implode(',', $r->tp1_rambu) : '';
            $j->lp2 = $r->lp2;
            $j->pbr2 = $r->pbr2;
            $j->tp2 = $r->tp2;
            $j->tp2_apd = $r->has('tp2_apd') ? implode(',', $r->tp2_apd) : '';
            $j->tp2_rambu = $r->has('tp2_rambu') ? implode(',', $r->tp2_rambu) : '';
            $j->lp3 = $r->lp3;
            $j->pbr3 = $r->pbr3;
            $j->tp3 = $r->tp3;
            $j->tp3_apd = $r->has('tp3_apd') ? implode(',', $r->tp3_apd) : '';
            $j->tp3_rambu = $r->has('tp3_rambu') ? implode(',', $r->tp3_rambu) : '';
            $j->lp4 = $r->lp4;
            $j->pbr4 = $r->pbr4;
            $j->tp4 = $r->tp4;
            $j->tp4_apd =$r->has('tp4_apd') ? implode(',', $r->tp4_apd) : '';
            $j->tp4_rambu =$r->has('tp4_rambu') ? implode(',', $r->tp4_rambu) : '';
            $j->lp5 = $r->lp5;
            $j->pbr5 = $r->pbr5;
            $j->tp5 = $r->tp5;
            $j->tp5_apd = $r->has('tp5_apd') ? implode(',', $r->tp5_apd) : '';
            $j->tp5_rambu = $r->has('tp5_rambu') ? implode(',', $r->tp5_rambu) : '';
            $j->lp6 = $r->lp6;
            $j->pbr6 = $r->pbr6;
            $j->tp6 = $r->tp6;
            $j->tp6_apd = $r->has('tp6_apd') ? implode(',', $r->tp6_apd) : '';
            $j->tp6_rambu = $r->has('tp6_rambu') ? implode(',', $r->tp6_rambu) : '';
            $j->lp7 = $r->lp7;
            $j->pbr7 = $r->pbr7;
            $j->tp7 = $r->tp7;
            $j->tp7_apd = $r->has('tp7_apd') ? implode(',', $r->tp7_apd) : '';
            $j->tp7_rambu = $r->has('tp7_rambu') ? implode(',', $r->tp7_rambu) : '';
            $j->lp8 = $r->lp8;
            $j->pbr8 = $r->pbr8;
            $j->tp8 = $r->tp8;
            $j->tp8_apd = $r->has('tp8_apd') ? implode(',', $r->tp8_apd) : '';
            $j->tp8_rambu = $r->has('tp8_rambu') ? implode(',', $r->tp8_rambu) : '';
            $j->lp9 = $r->lp9;
            $j->pbr9 = $r->pbr9;
            $j->tp9 = $r->tp9;
            $j->tp9_apd = $r->has('tp9_apd') ? implode(',', $r->tp9_apd) : '';
            $j->tp9_rambu = $r->has('tp9_rambu') ? implode(',', $r->tp9_rambu) : '';
            $j->lp10 = $r->lp10;
            $j->pbr10 = $r->pbr10;
            $j->tp10 = $r->tp10;
            $j->tp10_apd = $r->has('tp10_apd') ? implode(',', $r->tp10_apd) : '';
            $j->tp10_rambu = $r->has('tp10_rambu') ? implode(',', $r->tp10_rambu) : '';
            $j->save();

            foreach ($r->pp_id as $pp_id) {
                $jsap = new JsaPegawai();
                $jsap->jsa_id = $j->id;
                $jsap->pegawai_id = $pp_id;
                $jsap->save();
            }

            if($r->hasFile('file')){
                JsaImport::where('users_id', Auth::id())->delete();
                Excel::import(new JsaTempImport, $r->file);
                
                $data = JsaImport::where('users_id', Auth::id())->get();
                $c = count($data);

                $jsa = Jsa::find($j->id);
                if($c > 0){
                    $jsa->lp1 = $data[0]->langkah_pekerjaan;
                    $jsa->pbr1 = $data[0]->potensi_bahaya_resiko;
                    $jsa->tp1 = $data[0]->tindakan_pengendalian;
                    $jsa->tp1_apd = $data[0]->apd;
                    $jsa->tp1_rambu = $data[0]->perlengkapan;
                }

                if($c > 1){
                    $jsa->lp2 = $data[1]->langkah_pekerjaan;
                    $jsa->pbr2 = $data[1]->potensi_bahaya_resiko;
                    $jsa->tp2 = $data[1]->tindakan_pengendalian;
                    $jsa->tp2_apd = $data[1]->apd;
                    $jsa->tp2_rambu = $data[1]->perlengkapan;
                }
                if($c > 2){
                    $jsa->lp3 = $data[2]->langkah_pekerjaan;
                    $jsa->pbr3 = $data[2]->potensi_bahaya_resiko;
                    $jsa->tp3 = $data[2]->tindakan_pengendalian;
                    $jsa->tp3_apd = $data[2]->apd;
                    $jsa->tp3_rambu = $data[2]->perlengkapan;
                }
                if($c > 3){
                    $jsa->lp4 = $data[3]->langkah_pekerjaan;
                    $jsa->pbr4 = $data[3]->potensi_bahaya_resiko;
                    $jsa->tp4 = $data[3]->tindakan_pengendalian;
                    $jsa->tp4_apd = $data[3]->apd;
                    $jsa->tp4_rambu = $data[3]->perlengkapan;
                }
                if($c > 4){
                    $jsa->lp5 = $data[4]->langkah_pekerjaan;
                    $jsa->pbr5 = $data[4]->potensi_bahaya_resiko;
                    $jsa->tp5 = $data[4]->tindakan_pengendalian;
                    $jsa->tp5_apd = $data[4]->apd;
                    $jsa->tp5_rambu = $data[4]->perlengkapan;
                }
                if($c > 5){
                    $jsa->lp6 = $data[5]->langkah_pekerjaan;
                    $jsa->pbr6 = $data[5]->potensi_bahaya_resiko;
                    $jsa->tp6 = $data[5]->tindakan_pengendalian;
                    $jsa->tp6_apd = $data[5]->apd;
                    $jsa->tp6_rambu = $data[5]->perlengkapan;
                }
                if($c > 6){
                    $jsa->lp7 = $data[6]->langkah_pekerjaan;
                    $jsa->pbr7 = $data[6]->potensi_bahaya_resiko;
                    $jsa->tp7 = $data[6]->tindakan_pengendalian;
                    $jsa->tp7_apd = $data[6]->apd;
                    $jsa->tp7_rambu = $data[6]->perlengkapan;
                }
                if($c > 7){
                    $jsa->lp8 = $data[7]->langkah_pekerjaan;
                    $jsa->pbr8 = $data[7]->potensi_bahaya_resiko;
                    $jsa->tp8 = $data[7]->tindakan_pengendalian;
                    $jsa->tp8_apd = $data[7]->apd;
                    $jsa->tp8_rambu = $data[7]->perlengkapan;
                }
                if($c > 8){
                    $jsa->lp9 = $data[8]->langkah_pekerjaan;
                    $jsa->pbr9 = $data[8]->potensi_bahaya_resiko;
                    $jsa->tp9 = $data[8]->tindakan_pengendalian;
                    $jsa->tp9_apd = $data[8]->apd;
                    $jsa->tp9_rambu = $data[8]->perlengkapan;
                }
                if($c > 9){
                    $jsa->lp10 = $data[9]->langkah_pekerjaan;
                    $jsa->pbr10 = $data[9]->potensi_bahaya_resiko;
                    $jsa->tp10 = $data[9]->tindakan_pengendalian;
                    $jsa->tp10_apd = $data[9]->apd;
                    $jsa->tp10_rambu = $data[9]->perlengkapan;
                }
                $jsa->save();

            }

            $logs = new Logs();
            $logs->date = date('Y-m-d H:i:s');
            $logs->nama = "Create JSA";
            $logs->users = Auth::user()->name;
            $logs->work_order_id = $j->workPermit->woWp->work_order_id;
            $logs->save();

            $wp = WorkPermit::find($r->wp_id);

            $wo = WorkOrder::find($wp->woWp->work_order_id);
            $wo->tgl_mulai = $wp->tgl_mulai;
            $wo->tgl_selesai = $wp->tgl_selesai;
            $wo->progress = $logs->nama;
            $wo->save();

            $wp = WorkPermit::find($jsa->work_permit_id);
            if($wp->jsa_rev > 0){
                $ud = User::where('level', 2)->whereHas('usersUnit', function($q)use($wp){
                    return $q->where('unit_id', $wp->unit_id);
                })->first();
                // return $ud;
                
                $text = "Re-SUBMIT JSA oleh ".Auth::user()->name.' untuk pekerjaan :'.
                "\nTgl Pekerjaan : ".date('d-m-Y', strtotime($wp->tgl_pengajuan)).
                "\nDetail Pekerjaan : ".$wp->detail_pekerjaan.
                "\nLokasi Pekerjaan : ".$wp->lokasi_pekerjaan.
                "\nUntuk lebih detail kunjungi https://sscpln.com/wp Terimakasih";
                
                if($ud != null && $ud->no_wa != null){
                    // $wa = new MBroker();
                    // $wa->publish($ud->no_wa,$text,null);
                    event(new Whatsapp($ud->no_wa, $text));
                }
            }

            
            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }

    public function review(Request $r)
    {
        // return $r->all();
        DB::beginTransaction();
        try {
            $jsa = Jsa::find($r->jsa_id);
            
            $wp = WorkPermit::find($jsa->work_permit_id);

            $jsa->review = $r->review;
            $jsa->note = $r->note;
            if($jsa->review != 'JSA telah di review dan disetujui'){
                $wp->jsa_rev += 1;
                $wp->save();
            }
            $jsa->save();

            $logs = new Logs();
            $logs->date = date('Y-m-d H:i:s');
            $logs->nama = "Review JSA : $jsa->review";
            $logs->users = Auth::user()->name;
            $logs->work_order_id = $jsa->workPermit->woWp->work_order_id;
            $logs->save();

            $wo = WorkOrder::find($wp->woWp->work_order_id);
            $wo->tgl_mulai = $wp->tgl_mulai;
            $wo->tgl_selesai = $wp->tgl_selesai;
            $wo->progress = $logs->nama;
            $wo->save();

            if($jsa->review != 'JSA telah di review dan disetujui'){
                $text = "Koreksi JSA oleh ".Auth::user()->name." :\n".
                "\nDetail Pekerjaan : ".$jsa->workPermit->detail_pekerjaan.
                "\nTgl. Koreksi : ".date('d-m-Y').
                "\nKoreksi : *".$jsa->note."*".
                
                "\n\nUntuk lebih detail kunjungi https://sscpln.com/wp Terimakasih";
    
                if($jsa->workPermit->users->no_wa != null){
                    event(new Whatsapp($jsa->workPermit->users->no_wa, $text));
                }

            }

            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $th->getMessage();
        }
        
    }

    public function resetJSA(Request $r)
    {
        // return $r->all();
        DB::beginTransaction();
        try {
            $jsa = Jsa::find($r->id);
            

            $logs = new Logs();
            $logs->date = date('Y-m-d H:i:s');
            $logs->nama = "Reset JSA";
            $logs->users = Auth::user()->name;
            $logs->work_order_id = $jsa->workPermit->woWp->work_order_id;
            $logs->save();

            $jsa->delete();

            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $th->getMessage();
        }
        
    }

    public function importAnalisis(Request $r){
        DB::beginTransaction();
        try {
            JsaImport::where('users_id', Auth::id())->delete();
            Excel::import(new JsaTempImport, $r->file);
            
            $data = JsaImport::where('users_id', Auth::id())->get();
            $c = count($data);
            
            $jsa = Jsa::find($r->jsa_id);
            if($c > 0){
                $jsa->lp1 = $data[0]->langkah_pekerjaan;
                $jsa->pbr1 = $data[0]->potensi_bahaya_resiko;
                $jsa->tp1 = $data[0]->tindakan_pengendalian;
                $jsa->tp1_apd = $data[0]->apd;
                $jsa->tp1_rambu = $data[0]->perlengkapan;
            }

            if($c > 1){
                $jsa->lp2 = $data[1]->langkah_pekerjaan;
                $jsa->pbr2 = $data[1]->potensi_bahaya_resiko;
                $jsa->tp2 = $data[1]->tindakan_pengendalian;
                $jsa->tp2_apd = $data[1]->apd;
                $jsa->tp2_rambu = $data[1]->perlengkapan;
            }
            if($c > 2){
                $jsa->lp3 = $data[2]->langkah_pekerjaan;
                $jsa->pbr3 = $data[2]->potensi_bahaya_resiko;
                $jsa->tp3 = $data[2]->tindakan_pengendalian;
                $jsa->tp3_apd = $data[2]->apd;
                $jsa->tp3_rambu = $data[2]->perlengkapan;
            }
            if($c > 3){
                $jsa->lp4 = $data[3]->langkah_pekerjaan;
                $jsa->pbr4 = $data[3]->potensi_bahaya_resiko;
                $jsa->tp4 = $data[3]->tindakan_pengendalian;
                $jsa->tp4_apd = $data[3]->apd;
                $jsa->tp4_rambu = $data[3]->perlengkapan;
            }
            if($c > 4){
                $jsa->lp5 = $data[4]->langkah_pekerjaan;
                $jsa->pbr5 = $data[4]->potensi_bahaya_resiko;
                $jsa->tp5 = $data[4]->tindakan_pengendalian;
                $jsa->tp5_apd = $data[4]->apd;
                $jsa->tp5_rambu = $data[4]->perlengkapan;
            }
            if($c > 5){
                $jsa->lp6 = $data[5]->langkah_pekerjaan;
                $jsa->pbr6 = $data[5]->potensi_bahaya_resiko;
                $jsa->tp6 = $data[5]->tindakan_pengendalian;
                $jsa->tp6_apd = $data[5]->apd;
                $jsa->tp6_rambu = $data[5]->perlengkapan;
            }
            if($c > 6){
                $jsa->lp7 = $data[6]->langkah_pekerjaan;
                $jsa->pbr7 = $data[6]->potensi_bahaya_resiko;
                $jsa->tp7 = $data[6]->tindakan_pengendalian;
                $jsa->tp7_apd = $data[6]->apd;
                $jsa->tp7_rambu = $data[6]->perlengkapan;
            }
            if($c > 7){
                $jsa->lp8 = $data[7]->langkah_pekerjaan;
                $jsa->pbr8 = $data[7]->potensi_bahaya_resiko;
                $jsa->tp8 = $data[7]->tindakan_pengendalian;
                $jsa->tp8_apd = $data[7]->apd;
                $jsa->tp8_rambu = $data[7]->perlengkapan;
            }
            if($c > 8){
                $jsa->lp9 = $data[8]->langkah_pekerjaan;
                $jsa->pbr9 = $data[8]->potensi_bahaya_resiko;
                $jsa->tp9 = $data[8]->tindakan_pengendalian;
                $jsa->tp9_apd = $data[8]->apd;
                $jsa->tp9_rambu = $data[8]->perlengkapan;
            }
            if($c > 9){
                $jsa->lp10 = $data[9]->langkah_pekerjaan;
                $jsa->pbr10 = $data[9]->potensi_bahaya_resiko;
                $jsa->tp10 = $data[9]->tindakan_pengendalian;
                $jsa->tp10_apd = $data[9]->apd;
                $jsa->tp10_rambu = $data[9]->perlengkapan;
            }
            $jsa->save();

            DB::commit();
            return ['msg' => 'success', 'data' => $data];
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }
}
