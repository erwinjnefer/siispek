<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Jsa;
use App\Logs;
use App\Providers\Whatsapp;
use App\User;
use App\WorkOrder;
use App\WorkPermit;
use App\WpApproval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WorkPermitController extends Controller
{
    public function view(Request $r)
    {

        $u = User::find($r->users_id);
        
        $wp = [];
        if($u->status == 'Admin'){
            $wp = WorkPermit::with('woWp')->with('wpApproval')->with('workPermitPP.pegawai')->with('workPermitPPK3.pegawai')->with('unit')->with('workPermitHirarc.hirarc')->with('workPermitProsedurKerja.prosedurKerja')->with('jsa')->with('inspeksi')->with('users')->orderBy('id','desc')->get();
        }elseif($u->status == 'Vendor'){
            $wp = WorkPermit::with('woWp')->with('wpApproval')->with('workPermitPP.pegawai')->with('workPermitPPK3.pegawai')->with('unit')->with('workPermitHirarc.hirarc')->with('workPermitProsedurKerja.prosedurKerja')->with('jsa')->with('inspeksi')->with('users')->where('users_id', $u->id)->orderBy('id','desc')->get();
        }elseif( ($u->level == 4 ||$u->level == 3 ||$u->level == 2) && $u->usersUnit != null ){
            $wp = WorkPermit::with('woWp')->with('wpApproval')->with('workPermitPP.pegawai')->with('workPermitPPK3.pegawai')->with('unit')->with('workPermitHirarc.hirarc')->with('workPermitProsedurKerja.prosedurKerja')->with('jsa')->with('inspeksi')->with('users')->where('unit_id', $u->usersUnit->unit_id)->orderBy('id','desc')->get();
        }
        return compact('wp');
    }

    public function detail(Request $r){
        // return $r->all();
        $data = WorkPermit::with('wpApproval')->with('workPermitPP.pegawai')->with('workPermitPPK3.pegawai')->with('unit')
        ->with('workPermitHirarc.hirarc')->with('workPermitProsedurKerja.prosedurKerja')->with('jsa.jsaPegawai.pegawai')
        ->with('inspeksi')->with('inspeksi.inspeksiLanjut')->with('inspeksi.inspeksiLanjut.inspeksiFoto')->with('users')->find($r->id);

        return $data;
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
                "\nUntuk lebih detail kunjungi http://sscpln.com/wp Terimakasih";

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
                "\nUntuk lebih detail kunjungi http://sscpln.com/wp Terimakasih";

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

    public function approve(Request $r)
    {
        DB::beginTransaction();
        try {
            
            $wa = WpApproval::find($r->id);
            $wp = WorkPermit::find($wa->work_permit_id);

            

            if($r->kategori == 'man_app'){
                $wa->man_app = 'Accept';
                $wa->man_app_date = date('Y-m-d H:i:s');
                
            }elseif($r->kategori == 'spv_app'){
                $wa->spv_app = 'Accept';
                $wa->spv_app_date = date('Y-m-d H:i:s');

            }elseif($r->kategori == 'ppk3_app'){
                $wa->ppk3_app = 'Accept';
                $wa->ppk3_app_date = date('Y-m-d H:i:s');
            }
            $wa->save();

            $text = "APPROVAL WORKING PERMIT oleh ".Auth::user()->name.', Mohon Approval selanjutnya untuk pekerjaan :'.
                "\nTgl Pekerjaan : ".date('d-m-Y', strtotime($wp->tgl_pengajuan)).
                "\nJenis Pekerjaan : ".$wp->jenis_pekerjaan.
                "\nDetail Pekerjaan : ".$wp->detail_pekerjaan.
                "\nLokasi Pekerjaan : ".$wp->lokasi_pekerjaan.
                "\nUntuk lebih detail kunjungi http://sscpln.com/wp Terimakasih";
            
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

            $wo = WorkOrder::find($logs->work_order_id);
            $wo->progress = $logs->nama;
            $wo->save();
            
            
            DB::commit();
            
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
        
    }

    public function reviewJsa(Request $r)
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

            $wo = WorkOrder::find($logs->work_order_id);
            $wo->progress = $logs->name;
            $wo->save();

            if($jsa->review != 'JSA telah di review dan disetujui'){
                $text = "Koreksi JSA oleh ".Auth::user()->name." :\n".
                "\nDetail Pekerjaan : ".$jsa->workPermit->detail_pekerjaan.
                "\nTgl. Koreksi : ".date('d-m-Y').
                "\nKoreksi : *".$jsa->note."*".
                
                "\n\nUntuk lebih detail kunjungi http://sscpln.com/wp Terimakasih";
    
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

            $wo = WorkOrder::find($logs->work_order_id);
            $wo->progress = $logs->name;
            $wo->save();

            $text = "Koreksi Working Permit oleh ".Auth::user()->name." :\n".
            "\nDetail Pekerjaan : ".$wp->detail_pekerjaan.
            "\nTgl. Koreksi : ".date('d-m-Y').
            "\nCatatan : ".$wp->reject_message.
            
            "\n\nUntuk lebih detail kunjungi http://sscpln.com/wp Terimakasih";

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
}
