<?php

namespace App\Http\Controllers;

use App\Inspeksi;
use App\InspeksiFoto;
use App\InspeksiLanjut;
use App\InspeksiMandiri;
use App\InspeksiVideo;
use App\Jsa;
use App\Logs;
use App\LogsSwa;
use App\Providers\Whatsapp;
use App\User;
use App\WorkPermit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PDF;
use Symfony\Component\Console\Input\Input;

class FPageController extends Controller
{
    public function index(Request $r){
        if($r->session()->has('auth')){
            $pegawai = Session::get('auth');
            $wp = WorkPermit::where('users_id', $pegawai->users_id)->orderBy('id','desc')->get();
            return view('fpage.index', compact('wp'));
        }else{
            return redirect('login');
        }
    }

    public function detail(Request $r){
        $wp = WorkPermit::find($r->id);
        if($wp->inspeksi == null){
            $inspeksi = new Inspeksi();
            $inspeksi->status = 'Open';
            $inspeksi->work_permit_id = $r->id;
            $inspeksi->save();
        }
        $ppk3 = User::where('status','Pejabat Pelaksana K3')->whereHas('usersUnit',function($q)use($wp){
            return $q->where('unit_id', $wp->unit_id);
        })->first();
        // return $wp->jsa->jsaPegawai[0]->pegawai;
        
        return view('fpage.inspeksi-detail', compact('wp','ppk3'));
    }

