<?php

namespace App\Http\Controllers\Rest;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MBroker;
use App\Inspeksi;
use App\InspeksiFoto;
use App\InspeksiLanjut;
use App\InspeksiLogs;
use App\InspeksiMandiri;
use App\JsaPegawai;
use App\Logs;
use App\LogsSwa;
use App\Pegawai;
use App\Providers\Whatsapp;
use App\User;
use App\Video;
use App\WorkPermit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InspeksiController extends Controller
{
    //
    public function auth(Request $r)
    {
        $auth = Pegawai::where('username', $r->username)->where('password', $r->password)->first();
        if($auth != null){
            return ['auth' => 1 ,'msg' => 'success', 'pegawai' => $auth]; 
        }else{
            return ['auth' => 0 ,'msg' => 'failed'];
        }
    }
    
    public function view(Request $r){
        $pegawai = Pegawai::find($r->pegawai_id);
        $date = $r->date;

        $date = $r->date;
        if($date != null){
            $d1 = date('Y-m-d', strtotime($r->date));
            $d2 = date('Y-m-d', strtotime($d1." +30 days"));

        }else{
            $d2 = date('Y-m-d', strtotime('+10 days'));
            $d1 = date('Y-m-d', strtotime($d2." -30 days"));
        }

        $wp = WorkPermit::with('wpApproval')->with('woWp')
            ->with('workPermitPP.pegawai')
            ->with('workPermitPPK3.pegawai')
            ->with('unit')
            ->with('workPermitHirarc.hirarc')
            ->with('workPermitProsedurKerja.prosedurKerja')
            ->with('jsa')
            ->with('inspeksi')
            ->with('users')
            ->where('tgl_mulai','>=', $d1)
            ->where('tgl_mulai','<=', $d2)
            ->where('users_id', $pegawai->users_id)
            ->orderBy('id','desc')
            ->get();


        $date = date('d-m-Y', strtotime($d1)).' - '.date('d-m-Y', strtotime($d2));
        
        return compact('wp','date');
    }
    
    public function detail(Request $r){
        $wp = WorkPermit::find($r->id);
        if($wp->inspeksi == null){
            $inspeksi = new Inspeksi();
            $inspeksi->status = 'Open';
            $inspeksi->work_permit_id = $r->id;
            $inspeksi->save();
        }
        $data['wp'] = WorkPermit::with('wpApproval')
        ->with('workPermitPP.pegawai')
        ->with('workPermitPPK3.pegawai')
        ->with('unit')
        ->with('workPermitHirarc.hirarc')
        ->with('workPermitProsedurKerja.prosedurKerja')
        ->with('jsa.jsaPegawai.pegawai')
        ->with('inspeksi')
        ->with('inspeksi.inspeksiMandiri.jsaPegawai.pegawai')
        ->with('inspeksi.inspeksiLanjut')
        ->with('inspeksi.inspeksiLanjut.inspeksiFoto')
        ->with('users')->find($r->id);
        
        
        
        $data['video'] = Video::inRandomOrder()->first();

        
        
        return $data;
    }
    
    public function inspeksiMandiri(Request $r)
    {
        // return $r->all();
        DB::beginTransaction();
        try {
            InspeksiMandiri::where('jsa_pegawai_id', $r->jsa_pegawai_id)->delete();
            
            $inspeksi = Inspeksi::find($r->inspeksi_id);
            $wp = WorkPermit::find($inspeksi->work_permit_id);

            $foto = $r->file('foto');
            
            $im = new InspeksiMandiri();
            $im->tgl_inspeksi = date('Y-m-d');
            $im->time = date('H:i:s');
            $im->inspeksi_id = $inspeksi->id;
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
            $im->koordinat = $r->koordinat;
            if($foto != null){
                $im->foto = 'file/'.date('YmdHis').'-'.$foto->getClientOriginalName();
            }
            $im->save();
            if($foto != null){
                $foto->move('file', $im->foto);
            }
            
            $logs = new Logs();
            $logs->date = date('Y-m-d H:i:s');
            $logs->nama = "Inspeksi Mandiri";
            $logs->users = $im->jsaPegawai->pegawai->nama;
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
                "\nHubungi PJK3 terkait untuk open SWA jika sudah dilengkapi dokumen/selesaikan temuan inspeksi".
                "\nUntuk lebih detail kunjungi https://sscpln.com/wp Terimakasih";
                
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
                
                "\nUntuk lebih detail kunjungi https://sscpln.com/wp Terimakasih";
                
                
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
                $text = "Review Inspeksi Mandiri oleh : ".$r->nama_reviewer.
                "\nJenis Pekerjaan : ".$sa->workPermit->jenis_pekerjaan.
                "\nDetail Pekerjaan : ".$sa->workPermit->detail_pekerjaan.
                "\nLokasi Pekerjaan : ".$sa->workPermit->lokasi_pekerjaan.
                "\n\nStatus Review : ".$sa->review.
                "\nCatatan Review : ".$sa->catatan_review.
                "\nUntuk lebih detail kunjungi https://sscpln.com/wp Terimakasih";
                
                event(new Whatsapp($ud->no_wa, $text));
                
            }
            
            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }
    
    public function readJsa(Request $r)
    {
        DB::beginTransaction();
        try {
            
            
            $wp = WorkPermit::find($r->wp_id);
            
            $inspeksi = Inspeksi::find($wp->inspeksi->id);
            $inspeksi->durasi_baca_jsa = $this->getTimeDiff($r->time_awal, $r->time_akhir);
            $inspeksi->jsa = 'Saya sudah memahami JSA';
            $inspeksi->wp = 'Saya sudah memahami Working Permit';
            $inspeksi->save();
            
            $jsaPegawai = JsaPegawai::find($r->jsa_pegawai_id);
            $jsaPegawai->read_jsa = 1;
            $jsaPegawai->save();
            
            
            //record logs
            $logs = new InspeksiLogs();
            $logs->date = date('Y-m-d H:i:s');
            $logs->nama = 'Membaca JSA selama '.$inspeksi->durasi_baca_jsa;
            $logs->inspeksi_id = $inspeksi->id;
            $logs->save();
            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }
    
    
    
    public function readSop(Request $r)
    {
        // return $r->all();
        DB::beginTransaction();
        try {
            $wp = WorkPermit::find($r->wp_id);
            $inspeksi = Inspeksi::find($wp->inspeksi->id);
            $inspeksi->durasi_baca_sop = $this->getTimeDiff($r->time_awal, $r->time_akhir);
            $inspeksi->sop = 'Saya sudah memahami SOP pekerjaan';
            $inspeksi->save();

            $jsaPegawai = JsaPegawai::find($r->jsa_pegawai_id);
            $jsaPegawai->read_sop = 1;
            $jsaPegawai->save();
            
            
            //record logs
            $logs = new InspeksiLogs();
            $logs->date = date('Y-m-d H:i:s');
            $logs->nama = 'Membaca SOP selama '.$inspeksi->durasi_baca_jsa;
            $logs->inspeksi_id = $inspeksi->id;
            $logs->save();
            
            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }
    
    function getTimeDiff($dtime,$atime)
    {
        $nextDay = $dtime>$atime?1:0;
        $dep = explode(':',$dtime);
        $arr = explode(':',$atime);
        $diff = abs(mktime($dep[0],$dep[1],0,date('n'),date('j'),date('y'))-mktime($arr[0],$arr[1],0,date('n'),date('j')+$nextDay,date('y')));
        $hours = floor($diff/(60*60));
        $mins = floor(($diff-($hours*60*60))/(60));
        $secs = floor(($diff-(($hours*60*60)+($mins*60))));
        if(strlen($hours)<2){$hours="0".$hours;}
        if(strlen($mins)<2){$mins="0".$mins;}
        if(strlen($secs)<2){$secs="0".$secs;}
        return $hours.':'.$mins.':'.$secs;
    }
    
    public function submitInspeksi(Request $r){
        DB::beginTransaction();
        try {
            
            $inspeksi = Inspeksi::find($r->id);
            $inspeksi->submit = 1;
            $inspeksi->save();
            
            //record logs
            $logs = new InspeksiLogs();
            $logs->date = date('Y-m-d H:i:s');
            $logs->nama = 'Submit inspeksi';
            $logs->inspeksi_id = $inspeksi->id;
            $logs->save();
            
            $ud = User::where('level', 2)->whereHas('usersUnit', function($q)use($inspeksi){
                return $q->where('unit_id', $inspeksi->workPermit->unit_id);
            })->first();
            
            $text = "Submit Inspeksi Pekerjaan oleh ".$inspeksi->nama_inspektor.' untuk pekerjaan :'.
            "\nTgl Pekerjaan : ".date('d-m-Y', strtotime($inspeksi->workPermit->tgl_pengajuan)).
            "\nJenis Pekerjaan : ".$inspeksi->workPermit->jenis_pekerjaan.
            "\nDetail Pekerjaan : ".$inspeksi->workPermit->detail_pekerjaan.
            "\nLokasi Pekerjaan : ".$inspeksi->workPermit->lokasi_pekerjaan.
            
            "\nUntuk lebih detail kunjungi https://sscpln.com/wp Terimakasih";
            
            if($ud != null && $ud->no_wa != null){
                event(new Whatsapp($ud->no_wa, $text));
                // $wa = new MBroker();
                // $wa->publish($ud->no_wa,$text,null);
            }
            
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
            
            $inspeksi->app_k3_vendor = $r->nama_inspektor;
            $inspeksi->app_k3_vendor_date = date('Y-m-d');
            $inspeksi->tindakan_selanjutnya = "Pekerjaan dapat dilanjutkan";
            $inspeksi->save();
            
            $text = 'Apporval Inspeksi Pekerjaan  :'.
            "\nTgl Inspeksi : ".date('d-m-Y', strtotime($inspeksi->date)).
            "\nJenis Pekerjaan : ".$inspeksi->inspeksi->workPermit->jenis_pekerjaan.
            "\nDetail Pekerjaan : ".$inspeksi->inspeksi->workPermit->detail_pekerjaan.
            "\nLokasi Pekerjaan : ".$inspeksi->lokasi.
            
            "\nUntuk lebih detail kunjungi https://sscpln.com/wp Terimakasih";
            
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
            $inspeksi->nama_inspektor = $r->nama_inspektor;
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
                $logs_swa->pekerjaan = $sa->workPermit->detail_pekerjaan;
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
                "\nUntuk lebih detail kunjungi https://sscpln.com/wp Terimakasih";
                
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
                
                "\nUntuk lebih detail kunjungi https://sscpln.com/wp Terimakasih";
                
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
    
    public function reqOpenSwa(Request $r){
        // return $r->all();
        DB::beginTransaction();
        try {
            $file = $r->file('file');
            
            $inspeksi = Inspeksi::find($r->id);
            $inspeksi->catatan = $r->catatan;
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
            "\nUntuk lebih detail kunjungi https://sscpln.com/wp Terimakasih";
            
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

    public function logsHistory(Request $r)
    {
        $logs = Logs::where('work_order_id', $r->id)->get();
        return compact('logs');
    }
}
