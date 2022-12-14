<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MBroker;
use App\Inspeksi;
use App\InspeksiFoto;
use App\InspeksiLanjut;
use App\Logs;
use App\LogsSwa;
use App\Providers\Whatsapp;
use App\User;
use App\Video;
use App\WorkPermit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InspeksiController extends Controller
{

    public function view(Request $r)
    {

        $u = User::find($r->users_id);
        
        $wp = [];
        if($u->status == 'Admin'){
            $wp = WorkPermit::with('woWp')->with('wpApproval')->with('workPermitPP.pegawai')->with('workPermitPPK3.pegawai')->with('unit')->with('workPermitHirarc.hirarc')->with('workPermitProsedurKerja.prosedurKerja')->with('jsa')->with('inspeksi')->with('users')->orderBy('id','desc')->get();
        }elseif($u->status == 'Vendor'){
            $wp = WorkPermit::with('woWp')->with('wpApproval')->with('workPermitPP.pegawai')->with('workPermitPPK3.pegawai')->with('unit')->with('workPermitHirarc.hirarc')->with('workPermitProsedurKerja.prosedurKerja')->with('jsa')->with('inspeksi')->with('users')->where('users_id', $u->id)->orderBy('id','desc')->get();
        }elseif( ($u->level == 4 ||$u->level == 3 || $u->level == 2) && $u->usersUnit != null ){
            $wp = WorkPermit::with('woWp')->with('wpApproval')->with('workPermitPP.pegawai')->with('workPermitPPK3.pegawai')->with('unit')->with('workPermitHirarc.hirarc')->with('workPermitProsedurKerja.prosedurKerja')->with('jsa')->with('inspeksi')->with('users')->where('unit_id', $u->usersUnit->unit_id)->orderBy('id','desc')->get();
        }
        return compact('wp');
    }

    public function detail(Request $r){
        $data['wp'] = WorkPermit::with('wpApproval')->with('workPermitPP.pegawai')->with('workPermitPPK3.pegawai')->with('unit')
        ->with('workPermitHirarc.hirarc')->with('workPermitProsedurKerja.prosedurKerja')->with('jsa.jsaPegawai.pegawai')
        ->with('inspeksi')->with('inspeksi.inspeksiLanjut')->with('inspeksi.inspeksiMandiri.jsaPegawai.pegawai')->with('inspeksi.inspeksiLanjut.inspeksiFoto')->with('users')->find($r->id);
        $data['video'] = Video::inRandomOrder()->first();
        return $data;
    }

    public function updateInfoK3(Request $r)
    {
        // return $r->all();
        DB::beginTransaction();
        try {
            if($r->id == 'new'){
                $inspeksi = new Inspeksi();
            }else{
                $inspeksi = Inspeksi::find($r->id);
            }
            $inspeksi->tgl_inspeksi = date('Y-m-d');
            $inspeksi->time = date('H:i:s');
            $inspeksi->nama_inspektor = Auth::user()->name;
            $inspeksi->kondisi_pelaksana_pekerjaan = $r->kondisi_pelaksana_pekerjaan;
            $inspeksi->penggunaan_apd = $r->penggunaan_apd;
            $inspeksi->penggunaan_perlengkapan_kerja = $r->penggunaan_perlengkapan_kerja;
            $inspeksi->pemasangan_rambu_k3 = $r->pemasangan_rambu_k3;
            $inspeksi->pemasangan_loto = $r->pemasangan_loto;
            $inspeksi->pemasangan_pembumian = $r->pemasangan_pembumian;
            $inspeksi->pembebasasn_pemeriksaan_tegangan = $r->pembebasasn_pemeriksaan_tegangan;
            $inspeksi->pelaksanaan_breafing = $r->pelaksanaan_breafing;
            $inspeksi->jsa = $r->jsa;
            $inspeksi->sop = $r->sop;
            $inspeksi->wp = $r->wp;
            $inspeksi->work_permit_id = $r->work_permit_id;
            $inspeksi->status = ($inspeksi->workPermit->wpApproval->man_app != NULL) ? 'Open' : 'SWA';
            $inspeksi->save();

            $ud = User::where('level', 2)->whereHas('usersUnit', function($q)use($inspeksi){
                return $q->where('unit_id', $inspeksi->workPermit->unit_id);
            })->first();

            if($inspeksi->status == 'SWA'){
                $logs_swa = new LogsSwa();
                $logs_swa->users_id = $inspeksi->workPermit->users_id;
                $logs_swa->tgl_terbit = date('Y-m-d');
                $logs_swa->temuan = "WP belum di approve Manajer";
                $logs_swa->save();

                $text = "Status SWA untuk pekerjaan :".
                "\nTgl Pekerjaan : ".date('d-m-Y', strtotime($inspeksi->workPermit->tgl_pengajuan)).
                "\nVendor : ".$inspeksi->workPermit->users->name.
                "\nJenis Pekerjaan : ".$inspeksi->workPermit->jenis_pekerjaan.
                "\nDetail Pekerjaan : ".$inspeksi->workPermit->detail_pekerjaan.
                "\nLokasi Pekerjaan : ".$inspeksi->workPermit->lokasi_pekerjaan.
                "\nUntuk lebih detail kunjungi http://sscpln.com/siispek Terimakasih";

                if($ud != null && $ud->no_wa != null){
                    event(new Whatsapp($ud->no_wa, $text));
                }
    
                if($inspeksi->workPermit->workPermitPPK3->pegawai->no_wa != null){
                    event(new Whatsapp($inspeksi->workPermit->users->no_wa, $text));
                }

            }else{
                $text = "Hasil inspeksi mandiri sudah di REVIEW oleh petugas inspeksi (".Auth::user()->name.') untuk pekerjaan :'.
                "\nTgl Pekerjaan : ".date('d-m-Y', strtotime($inspeksi->workPermit->tgl_pengajuan)).
                "\nJenis Pekerjaan : ".$inspeksi->workPermit->jenis_pekerjaan.
                "\nDetail Pekerjaan : ".$inspeksi->workPermit->detail_pekerjaan.
                "\nLokasi Pekerjaan : ".$inspeksi->workPermit->lokasi_pekerjaan.
                "\nUntuk lebih detail kunjungi http://sscpln.com/siispek Terimakasih";
    
                if($ud != null && $ud->no_wa != null){
                    event(new Whatsapp($ud->no_wa, $text));
                }
    
                if($inspeksi->workPermit->workPermitPPK3->pegawai->no_wa != null){
                    event(new Whatsapp($inspeksi->workPermit->workPermitPPK3->pegawai->no_wa, $text));
                }
            }
            
            
            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }

    public function openSwa(Request $r)
    {
        
        DB::beginTransaction();
        try {
            $inspeksi = Inspeksi::find($r->id);
            $inspeksi->status = 'Open';
            $inspeksi->save();
            
            $wo = $inspeksi->workPermit->woWp->workOrder;
            // return $inspeksi->workPermit->woWP;

            $logs = new Logs();
            $logs->date = date('Y-m-d H:i:s');
            $logs->nama = "Open SWA";
            $logs->users = Auth::user()->name;
            $logs->work_order_id = $wo->id;
            $logs->save();

            $msg = "Hi *".$inspeksi->workPermit->users->name."*,\nstatus operasi untuk pekerjaan \n*$wo->nama* telah dibuka. \nUntuk lebih detail kunjungi http://sscpln.com/siispek Terimakasih";
            event(new Whatsapp($wo->users->no_wa, $msg));
            DB::commit();
            return 'success';

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $th->getMessage();
        }
    }

    public function reviewInspeksiMandiri(Request $r)
    {
        // return $r->all();
        DB::beginTransaction();
        try {

            $sa = Inspeksi::find($r->id);
            $sa->review = $r->status_review;
            $sa->catatan_review = $r->catatan;
            $sa->status = $r->status_review == 'SWA' ? 'SWA' : 'Open';
            $sa->save();

            if($sa->review == 'SWA' && $sa->workPermit->workPermitPPK3->pegawai->no_wa != null){
                $text = "Review Inspeksi Mandiri oleh : ".Auth::user()->name.
                "\nJenis Pekerjaan : ".$sa->workPermit->jenis_pekerjaan.
                "\nDetail Pekerjaan : ".$sa->workPermit->detail_pekerjaan.
                "\nLokasi Pekerjaan : ".$sa->workPermit->lokasi_pekerjaan.
                "\n\nStatus Review : ".$sa->review.
                "\nCatatan Review : ".$sa->catatan_review.
                "\nUntuk lebih detail kunjungi http://sscpln.com/siispek Terimakasih";

                event(new Whatsapp($sa->workPermit->workPermitPPK3->pegawai->no_wa, $text));
            }

            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }

    public function inputInspeksiLanjut(Request $r)
    {
        DB::beginTransaction();
        try {
            
            $inspeksi = new InspeksiLanjut();
            $inspeksi->date = date('Y-m-d');
            $inspeksi->time = date('H:i:s');
            $inspeksi->lokasi = $r->lokasi;
            $inspeksi->koordinat = $r->koordinat;
            $inspeksi->catatan_temuan = $r->catatan_temuan;
            $inspeksi->saran_rekomendasi = $r->saran_rekomendasi;
            $inspeksi->tindakan_selanjutnya = $r->tindakan_selanjutnya;
            $inspeksi->inspeksi_id = $r->id;
            $inspeksi->nama_inspektor = Auth::user()->name;
            $inspeksi->kondisi_pelaksana_pekerjaan = $r->kondisi_pelaksana_pekerjaan;
            $inspeksi->penggunaan_apd = $r->penggunaan_apd;
            $inspeksi->penggunaan_perlengkapan_kerja = $r->penggunaan_perlengkapan_kerja;
            $inspeksi->pemasangan_rambu_k3 = $r->pemasangan_rambu_k3;
            $inspeksi->pemasangan_loto = $r->pemasangan_loto;
            $inspeksi->pemasangan_pembumian = $r->pemasangan_pembumian;
            $inspeksi->pembebasasn_pemeriksaan_tegangan = $r->pembebasasn_pemeriksaan_tegangan;
            $inspeksi->pelaksanaan_breafing = $r->pelaksanaan_breafing;
            $inspeksi->jsa = $r->jsa;
            $inspeksi->sop = $r->sop;
            $inspeksi->wp = $r->wp;
            $inspeksi->save();
            
            $sa = Inspeksi::find($r->id);
            $sa->status = ($sa->workPermit->wpApproval->man_app != NULL && $inspeksi->tindakan_selanjutnya != 'Pekerjaan tidak dapat dilanjutkan dan terbitkan SWA (Stop Work Authority)') ? 'Open' : 'SWA';
            $sa->save();
            
            $logs = new Logs();
            $logs->date = date('Y-m-d H:i:s');
            $logs->nama = "Inspeksi K3";
            $logs->users = $inspeksi->nama_inspektor;
            $logs->work_order_id = $sa->workPermit->woWp->work_order_id;
            $logs->save();
            
            $ud = User::where('level', 2)->whereHas('usersUnit', function($q)use($inspeksi){
                return $q->where('unit_id', $inspeksi->inspeksi->workPermit->unit_id);
            })->first();
            
            if($sa->status == 'SWA'){
                $logs_swa = new LogsSwa();
                $logs_swa->users_id = $sa->workPermit->users_id;
                $logs_swa->tgl_terbit = date('Y-m-d');
                $logs_swa->temuan = $inspeksi->catatan_temuan;
                $logs_swa->save();
                
                $text = "Status SWA untuk pekerjaan :".
                "\nTgl Pekerjaan : ".date('d-m-Y', strtotime($sa->workPermit->tgl_pengajuan)).
                "\nVendor : ".$sa->workPermit->users->name.
                "\nJenis Pekerjaan : ".$sa->workPermit->jenis_pekerjaan.
                "\nDetail Pekerjaan : ".$sa->workPermit->detail_pekerjaan.
                "\nLokasi Pekerjaan : ".$sa->workPermit->lokasi_pekerjaan.
                "\nLokasi Inspeksi : ".$inspeksi->lokasi.
                "\nCatatan Temuan : ".$inspeksi->catatan_temuan.
                "\nSaran/Rekomendasi Perbaikan : ".$inspeksi->saran_rekomendasi.
                "\nTindakan Selanjutnya : ".$inspeksi->tindakan_selanjutnya.
                "\nUntuk lebih detail kunjungi http://sscpln.com/siispek Terimakasih";
                
                if($ud != null && $ud->no_wa != null){
                    event(new Whatsapp($ud->no_wa, $text));
                }
                
                if($sa->workPermit->workPermitPPK3->pegawai->no_wa != null){
                    event(new Whatsapp($sa->workPermit->workPermitPPK3->pegawai->no_wa, $text));
                }
            }else{
                $text = "Submit Inspeksi oleh ".$inspeksi->nama_inspektor.' untuk pekerjaan :'.
                "\nTgl Pekerjaan : ".date('d-m-Y', strtotime($inspeksi->inspeksi->workPermit->tgl_pengajuan)).
                "\nJenis Pekerjaan : ".$inspeksi->inspeksi->workPermit->jenis_pekerjaan.
                "\nDetail Pekerjaan : ".$inspeksi->inspeksi->workPermit->detail_pekerjaan.
                "\nLokasi Pekerjaan : ".$inspeksi->inspeksi->workPermit->lokasi_pekerjaan.
                "\nLokasi Inspeksi : ".$inspeksi->lokasi.
                "\nCatatan Temuan : ".$inspeksi->catatan_temuan.
                "\nSaran/Rekomendasi Perbaikan : ".$inspeksi->saran_rekomendasi.
                "\nTindakan Selanjutnya : ".$inspeksi->tindakan_selanjutnya.
                
                "\nUntuk lebih detail kunjungi http://sscpln.com/siispek Terimakasih";
                
                if($ud != null && $ud->no_wa != null){
                    event(new Whatsapp($ud->no_wa, $text));
                }
                
                if($inspeksi->inspeksi->workPermit->workPermitPPK3->pegawai->no_wa != null){
                    event(new Whatsapp($inspeksi->inspeksi->workPermit->workPermitPPK3->pegawai->no_wa, $text));
                }
            }


            
            
            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }

    public function editInspeksiLanjut(Request $r)
    {
        DB::beginTransaction();
        try {
            
            $inspeksi = InspeksiLanjut::find($r->id);
            $inspeksi->date = date('Y-m-d');
            $inspeksi->time = date('H:i:s');
            $inspeksi->lokasi = $r->lokasi;
            $inspeksi->koordinat = $r->koordinat;
            $inspeksi->catatan_temuan = $r->catatan_temuan;
            $inspeksi->saran_rekomendasi = $r->saran_rekomendasi;
            $inspeksi->tindakan_selanjutnya = $r->tindakan_selanjutnya;
            $inspeksi->nama_inspektor = Auth::user()->name;
            $inspeksi->kondisi_pelaksana_pekerjaan = $r->kondisi_pelaksana_pekerjaan;
            $inspeksi->penggunaan_apd = $r->penggunaan_apd;
            $inspeksi->penggunaan_perlengkapan_kerja = $r->penggunaan_perlengkapan_kerja;
            $inspeksi->pemasangan_rambu_k3 = $r->pemasangan_rambu_k3;
            $inspeksi->pemasangan_loto = $r->pemasangan_loto;
            $inspeksi->pemasangan_pembumian = $r->pemasangan_pembumian;
            $inspeksi->pembebasasn_pemeriksaan_tegangan = $r->pembebasasn_pemeriksaan_tegangan;
            $inspeksi->pelaksanaan_breafing = $r->pelaksanaan_breafing;
            $inspeksi->jsa = $r->jsa;
            $inspeksi->sop = $r->sop;
            $inspeksi->wp = $r->wp;
            $inspeksi->save();
            
            $sa = Inspeksi::find($inspeksi->inspeksi_id);
            $sa->status = ($sa->workPermit->wpApproval->man_app != NULL && $inspeksi->tindakan_selanjutnya != 'Pekerjaan tidak dapat dilanjutkan dan terbitkan SWA (Stop Work Authority)') ? 'Open' : 'SWA';
            $sa->save();
            
            $logs = new Logs();
            $logs->date = date('Y-m-d H:i:s');
            $logs->nama = "Inspeksi Lanjut K3";
            $logs->users = $inspeksi->nama_inspektor;
            $logs->work_order_id = $sa->workPermit->woWp->work_order_id;
            $logs->save();
            
            $ud = User::where('level', 2)->whereHas('usersUnit', function($q)use($inspeksi){
                return $q->where('unit_id', $inspeksi->inspeksi->workPermit->unit_id);
            })->first();
            
            if($sa->status == 'SWA'){
                $inspeksi->app_k3_vendor = NULL;
                $inspeksi->app_k3_vendor_date = NULL;
                $inspeksi->save();

                $logs_swa = new LogsSwa();
                $logs_swa->users_id = $sa->workPermit->users_id;
                $logs_swa->tgl_terbit = date('Y-m-d');
                $logs_swa->temuan = $inspeksi->catatan_temuan;
                $logs_swa->save();

                $text = "Status SWA untuk pekerjaan :".
                "\nTgl Pekerjaan : ".date('d-m-Y', strtotime($sa->workPermit->tgl_pengajuan)).
                "\nVendor : ".$sa->workPermit->users->name.
                "\nJenis Pekerjaan : ".$sa->workPermit->jenis_pekerjaan.
                "\nDetail Pekerjaan : ".$sa->workPermit->detail_pekerjaan.
                "\nLokasi Pekerjaan : ".$sa->workPermit->lokasi_pekerjaan.
                "\nLokasi Inspeksi : ".$inspeksi->lokasi.
                "\nCatatan Temuan : ".$inspeksi->catatan_temuan.
                "\nSaran/Rekomendasi Perbaikan : ".$inspeksi->saran_rekomendasi.
                "\nTindakan Selanjutnya : ".$inspeksi->tindakan_selanjutnya.
                "\nUntuk lebih detail kunjungi http://sscpln.com/siispek Terimakasih";
                
                if($ud != null && $ud->no_wa != null){
                    event(new Whatsapp($ud->no_wa, $text));
                }
                
                if($sa->workPermit->workPermitPPK3->pegawai->no_wa != null){
                    event(new Whatsapp($sa->workPermit->workPermitPPK3->pegawai->no_wa, $text));
                }
            }else{
                $text = "Submit Inspeksi Lanjut oleh ".$inspeksi->nama_inspektor.' untuk pekerjaan :'.
                "\nTgl Pekerjaan : ".date('d-m-Y', strtotime($inspeksi->inspeksi->workPermit->tgl_pengajuan)).
                "\nJenis Pekerjaan : ".$inspeksi->inspeksi->workPermit->jenis_pekerjaan.
                "\nDetail Pekerjaan : ".$inspeksi->inspeksi->workPermit->detail_pekerjaan.
                "\nLokasi Pekerjaan : ".$inspeksi->inspeksi->workPermit->lokasi_pekerjaan.
                "\nLokasi Inspeksi : ".$inspeksi->lokasi.
                "\nCatatan Temuan : ".$inspeksi->catatan_temuan.
                "\nSaran/Rekomendasi Perbaikan : ".$inspeksi->saran_rekomendasi.
                "\nTindakan Selanjutnya : ".$inspeksi->tindakan_selanjutnya.
                
                "\nUntuk lebih detail kunjungi http://sscpln.com/siispek Terimakasih";
                
                if($ud != null && $ud->no_wa != null){
                    event(new Whatsapp($ud->no_wa, $text));
                }
                
                if($inspeksi->inspeksi->workPermit->workPermitPPK3->pegawai->no_wa != null){
                    event(new Whatsapp($inspeksi->inspeksi->workPermit->workPermitPPK3->pegawai->no_wa, $text));
                }
            }


            
            
            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }

  

   
    
    

    public function uploadFoto(Request $r){
        DB::beginTransaction();
        try {
            $foto = $r->file('foto');
            
            $if = new InspeksiFoto();
            $if->inspeksi_lanjut_id = $r->inspeksi_lanjut_id;
            $if->datetime = date('Y-m-d H:i:s');
            $if->location = $r->location;
            $if->foto = 'file/' . date('YmdHis') . '-' . $foto->getClientOriginalName();
            $if->save();
            
            $foto->move('file', $if->foto);
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
            
            $inspeksi = InspeksiLanjut::find($r->id);

            $ud = User::where('level', 2)->whereHas('usersUnit', function($q)use($inspeksi){
                return $q->where('unit_id', $inspeksi->inspeksi->workPermit->unit_id);
            })->first();

            $inspeksi->app_k3_pln = Auth::user()->name;
            $inspeksi->app_k3_pln_date = date('Y-m-d');
            $inspeksi->save();

            $text = 'Apporval Inspeksi Pekerjaan Oleh Pejabat K3 :'.
            "\nTgl Inspeksi : ".date('d-m-Y', strtotime($inspeksi->date)).
            "\nJenis Pekerjaan : ".$inspeksi->inspeksi->workPermit->jenis_pekerjaan.
            "\nDetail Pekerjaan : ".$inspeksi->inspeksi->workPermit->detail_pekerjaan.
            "\nLokasi Pekerjaan : ".$inspeksi->lokasi.
            
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

    
}