    public function inspeksiMandiri(Request $r)
    {
        // return $r->all();
        DB::beginTransaction();
        try {
            InspeksiMandiri::where('jsa_pegawai_id', $r->jsa_pegawai_id)->delete();
          
            $wp = WorkPermit::find($r->wp_id);
            $inspeksi = Inspeksi::find($r->id);

            $im = new InspeksiMandiri();
            $im->tgl_inspeksi = date('Y-m-d');
            $im->time = date('H:i:s');
            $im->inspeksi_id = $r->id;
            $im->jsa_pegawai_id = $r->jsa_pegawai_id;
            $im->kondisi_pelaksana_pekerjaan = $r->kondisi_pelaksana_pekerjaan;
            $im->penggunaan_apd = $r->penggunaan_apd;
            $im->penggunaan_perlengkapan_kerja = $r->penggunaan_perlengkapan_kerja;
            $im->pemasangan_rambu_k3 = $r->pemasangan_rambu_k3;
            $im->pemasangan_loto = $r->pemasangan_loto;
            $im->pemasangan_pembumian = $r->pemasangan_pembumian;
            $im->pembebasasn_pemeriksaan_tegangan = $r->pembebasasn_pemeriksaan_tegangan;
            $im->pelaksanaan_breafing = $r->pelaksanaan_breafing;
            $im->jsa = $r->jsa;
            $im->sop = $r->sop;
            $im->wp = $r->wp;
            $im->save();

            $logs = new Logs();
            $logs->date = date('Y-m-d H:i:s');
            $logs->nama = "Inspeksi Mandiri";
            $logs->users = Session::get('auth')->nama;
            $logs->work_order_id = $inspeksi->workPermit->woWp->work_order_id;
            $logs->save();

            

            $ud = User::where('level', 2)->whereHas('usersUnit', function($q)use($inspeksi){
                return $q->where('unit_id', $inspeksi->workPermit->unit_id);
            })->first();

            if($inspeksi->status == 'SWA'){
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
                $text = "Submit Inspeksi Mandiri oleh ".$im->jsaPegawai->pegawai->nama.' untuk pekerjaan :'.
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

            $ud = User::where('level', 2)->whereHas('usersUnit', function($q)use($sa){
                return $q->where('unit_id', $sa->workPermit->unit_id);
            })->first();

            if($sa->review == 'SWA' && $ud->no_wa != null){
                $text = "Review Inspeksi Mandiri oleh : ".Session::get('auth')->nama.
                "\nJenis Pekerjaan : ".$sa->workPermit->jenis_pekerjaan.
                "\nDetail Pekerjaan : ".$sa->workPermit->detail_pekerjaan.
                "\nLokasi Pekerjaan : ".$sa->workPermit->lokasi_pekerjaan.
                "\n\nStatus Review : ".$sa->review.
                "\nCatatan Review : ".$sa->catatan_review.
                "\nUntuk lebih detail kunjungi http://sscpln.com/siispek Terimakasih";

                event(new Whatsapp($ud->no_wa, $text));
                
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
            $pegawai = Session::get('auth');

            $inspeksi = new InspeksiLanjut();
            $inspeksi->date = date('Y-m-d');
            $inspeksi->time = date('H:i:s');
            $inspeksi->lokasi = $r->lokasi;
            $inspeksi->catatan_temuan = $r->catatan_temuan;
            $inspeksi->saran_rekomendasi = $r->saran_rekomendasi;
            $inspeksi->tindakan_selanjutnya = $r->tindakan_selanjutnya;
            $inspeksi->inspeksi_id = $r->id;
            $inspeksi->nama_inspektor = $pegawai->nama;
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
            $sa->status = ($sa->workPermit->wpApproval->man_app != NULL && $inspeksi->tindakan_selanjutnya != 'Pekerjaan tidak dapat dilanjutkan dan diterbitkan SWA (stop work authority)') ? 'Open' : 'SWA';
            $sa->save();

            $ud = User::where('level', 2)->whereHas('usersUnit', function($q)use($inspeksi){
                return $q->where('unit_id', $inspeksi->inspeksi->workPermit->unit_id);
            })->first();

           

            $logs = new Logs();
            $logs->date = date('Y-m-d H:i:s');
            $logs->nama = "Inspeksi K3";
            $logs->users = $pegawai->nama;
            $logs->work_order_id = $sa->workPermit->woWp->work_order_id;
            $logs->save();

            if($sa->status == 'SWA'){
                $logs_swa = new LogsSwa();
                $logs_swa->users_id = $sa->workPermit->users_id;
                $logs_swa->tgl_terbit = date('Y-m-d');
                $logs_swa->temuan = $inspeksi->catatan_temuan;
                $logs_swa->pekerjaan = $sa->workPermit->detail_pekerjaan;
                $logs_swa->save();
                
                $text = "Status SWA untuk pekerjaan :".
                "\nTgl Pekerjaan : ".date('d-m-Y', strtotime($sa->workPermit->tgl_pengajuan)).
                "\nVendor : ".$sa->workPermit->users->name.
                "\nJenis Pekerjaan : ".$sa->workPermit->jenis_pekerjaan.
                "\nDetail Pekerjaan : ".$sa->workPermit->detail_pekerjaan.
                "\nLokasi Pekerjaan : ".$sa->workPermit->lokasi_pekerjaan.
                "\nUntuk lebih detail kunjungi http://sscpln.com/siispek Terimakasih";

                if($ud != null && $ud->no_wa != null){
                    event(new Whatsapp($ud->no_wa, $text));
                }
    
                if($sa->workPermit->workPermitPPK3->pegawai->no_wa != null){
                    event(new Whatsapp($sa->workPermit->users->no_wa, $text));
                }
            }else{
                $text = "Submit Inspeksi Lanjut oleh ".$pegawai->nama.' untuk pekerjaan :'.
                "\nTgl Pekerjaan : ".date('d-m-Y', strtotime($inspeksi->inspeksi->workPermit->tgl_pengajuan)).
                "\nJenis Pekerjaan : ".$inspeksi->inspeksi->workPermit->jenis_pekerjaan.
                "\nDetail Pekerjaan : ".$inspeksi->inspeksi->workPermit->detail_pekerjaan.
                "\nLokasi Pekerjaan : ".$inspeksi->inspeksi->workPermit->lokasi_pekerjaan.
                "\nLokasi Inspeksi : ".$inspeksi->lokasi.
                "\nCatatan Temuan : ".$inspeksi->catatan_temuan.
                "\nSaran/Rekomendasi Perbaikan : ".$inspeksi->saran_rekomendasi.
                "\nTindakan Selanjutnya : ".$inspeksi->tindakan_selanjutnya.
                
                "\nUntuk lebih detail kunjungi http://sscpln.com/siispek/inspeksi/detail?id=".$inspeksi->inspeksi->work_permit_id.". Terimakasih";
    
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
            $inspeksi->lokasi = $r->lokasi;
            $inspeksi->catatan_temuan = $r->catatan_temuan;
            $inspeksi->saran_rekomendasi = $r->saran_rekomendasi;
            $inspeksi->tindakan_selanjutnya = $r->tindakan_selanjutnya;
            $inspeksi->save();
            
            
            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }

    public function submitInspeksi(Request $r)
    {
        DB::beginTransaction();
        try {
            
            $inspeksi = Inspeksi::find($r->id);
            $inspeksi->submit = 1;
            $inspeksi->save();

            $logs = new Logs();
            $logs->date = date('Y-m-d H:i:s');
            $logs->nama = "Submit inspeksi";
            $logs->users = Session::get('auth')->nama;
            $logs->work_order_id = $inspeksi->workPermit->woWp->work_order_id;
            $logs->save();

            $pegawai = $inspeksi->workPermit->workPermitPPK3->pegawai;

            $text = "Submit Inspeksi Pekerjaan oleh ".Session::get('auth')->nama.' untuk pekerjaan :'.
            "\nTgl Pekerjaan : ".date('d-m-Y', strtotime($inspeksi->workPermit->tgl_pengajuan)).
            "\nJenis Pekerjaan : ".$inspeksi->workPermit->jenis_pekerjaan.
            "\nDetail Pekerjaan : ".$inspeksi->workPermit->detail_pekerjaan.
            "\nLokasi Pekerjaan : ".$inspeksi->workPermit->lokasi_pekerjaan.
            
            "\nUntuk lebih detail kunjungi http://sscpln.com/siispek Terimakasih";

            if($pegawai->no_wa != null){
                event(new Whatsapp($pegawai->no_wa, $text));
            }
            
            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }

    public function reqOpenSwa(Request $r){
        // return $r->all();
        DB::beginTransaction();
        try {
            $file = $r->file('file');
            
            $inspeksi = Inspeksi::find($r->id);
            $inspeksi->jenis_dokumen = $r->jenis_dokumen;
            $inspeksi->req_open_swa = 1;
            $inspeksi->req_open_swa_file = 'file/' . date('YmdHis') . '-' . $file->getClientOriginalName();
            $inspeksi->save();
            
            $file->move('file',$inspeksi->req_open_swa_file);

            $ud = User::where('level', 2)->whereHas('usersUnit', function($q)use($inspeksi){
                return $q->where('unit_id', $inspeksi->workPermit->unit_id);
            })->first();
            
            $text = "Request OPEN SWA untuk pekerjaan :".
            "\nTgl Pekerjaan : ".date('d-m-Y', strtotime($inspeksi->workPermit->tgl_pengajuan)).
            "\nJenis Pekerjaan : ".$inspeksi->workPermit->jenis_pekerjaan.
            "\nDetail Pekerjaan : ".$inspeksi->workPermit->detail_pekerjaan.
            "\nLokasi Pekerjaan : ".$inspeksi->workPermit->lokasi_pekerjaan.
            "\nUntuk lebih detail kunjungi http://sscpln.com/siispek Terimakasih";
            
            if($ud != null && $ud->no_wa != null){
                event(new Whatsapp($ud->no_wa, $text));
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
            $if->inspeksi_lanjut_id = $r->inspeksi_id;
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
            $inspeksiLanjut = InspeksiLanjut::find($r->id);
            $inspeksi = Inspeksi::find($inspeksiLanjut->inspeksi_id);
            
            $inspeksiLanjut->app_k3_vendor_date = date('Y-m-d H:i:s');
            $inspeksiLanjut->app_k3_vendor = Session::get('auth')->nama;
            $inspeksiLanjut->tindakan_selanjutnya = 'Pekerjaan dapat dilanjutkan';
                // $inspeksi->app_k3_vendor_sign = $this->createImage($r->sign_url);
            
            $inspeksiLanjut->save();

            $logs = new Logs();
            $logs->date = date('Y-m-d H:i:s');
            $logs->nama = "Approve inspeksi";
            $logs->users = Session::get('auth')->nama;
            $logs->work_order_id = $inspeksi->workPermit->woWp->work_order_id;
            $logs->save();


            $ud = User::where('level', 2)->whereHas('usersUnit', function($q)use($inspeksi){
                return $q->where('unit_id', $inspeksi->workPermit->unit_id);
            })->first();

            $text = "Apporval Inspeksi Pekerjaan oleh ".Session::get('auth')->nama.' untuk pekerjaan :'.
            "\nTgl Pekerjaan : ".date('d-m-Y', strtotime($inspeksiLanjut->date)).
            "\nJenis Pekerjaan : ".$inspeksi->workPermit->jenis_pekerjaan.
            "\nDetail Pekerjaan : ".$inspeksi->workPermit->detail_pekerjaan.
            "\nLokasi Pekerjaan : ".$inspeksiLanjut->lokasi.
            
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

    public function deleteFoto(Request $r)
    {
        $if = InspeksiFoto::find($r->id);
        $if->delete();
        return 'success';
    }

    public function uploadVideo(Request $r){
        // return $r->all();
        DB::beginTransaction();
        try {
            $video = $r->file('video');
            
            $if = new InspeksiVideo();
            $if->inspeksi_id = $r->inspeksi_id;
            $if->video = 'file/' . date('YmdHis') . '-' . $video->getClientOriginalName();
            $if->save();
            
            $video->move('file', $if->video);
            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }

    public function deleteVideo(Request $r)
    {
        $if = InspeksiVideo::find($r->id);
        $if->delete();
        return 'success';
    }

    public function exportPdf(Request $r){
        $wp = WorkPermit::find($r->id);
        $inspeksiLanjut = InspeksiLanjut::find($r->il_id);
        $inspeksi = $wp->inspeksi;

        $k3_pln = $wp->inspeksi != null ? User::where('level', 2)->whereHas('usersUnit', function($q)use($inspeksi){
            return $q->where('unit_id', $inspeksi->workPermit->unit_id);
        })->first() : null;

        // return $k3_pln;

        $pdf = PDF::loadView('inspeksi.export', compact('wp','inspeksiLanjut','k3_pln'));
        return $pdf->stream();
        // return $pdf->download();

    }

    public function previewJsa(Request $r)
    {
        $jsa = Jsa::find($r->id);
        $wp = WorkPermit::find($jsa->work_permit_id);

        $pdf = PDF::loadView('jsa.export', compact('wp','jsa'));
        return $pdf->stream();
    }
}
