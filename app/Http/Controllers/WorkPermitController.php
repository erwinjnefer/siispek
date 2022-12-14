<?php

namespace App\Http\Controllers;

use App\Logs;
use App\Pegawai;
use App\PengawasManuver;
use App\Providers\Whatsapp;
use App\Unit;
use App\User;
use App\WorkOrder;
use App\WorkPermit;
use App\WorkPermitHirarc;
use App\WorkPermitPP;
use App\WorkPermitPPK3;
use App\WorkPermitProsedurKerja;
use App\WoWp;
use App\WpApproval;
use App\WpLampiran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Milon\Barcode\DNS1D;
use PDF;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;

use function Ramsey\Uuid\v1;

class WorkPermitController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth')->except(['print']);
    }

    public function gen()
    {
        $wp = WorkPermit::all();
        foreach ($wp as $wp) {
            if($wp->woWp == null){
                $wo = new WorkOrder();
                $wo->date = $wp->tgl_pengajuan;
                $wo->nama = $wp->detail_pekerjaan;
                $wo->unit_id = $wp->unit_id;
                $wo->users_id = $wp->users_id;
                $wo->spk_no = $wp->spp_no;
                $wo->save();

                $wo_wp = new WoWp();
                $wo_wp->work_order_id = $wo->id;
                $wo_wp->work_permit_id = $wp->id;
                $wo_wp->save();
            }
        }
        return 'done';
    }
    
    public function view(Request $r)
    {
        $date = $r->has('date') ? $r->date : date('Y-m-d');

//         where('tgl_selesai','>=', $date)->
// where('tgl_selesai','>=', $date)->
// where('tgl_selesai','>=', $date)->

        $u = Auth::user();
        $wp = [];
        if($u->status == 'Admin'){
            $wp = WorkPermit::orderBy('id','desc')->get();
        }elseif($u->status == 'Vendor'){
            $wp = WorkPermit::where('users_id', $u->id)->orderBy('id','desc')->get();
        }elseif( (Auth::user()->level == 2 || Auth::user()->level == 3 || Auth::user()->level == 4) && $u->usersUnit != null ){
            $wp = WorkPermit::where('unit_id', $u->usersUnit->unit_id)->orderBy('id','desc')->get();
        }
        return view('wp.view', compact('wp'));
    }
    
    
    
    public function detail(Request $r){
        $data['wp'] = WorkPermit::find($r->id);
        return view('wp.detail', $data);
    }
    
    public function print(Request $r){
        $wp = WorkPermit::find($r->id);
        $pdf = PDF::loadView('wp.export', compact('wp'));
        return $pdf->stream();
        // return view('wp.print', $data);
    }
    
    public function manuverSelect(Request $r){
        $unit_id = $r->id;
        $user = User::where('status','!=','Vendor')->whereHas('usersUnit', function($q)use($unit_id){
            return $q->where('unit_id', $unit_id);
        })->get();
        return $user;
    }

    public function repair(Request $r){
        $wo = WorkOrder::all();
        foreach ($wo as $w) {
            if($w->woWp != null){
                $w->tgl_mulai = $w->woWp->workPermit->tgl_mulai;
                $w->tgl_selesai = $w->woWp->workPermit->tgl_selesai;
                $w->save();
            }
        }
        
        return 'done';
    }
    
    
    
    
    public function form(Request $r){
        $wo = WorkOrder::find($r->id);
        $unit = Unit::all();
        $pengawas_manuver = User::whereHas('usersUnit', function($q)use($wo){
            return $q->where('unit_id', $wo->unit_id);
        })->where('status','Pengawas Manuver')->get();
        // return $pengawas_manuver;

        $pk3 = Pegawai::where('users_id', Auth::id())->where('jabatan','Pengawas K3')->get();
        $pp = Pegawai::where('users_id', Auth::id())->where('jabatan','Pengawas Pekerjaan')->get();
        return view('wp.form', compact('unit','pengawas_manuver','pk3','pp','wo'));
    }
    
    public function formEdit(Request $r){
        $wp = WorkPermit::find($r->id);
        $pengawas_manuver = User::where('status','!=','Vendor')->whereHas('usersUnit', function($q)use($wp){
            return $q->where('unit_id', $wp->unit_id);
        })->get();
        $pk3 = Pegawai::where('users_id', Auth::id())->where('jabatan','Pengawas K3')->get();
        $pp = Pegawai::where('users_id', Auth::id())->where('jabatan','Pengawas Pekerjaan')->get();
        return view('wp.form-edit', compact('wp','pengawas_manuver','pk3','pp'));
    }
    
    public function create(Request $r){
        // return $r->all();
        DB::beginTransaction();
        try {
            $u_id = $r->unit_id;
            $lv3_check = User::where('bidang', $r->bidang)->where('level', 3)->whereHas('usersUnit', function($q)use($u_id){
                return $q->where('unit_id', $u_id);
            })->first();

            // return $lv3_check;
            
            $wp = new WorkPermit();
            $wp->bidang = $r->bidang;
            $wp->lv3_id = ($lv3_check != null) ? $lv3_check->id : 0;
            $wp->tgl_pengajuan = date('Y-m-d', strtotime($r->tgl_pengajuan));
            $wp->spp_no = $r->spp_no;
            $wp->jenis_pekerjaan = $r->jenis_pekerjaan;
            $wp->detail_pekerjaan = $r->detail_pekerjaan;
            $wp->lokasi_pekerjaan = $r->lokasi_pekerjaan;
            // $wp->pengawas_pekerjaan = $r->pengawas_pekerjaan;
            // $wp->no_telp_pengawas = $r->no_telp_pengawas;
            // $wp->pengawas_k3 = $r->pengawas_k3;
            // $wp->no_telp_k3 = $r->no_telp_k3;
            $wp->tgl_mulai = date('Y-m-d', strtotime($r->tgl_mulai));
            $wp->tgl_selesai = date('Y-m-d', strtotime($r->tgl_selesai));
            $wp->jam_mulai = $r->jam_mulai;
            $wp->jam_selesai = $r->jam_selesai;
            $wp->kp1 = $r->kp1;
            $wp->kp2 = $r->kp2;
            $wp->kp3 = $r->kp3;
            $wp->kp4 = $r->kp4;
            if($wp->kp4 == 'on'){
                $wp->kp4_lainnya = $r->kp4_lainnya;
            }
            $wp->kp5 = $r->kp5;
            $wp->kp6 = $r->kp6;
            $wp->kp7 = $r->kp7;
            $wp->kp8 = $r->kp8;
            $wp->kp9 = $r->kp9;
            $wp->kp10 = $r->kp10;
            $wp->p1 = $r->p1;
            $wp->p2 = $r->p2;
            $wp->p3 = $r->p3;
            $wp->p4 = $r->p4;
            if($wp->p4 == 'on'){
                $wp->p4_lainnya = $r->p4_lainnya;
            }
            $wp->p5 = $r->p5;
            $wp->p6 = $r->p6;
            $wp->p7 = $r->p7;
            $wp->p8 = $r->p8;
            $wp->p9 = $r->p9;
            $wp->p10 = $r->p10;
            $wp->l1 = $r->l1;
            $wp->l2 = $r->l2;
            $wp->l3 = $r->l3;
            $wp->l4 = $r->l4;
            $wp->unit_id = $r->unit_id;
            $wp->users_id = Auth::id();
            $wp->save();
            
            $wpApp = new WpApproval();
            $wpApp->work_permit_id = $wp->id;
            $wpApp->save();
            
            $wp_pp = new WorkPermitPP();
            $wp_pp->work_permit_id = $wp->id;
            $wp_pp->pegawai_id = $r->pp_id;
            $wp_pp->save();
            
            $wp_pp = new WorkPermitPPK3();
            $wp_pp->work_permit_id = $wp->id;
            $wp_pp->pegawai_id = $r->pp_k3_id;
            $wp_pp->save();
            
            $wp_pm = new PengawasManuver();
            $wp_pm->work_permit_id = $wp->id;
            $wp_pm->users_id = $r->pengawas_manuver_id;
            $wp_pm->save();

            $wo_wp = new WoWp();
            $wo_wp->work_order_id = $r->work_order_id;
            $wo_wp->work_permit_id = $wp->id;
            $wo_wp->save();

            $wo = WorkOrder::find($r->work_order_id);
            $wo->tgl_mulai = $wp->tgl_mulai;
            $wo->tgl_selesai = $wp->tgl_selesai;
            $wo->progress = 'Create WP';
            $wo->save();

            $logs = new Logs();
            $logs->date = date('Y-m-d H:i:s');
            $logs->nama = "Create work permit";
            $logs->users = Auth::user()->name;
            $logs->work_order_id = $r->work_order_id;
            $logs->save();
            
         
            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }

    public function updateBidang(Request $r){
        $wp = WorkPermit::find($r->id);
        $wp->bidang = $r->bidang;
        $wp->save();
        return 'success';
    }

    public function submitWp(Request $r){
        DB::beginTransaction();
        try {

            $wp = WorkPermit::find($r->id);
            $wp->submit = 1;
            $wp->save();

            $logs = new Logs();
            $logs->date = date('Y-m-d H:i:s');
            $logs->nama = "Submit Work Permit";
            $logs->users = Auth::user()->name;
            $logs->work_order_id = $wp->woWp->work_order_id;
            $logs->save();

            $wo = WorkOrder::find($logs->work_order_id);
            $wo->tgl_mulai = $wp->tgl_mulai;
            $wo->tgl_selesai = $wp->tgl_selesai;
            
            


            $ud = User::where('level', 2)->whereHas('usersUnit', function($q)use($wp){
                return $q->where('unit_id', $wp->unit_id);
            })->first();
            // return $ud;
            
            if($wp->wp_rev == 0){
                $text = "PENGAJUAN WORKING PERMIT oleh ".$wp->users->name.' untuk pekerjaan :'.
                "\nTgl Pekerjaan : ".date('d-m-Y', strtotime($wp->tgl_pengajuan)).
                "\nJenis Pekerjaan : ".$wp->jenis_pekerjaan.
                "\nDetail Pekerjaan : ".$wp->detail_pekerjaan.
                "\nLokasi Pekerjaan : ".$wp->lokasi_pekerjaan.
                "\nPengawas Pekerjaan : ".$wp->workPermitPP->pegawai->nama .
                "\nPengawas K3 Pekerjaan : ".$wp->workPermitPPK3->pegawai->nama.
                "\nPengawas Manuver : ".$wp->pengawasManuver->users->name.
                "\nLokasi Pekerjaan : ".$wp->lokasi_pekerjaan.
                "\nDari tgl : ".$wp->tgl_mulai.' s/d '.$wp->tgl_selesai.
                "\nUntuk lebih detail kunjungi http://sscpln.com/siispek Terimakasih";

                $wo->progress = 'Submit WP';

            }else{
                $text = "Re-SUBMIT WORKING PERMIT oleh ".$wp->users->name.' untuk pekerjaan :'.
                "\nTgl Pekerjaan : ".date('d-m-Y', strtotime($wp->tgl_pengajuan)).
                "\nJenis Pekerjaan : ".$wp->jenis_pekerjaan.
                "\nDetail Pekerjaan : ".$wp->detail_pekerjaan.
                "\nLokasi Pekerjaan : ".$wp->lokasi_pekerjaan.
                "\nPengawas Pekerjaan : ".$wp->workPermitPP->pegawai->nama .
                "\nPengawas K3 Pekerjaan : ".$wp->workPermitPPK3->pegawai->nama.
                "\nPengawas Manuver : ".$wp->pengawasManuver->users->name.
                "\nLokasi Pekerjaan : ".$wp->lokasi_pekerjaan.
                "\nDari tgl : ".$wp->tgl_mulai.' s/d '.$wp->tgl_selesai.
                "\nUntuk lebih detail kunjungi http://sscpln.com/siispek Terimakasih";

                $wo->progress = 'Re-Submit WP';
            }
            if($ud != null && $ud->no_wa != null){
                // $wa = new MBroker();
                // $wa->publish($ud->no_wa,$text,null);
                event(new Whatsapp($ud->no_wa, $text));
            }

            $wo->save();

            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }

    public function reSubmitWp(Request $r){
        DB::beginTransaction();
        try {

            $wp = WorkPermit::find($r->id);
            $wp->reject = 0;
            $wp->save();

            $logs = new Logs();
            $logs->date = date('Y-m-d H:i:s');
            $logs->nama = "Re-Submit Work Permit";
            $logs->users = Auth::user()->name;
            $logs->work_order_id = $wp->woWp->work_order_id;
            $logs->save();


            $ud = User::find($wp->reject_users_id);
            // return $ud;


            
            $text = "RE-SUBMIT WORKING PERMIT oleh ".$wp->users->name.' untuk pekerjaan :'.
            "\nTgl Pekerjaan : ".date('d-m-Y', strtotime($wp->tgl_pengajuan)).
            "\nJenis Pekerjaan : ".$wp->jenis_pekerjaan.
            "\nDetail Pekerjaan : ".$wp->detail_pekerjaan.
            "\nLokasi Pekerjaan : ".$wp->lokasi_pekerjaan.
            "\nPengawas Pekerjaan : ".$wp->workPermitPP->pegawai->nama .
            "\nPengawas K3 Pekerjaan : ".$wp->workPermitPPK3->pegawai->nama.
            "\nPengawas Manuver : ".$wp->pengawasManuver->users->name.
            "\nLokasi Pekerjaan : ".$wp->lokasi_pekerjaan.
            "\nDari tgl : ".$wp->tgl_mulai.' s/d '.$wp->tgl_selesai.
            "\nUntuk lebih detail kunjungi http://sscpln.com/siispek Terimakasih";
            
            if($ud != null && $ud->no_wa != null){
                // $wa = new MBroker();
                // $wa->publish($ud->no_wa,$text,null);
                event(new Whatsapp($ud->no_wa, $text));
            }

            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }
    
    public function sendWa(Request $r){
        DB::beginTransaction();
        try {
            
            $wp = WorkPermit::find($r->id);
            
            $ud = User::where('status','Pejabat Pelaksana K3')->whereHas('usersUnit', function($q)use($wp){
                return $q->where('unit_id', $wp->unit_id);
            })->first();
            
            $um = User::where('status','Manajer')->whereHas('usersUnit', function($q)use($wp){
                return $q->where('unit_id', $wp->unit_id);
            })->first();
            
            $text = "PENGAJUAN WORKING PERMIT oleh ".$wp->users->name.' untuk pekerjaan :'.
            "\nTgl Pekerjaan : ".date('d-m-Y', strtotime($wp->tgl_pengajuan)).
            "\nJenis Pekerjaan : ".$wp->jenis_pekerjaan.
            "\nDetail Pekerjaan : ".$wp->detail_pekerjaan.
            "\nLokasi Pekerjaan : ".$wp->lokasi_pekerjaan.
            "\nPengawas Pekerjaan : ".$wp->workPermitPP->pegawai->nama .
            "\nPengawas K3 Pekerjaan : ".$wp->workPermitPPK3->pegawai->nama.
            "\nPengawas Manuver : ".$wp->pengawasManuver->users->name.
            "\nLokasi Pekerjaan : ".$wp->lokasi_pekerjaan.
            "\nDari tgl : ".$wp->tgl_mulai.' s/d '.$wp->tgl_selesai.
            "\nUntuk lebih detail kunjungi http://sscpln.com/siispek Terimakasih";
            
            if($ud != null && $ud->no_wa != null){
                // $wa = new MBroker();
                // $wa->publish($ud->no_wa,$text,null);
                event(new Whatsapp($ud->no_wa, $text));
            }
            
            if($um != null && $um->no_wa != null){
                // $wa = new MBroker();
                // $wa->publish($um->no_wa,$text,null);
                event(new Whatsapp($ud->no_wa, $text));
            }
            
            DB::commit();
            return redirect('work-permit/detail?id='.$wp->id)->with('msg_ok','Whatsapp telah terkirim !');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }
    
    public function update(Request $r){
        // return $r->all();
        DB::beginTransaction();
        try {
            
            $wp = WorkPermit::find($r->id);
            $wp->tgl_pengajuan = date('Y-m-d', strtotime($r->tgl_pengajuan));
            $wp->spp_no = $r->spp_no;
            $wp->jenis_pekerjaan = $r->jenis_pekerjaan;
            $wp->detail_pekerjaan = $r->detail_pekerjaan;
            $wp->lokasi_pekerjaan = $r->lokasi_pekerjaan;
            
            
            $wp->tgl_mulai = date('Y-m-d', strtotime($r->tgl_mulai));
            $wp->tgl_selesai = date('Y-m-d', strtotime($r->tgl_selesai));
            $wp->jam_mulai = $r->jam_mulai;
            $wp->jam_selesai = $r->jam_selesai;
            $wp->kp1 = $r->kp1;
            $wp->kp2 = $r->kp2;
            $wp->kp3 = $r->kp3;
            $wp->kp4 = $r->kp4;
            $wp->kp4_lainnya = $r->kp4_lainnya;
            $wp->kp5 = $r->kp5;
            $wp->kp6 = $r->kp6;
            $wp->kp7 = $r->kp7;
            $wp->kp8 = $r->kp8;
            $wp->kp9 = $r->kp9;
            $wp->kp10 = $r->kp10;
            $wp->p1 = $r->p1;
            $wp->p2 = $r->p2;
            $wp->p3 = $r->p3;
            $wp->p4 = $r->p4;
            $wp->p4_lainnya = $r->p4_lainnya;
            $wp->p5 = $r->p5;
            $wp->p6 = $r->p6;
            $wp->p7 = $r->p7;
            $wp->p8 = $r->p8;
            $wp->p9 = $r->p9;
            $wp->p10 = $r->p10;
            $wp->l1 = $r->l1;
            $wp->l2 = $r->l2;
            $wp->l3 = $r->l3;
            $wp->l4 = $r->l4;
            // $wp->unit_id = $r->unit_id;
            // $wp->users_id = Auth::id();
            $wp->save();

     

            $wp_pp = WorkPermitPP::find($wp->workPermitPP->id);
            $wp_pp->pegawai_id = $r->pp_id;
            $wp_pp->save();
            
            $wp_pp = WorkPermitPPK3::find($wp->workPermitPPK3->id);
            // $wp_pp->work_permit_id = $wp->id;
            $wp_pp->pegawai_id = $r->pp_k3_id;
            $wp_pp->save();
            
            $wp_pm = PengawasManuver::find($wp->pengawasManuver->id);
            // $wp_pm->work_permit_id = $wp->id;
            $wp_pm->users_id = $r->pengawas_manuver_id;
            $wp_pm->save();
            
            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }
    
    public function approve(Request $r)
    {
        DB::beginTransaction();
        try {
            
            $wa = WpApproval::find($r->id);
            $wp = WorkPermit::find($wa->work_permit_id);

            

            if($r->kategori == 'man_app'){
                $wa->man_app = $r->app;
                $wa->man_app_date = date('Y-m-d H:i:s');
                
                
            }elseif($r->kategori == 'spv_app'){
                $wa->spv_app = $r->app;
                $wa->spv_app_date = date('Y-m-d H:i:s');
                
            }elseif($r->kategori == 'ppk3_app'){
                $wa->ppk3_app = $r->app;
                $wa->ppk3_app_date = date('Y-m-d H:i:s');
            }
            
            $wa->save();

            $text = "APPROVAL WORKING PERMIT oleh ".Auth::user()->name.', Mohon Approval selanjutnya untuk pekerjaan :'.
                "\nTgl Pekerjaan : ".date('d-m-Y', strtotime($wp->tgl_pengajuan)).
                "\nJenis Pekerjaan : ".$wp->jenis_pekerjaan.
                "\nDetail Pekerjaan : ".$wp->detail_pekerjaan.
                "\nLokasi Pekerjaan : ".$wp->lokasi_pekerjaan.
                "\nUntuk lebih detail kunjungi http://sscpln.com/siispek Terimakasih";
            
            if($r->kategori == 'man_app'){
                if($wp->users->no_wa != null){
                    // $was = new MBroker();
                    // $was->publish($wp->users->no_wa, $text, null);
                    event(new Whatsapp($wp->users->no_wa, $text));
                }
            }elseif($r->kategori == 'spv_app'){
                $um = User::where('level', 4)->whereHas('usersUnit', function($q)use($wp){
                    return $q->where('unit_id', $wp->unit_id);
                })->first();
                
                if($um != null && $um->no_wa != null){
                    // $was = new MBroker();
                    // $was->publish($um->no_wa,$text,null);
                    event(new Whatsapp($um->no_wa, $text));
                }
            }elseif($r->kategori == 'ppk3_app'){
                $us = User::where('level', 3)->where('bidang', $wp->bidang)->whereHas('usersUnit', function($q)use($wp){
                    return $q->where('unit_id', $wp->unit_id);
                })->first();

                
                if($us != null && $us->no_wa != null){
                    // $was = new MBroker();
                    // $was->publish($us->no_wa,$text,null);
                    event(new Whatsapp($us->no_wa, $text));
                }
                    
            }

            $logs = new Logs();
            $logs->date = date('Y-m-d H:i:s');
            $logs->nama = "Approval work permit oleh ".Auth::user()->name." (".Auth::user()->status.")";
            $logs->users = Auth::user()->name;
            $logs->work_order_id = $wp->woWp->work_order_id;
            $logs->save();

            $wo = WorkOrder::find($wp->woWp->work_order_id);
            $wo->progress = $logs->nama;
            $wo->save();
            
            
            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
        
    }

    public function reject(Request $r){
        DB::beginTransaction();
        try {
            $wp = WorkPermit::find($r->id);
            $wp->submit = 0;
            $wp->reject_users_id = Auth::id();
            $wp->reject_message = $r->catatan;
            $wp->wp_rev += 1;
            $wp->save();


            $wp_app = WpApproval::find($wp->wpApproval->id);
            $wp_app->ppk3_app = NULL;
            $wp_app->ppk3_app_date = NULL;
            $wp_app->spv_app = NULL;
            $wp_app->spv_app_date = NULL;
            $wp_app->man_app = NULL;
            $wp_app->man_app_date = NULL;
            $wp_app->save();

            $logs = new Logs();
            $logs->date = date('Y-m-d H:i:s');
            $logs->nama = "Permintaan koreksi work permit oleh ".Auth::user()->name." (".Auth::user()->status.")";
            $logs->users = Auth::user()->name;
            $logs->work_order_id = $wp->woWp->work_order_id;
            $logs->save();

            $wo = WorkOrder::find($wp->woWp->work_order_id);
            $wo->progress = $logs->nama;
            $wo->save();

            $text = "Koreksi WORKING PERMIT oleh ".Auth::user()->name." dengan Catatan : ($wp->reject_message) \n".
            "\n\nTgl Pekerjaan : ".date('d-m-Y', strtotime($wp->tgl_pengajuan)).
            "\nJenis Pekerjaan : ".$wp->jenis_pekerjaan.
            "\nDetail Pekerjaan : ".$wp->detail_pekerjaan.
            "\nLokasi Pekerjaan : ".$wp->lokasi_pekerjaan.
            "\nPengawas Pekerjaan : ".$wp->workPermitPP->pegawai->nama .
            "\nPengawas K3 Pekerjaan : ".$wp->workPermitPPK3->pegawai->nama.
            "\nPengawas Manuver : ".$wp->pengawasManuver->users->name.
            "\nLokasi Pekerjaan : ".$wp->lokasi_pekerjaan.
            "\nDari tgl : ".$wp->tgl_mulai.' s/d '.$wp->tgl_selesai.
            "\nUntuk lebih detail kunjungi http://sscpln.com/siispek Terimakasih";

            if($wp->users->no_wa != null){
                event(new Whatsapp($wp->users->no_wa, $text));
            }
            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
        return $r->all();
        
    }
    
    public function hirarcSelect(Request $r){
        // return $r->all();
        DB::beginTransaction();
        try {
            $wph = new WorkPermitHirarc();
            $wph->work_permit_id = $r->wp_id;
            $wph->hirarc_id = $r->hirarc_id;
            $wph->save();
            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }
    
    public function pkSelect(Request $r){
        // return $r->all();
        DB::beginTransaction();
        try {
            $wph = new WorkPermitProsedurKerja();
            $wph->work_permit_id = $r->wp_id;
            $wph->prosedur_kerja_id = $r->pk_id;
            $wph->save();
            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }
    
    public function delete(Request $r){
        DB::beginTransaction();
        try {
            $wp = WorkPermit::find($r->id);
            $wp->delete();
            
            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }
    
    public function export(Request $r){
        $reader = IOFactory::createReader('Xlsx');
        $excel = $reader->load('wp.xlsx');
        
        $wp = WorkPermit::find($r->id);
        $excel->getActiveSheet()->setCellValue('C9', ': '.date('d-m-Y', strtotime($wp->tgl_pengajuan)));
        $excel->getActiveSheet()->setCellValue('C10', ': '.$wp->jenis_pekerjaan);
        $excel->getActiveSheet()->setCellValue('C11', ': '.$wp->detail_pekerjaan);
        $excel->getActiveSheet()->setCellValue('C12', ': '.$wp->lokasi_pekerjaan);
        $excel->getActiveSheet()->setCellValue('C13', ': '.$wp->pengawas_pekerjaan);
        $excel->getActiveSheet()->setCellValue('H13', ': '.$wp->no_telp_pengawas);
        $excel->getActiveSheet()->setCellValue('C13', ': '.$wp->pengawas_pekerjaan);
        $excel->getActiveSheet()->setCellValue('H13', ': '.$wp->no_telp_pengawas);
        $excel->getActiveSheet()->setCellValue('C14', ': '.$wp->pengawas_k3);
        $excel->getActiveSheet()->setCellValue('H14', ': '.$wp->no_telp_k3);
        $excel->getActiveSheet()->setCellValue('D16', ': '.date('d-m-Y', strtotime($wp->tgl_mulai)));
        $excel->getActiveSheet()->setCellValue('D17', ': '.date('d-m-Y', strtotime($wp->tgl_selesai)));
        $excel->getActiveSheet()->setCellValue('H16', ': '.$wp->jam_mulai);
        $excel->getActiveSheet()->setCellValue('H17', ': '.$wp->jam_selesai);
        $excel->getActiveSheet()->setCellValue('A19', ($wp->kp1 == 'on' ? "[✓] Pekerjaan Bertegangan Listrik" : '[     ] Pekerjaan Bertegangan Listrik'));
        $excel->getActiveSheet()->setCellValue('A20', ($wp->kp2 == 'on' ? "[✓] Pekerjaan Overhaul Mesin" : '[     ] Pekerjaan Overhaul Mesin'));
        $excel->getActiveSheet()->setCellValue('A21', ($wp->kp3 == 'on' ? "[✓] Pekerjaan Panas" : '[     ] Pekerjaan Panas'));
        $excel->getActiveSheet()->setCellValue('A22', ($wp->kp4 == 'on' ? "[✓] Pekerjaan Lainnya, sebutkan" : '[     ] Pekerjaan Lainnya, sebutkan'));
        $excel->getActiveSheet()->setCellValue('D19', ($wp->kp5 == 'on' ? "[✓] Pekerjaan di Ketinggian" : '[     ] Pekerjaan di Ketinggian'));
        $excel->getActiveSheet()->setCellValue('D20', ($wp->kp6 == 'on' ? "[✓] Pekerjaan Penggalian" : '[     ] Pekerjaan Penggalian'));
        $excel->getActiveSheet()->setCellValue('D21', ($wp->kp7 == 'on' ? "[✓] Pekerjaan B3 & Limbah B3" : '[     ] Pekerjaan B3 & Limbah B3'));
        $excel->getActiveSheet()->setCellValue('G19', ($wp->kp8 == 'on' ? "[✓] Pekerjaan Penanaman Tiang" : '[     ] Pekerjaan Penanaman Tiang'));
        $excel->getActiveSheet()->setCellValue('G20', ($wp->kp9 == 'on' ? "[✓] Pekerjaan Konstruksi" : '[     ] Pekerjaan Konstruksi'));
        $excel->getActiveSheet()->setCellValue('G21', ($wp->kp10 == 'on' ? "[✓] Pekerjaan Sipil" : '[     ] Pekerjaan Sipil'));
        $excel->getActiveSheet()->setCellValue('A24', ($wp->p1 == 'on' ? "[✓] Pemeliharaan Pembangkit" : '[     ] Pemeliharaan Pembangkit'));
        $excel->getActiveSheet()->setCellValue('A25', ($wp->p2 == 'on' ? "[✓] Pemeliharaan Kubikel" : '[     ] Pemeliharaan Kubikel'));
        $excel->getActiveSheet()->setCellValue('A26', ($wp->p3 == 'on' ? "[✓] Pemeliharaan APP Pelanggan" : '[     ] Pemeliharaan APP Pelanggan'));
        $excel->getActiveSheet()->setCellValue('A27', ($wp->p4 == 'on' ? "[✓] Prosedur Lainnya, sebutkan" : '[     ] Prosedur Lainnya, sebutkan'));
        $excel->getActiveSheet()->setCellValue('D24', ($wp->p5 == 'on' ? "[✓] Pemeliharaan Disribusi" : '[     ] Pemeliharaan Disribusi'));
        $excel->getActiveSheet()->setCellValue('D25', ($wp->p6 == 'on' ? "[✓] PDKB TM" : '[     ] PDKB TM'));
        $excel->getActiveSheet()->setCellValue('D26', ($wp->p7 == 'on' ? "[✓] Pengoperasian Jaringan Baru" : '[     ] Pengoperasian Jaringan Baru'));
        $excel->getActiveSheet()->setCellValue('G24', ($wp->p8 == 'on' ? "[✓] Pemeliharaan Transmisi" : '[     ] Pemeliharaan Transmisi'));
        $excel->getActiveSheet()->setCellValue('G25', ($wp->p9 == 'on' ? "[✓] Pemeliharaan Gardu Induk" : '[     ] Pemeliharaan Gardu Induk'));
        $excel->getActiveSheet()->setCellValue('G26', ($wp->p10 == 'on' ? "[✓] Bongkar Pasang Tiang Beton" : '[     ] Bongkar Pasang Tiang Beton'));
        $excel->getActiveSheet()->setCellValue('A29', ($wp->l1 == 'on' ? "[✓]  Identifikasi Bahaya, Penilaian dan Pengendalian Risiko (HIRARC)" : '[     ]  Identifikasi Bahaya, Penilaian dan Pengendalian Risiko (HIRARC)'));
        $excel->getActiveSheet()->setCellValue('A30', ($wp->l2 == 'on' ? "[✓]  Job Safety Analysis (JSA)" : '[     ]  Job Safety Analysis (JSA)'));
        $excel->getActiveSheet()->setCellValue('E29', ($wp->l3 == 'on' ? "[✓]  Prosedur Kerja" : '[     ]  Prosedur Kerja'));
        $excel->getActiveSheet()->setCellValue('E30', ($wp->l4 == 'on' ? "[✓]  Sertifikasi Kompetensi Pekerja" : '[     ]  Sertifikasi Kompetensi Pekerja'));
        
        
        // $user_app = base64_decode(explode(',', DNS1D::getBarcodeHTML("$employee->barcode", "C39"))[1]);
        // $user_app = base64_encode(QrCode::format('png')->size(100)->generate('Make me into an QrCode!'));
        // $objDrawing = new MemoryDrawing();
        // $objDrawing->setImageResource(imagecreatefromstring($user_app));
        // $objDrawing->setRenderingFunction(MemoryDrawing::RENDERING_JPEG);
        // $objDrawing->setMimeType(MemoryDrawing::MIMETYPE_DEFAULT);
        // $objDrawing->setCoordinates('H34');
        // $objDrawing->setWorksheet($$excel);
        // if($wp->wpApproval->man_app != null){
            
            // }
            
            
            $filename = 'Work Permit - '.$wp->id;
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
            $writer = IOFactory::createWriter($excel, 'Xlsx');
            $writer->save('php://output');
            
        }
    }
    