<?php

namespace App\Http\Controllers;

use App\Inspeksi;
use App\InspeksiFoto;
use App\InspeksiLanjut;
use App\InspeksiVideo;
use App\Logs;
use App\LogsSwa;
use App\Providers\Whatsapp;
use App\User;
use App\WorkOrder;
use App\WorkPermit;
use GdImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;
use PDF;

class InspeksiController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth')->except(['exportPdf']);
    }
    
    public function view(Request $r)
    {
        $date = $r->has('date') ? $r->date : null;
        if($date != null){
            $d1 = date('Y-m-d', strtotime($r->date));
            $d2 = date('Y-m-d', strtotime($d1." +30 days"));

        }else{
            $d2 = date('Y-m-d', strtotime('+10 days'));
            $d1 = date('Y-m-d', strtotime($d2." -30 days"));
        }

        $u = Auth::user();
        $wp = [];
        if($u->status == 'Admin' || (Auth::user()->usersUnit != null && Auth::user()->usersUnit->unit_id == 8)){
            $wp = WorkPermit::where('submit', 1)->where('tgl_mulai','>=', $d1)->where('tgl_mulai','<=', $d2)->orderBy('id','desc')->get();
        }elseif($u->status == 'Vendor'){
            $wp = WorkPermit::where('users_id', $u->id)->where('submit', 1)->where('tgl_mulai','>=', $d1)->where('tgl_mulai','<=', $d2)->orderBy('id','desc')->get();
        }elseif( (Auth::user()->level == 2 || Auth::user()->level == 3 || Auth::user()->level == 4) && $u->usersUnit != null ){
            $wp = WorkPermit::where('unit_id', $u->usersUnit->unit_id)->where('submit', 1)->where('tgl_mulai','>=', $d1)->where('tgl_mulai','<=', $d2)->orderBy('id','desc')->get();
        }
        return view('inspeksi.view', compact('wp','d1'));
    }

    public function viewToday(Request $r){
        $date = $r->has('date') ? date('Y-m-d', strtotime($r->date)) : date('Y-m-d');
        $u = Auth::user();
        $wp = [];
        if($u->status == 'Admin' || (Auth::user()->usersUnit != null && Auth::user()->usersUnit->unit_id == 8)){
            $wp = WorkPermit::where('submit', 1)->where('tgl_rencana_pelaksanaan', $date)->orderBy('id','desc')->get();
        }elseif($u->status == 'Vendor'){
            $wp = WorkPermit::where('users_id', $u->id)->where('submit', 1)->where('tgl_rencana_pelaksanaan', $date)->orderBy('id','desc')->get();
        }elseif( (Auth::user()->level == 2 || Auth::user()->level == 3 || Auth::user()->level == 4) && $u->usersUnit != null ){
            $wp = WorkPermit::where('unit_id', $u->usersUnit->unit_id)->where('submit', 1)->where('tgl_rencana_pelaksanaan', $date)->orderBy('id','desc')->get();
        }

        return view('inspeksi.today', compact('wp'));
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

        // return $wp;
        // return $wp->jsa->jsaPegawai[0]->pegawai;
        
        return view('inspeksi.detail', compact('wp','ppk3'));
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
                "\nUntuk lebih detail kunjungi https://sscpln.com/wp Terimakasih";

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
            $sa->status = ($sa->workPermit->wpApproval->man_app != NULL && $inspeksi->tindakan_selanjutnya != 'Pekerjaan tidak dapat dilanjutkan dan diterbitkan SWA (stop work authority)') ? 'Open' : 'SWA';
            $sa->save();

            $ud = User::where('level', 2)->whereHas('usersUnit', function($q)use($inspeksi){
                return $q->where('unit_id', $inspeksi->inspeksi->workPermit->unit_id);
            })->first();

           

            $logs = new Logs();
            $logs->date = date('Y-m-d H:i:s');
            $logs->nama = "Inspeksi K3";
            $logs->users = $inspeksi->nama_inspektor;
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
                "\nUntuk lebih detail kunjungi https://sscpln.com/wp Terimakasih";

                if($ud != null && $ud->no_wa != null){
                    event(new Whatsapp($ud->no_wa, $text));
                }
    
                if($sa->workPermit->workPermitPPK3->pegawai->no_wa != null){
                    event(new Whatsapp($sa->workPermit->users->no_wa, $text));
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

    public function openSwa(Request $r)
    {
        
        DB::beginTransaction();
        try {
            $inspeksi = Inspeksi::find($r->id);
            $inspeksi->status = 'Open';
            $inspeksi->req_open_swa = 0;
            $inspeksi->jenis_dokumen = NULL;
            $inspeksi->req_open_swa_file = NULL;
            $inspeksi->catatan = NULL;
            $inspeksi->save();
            
            $wo = $inspeksi->workPermit->woWp->workOrder;
            $wo->progress = 'Open SWA';
            $wo->save();
            // return $inspeksi->workPermit->woWP;

            $logs = new Logs();
            $logs->date = date('Y-m-d H:i:s');
            $logs->nama = "Open SWA";
            $logs->users = Auth::user()->name;
            $logs->work_order_id = $wo->id;
            $logs->save();

            $msg = "Hi *".$inspeksi->workPermit->users->name."*,\nstatus operasi untuk pekerjaan \n*$wo->nama* telah dibuka \nUntuk lebih detail kunjungi https://sscpln.com/wp Terimakasih";
            event(new Whatsapp($wo->users->no_wa, $msg));
            DB::commit();
            return 'success';

        } catch (\Throwable $th) {
            //throw $th;
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
    
    

    public function createImage($img)
    {

        $folderPath = "file/";

        // $image_parts = explode(";base64,", $img);
        // $image_type_aux = explode("image/", $image_parts[0]);
        // $image_type = $image_type_aux[1];
        // $image_base64 = base64_decode($image_parts[1]);
        // $file = $folderPath . uniqid() . '. '.$image_type;

        // file_put_contents($file, $image_base64);

        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $file = $folderPath . uniqid() . '.png';
        file_put_contents($file, $data);

        return $file;

    }
    
    public function approve(Request $r)
    {
        
        DB::beginTransaction();
        try {
            $inspeksiLanjut = InspeksiLanjut::find($r->id);
            $inspeksi = Inspeksi::find($inspeksiLanjut->inspeksi_id);
        
            
            $inspeksiLanjut->app_k3_pln_date = date('Y-m-d H:i:s');
            $inspeksiLanjut->app_k3_pln = Auth::user()->name;
            $inspeksiLanjut->save();

            $logs = new Logs();
            $logs->date = date('Y-m-d H:i:s');
            $logs->nama = "Approve inspeksi";
            $logs->users = Auth::user()->name;
            $logs->work_order_id = $inspeksi->workPermit->woWp->work_order_id;
            $logs->save();

            

            $text = "Apporval Inspeksi Pekerjaan oleh ".Auth::user()->name.' untuk pekerjaan :'.
            "\nTgl Pekerjaan : ".date('d-m-Y', strtotime($inspeksi->workPermit->tgl_pengajuan)).
            "\nJenis Pekerjaan : ".$inspeksi->workPermit->jenis_pekerjaan.
            "\nDetail Pekerjaan : ".$inspeksi->workPermit->detail_pekerjaan.
            "\nLokasi Pekerjaan : ".$inspeksi->workPermit->lokasi_pekerjaan.
            
            "\nUntuk lebih detail kunjungi https://sscpln.com/wp Terimakasih";

            if($inspeksi->workPermit->workPermitPPK3->pegawai->no_wa != null){
                // $wa = new MBroker();
                // $wa->publish($ud->no_wa,$text,null);
                event(new Whatsapp($inspeksi->workPermit->workPermitPPK3->pegawai->no_wa, $text));
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

    public function submitInspeksi(Request $r){
        DB::beginTransaction();
        try {

            $inspeksi = Inspeksi::find($r->id);
            $inspeksi->submit = 1;
            $inspeksi->save();

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
                $wa = new MBroker();
                $wa->publish($ud->no_wa,$text,null);
            }

            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }

    public function exportPdf(Request $r){
        $wp = WorkPermit::find($r->id);
        $inspeksiLanjut = InspeksiLanjut::find($r->il_id);

        $inspeksi = $wp->inspeksi;
        $k3_pln = $wp->inspeksi != null ? User::where('level', 2)->whereHas('usersUnit', function($q)use($inspeksi){
            return $q->where('unit_id', $inspeksi->workPermit->unit_id);
        })->first() : null;

        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('inspeksi.export', compact('wp','inspeksiLanjut','k3_pln'));
        return $pdf->stream();

    }
    
    
    
    public function export(Request $r){
        $reader = IOFactory::createReader('Xlsx');
        $excel = $reader->load('inspeksi.xlsx');
        
        
        $inspeksi = Inspeksi::find($r->id);
        // return $inspeksi;
        
        $pelaksana = "";
        $c = 1;
        foreach ($inspeksi->workPermit->jsa->jsaPegawai as $jp) {
            $pelaksana = $pelaksana.$c++ .'. '.$jp->pegawai->nama."\n";
        }
        
        $excel->getActiveSheet()->setCellValue('F6', ': '.date('d-m-Y', strtotime($inspeksi->workPermit->tgl_pengajuan)));
        $excel->getActiveSheet()->setCellValue('F7', ': '.$inspeksi->workPermit->jenis_pekerjaan);
        $excel->getActiveSheet()->setCellValue('F8', ': '.$inspeksi->workPermit->detail_pekerjaan);
        $excel->getActiveSheet()->setCellValue('F9', ': '.$inspeksi->workPermit->lokasi_pekerjaan);
        $excel->getActiveSheet()->setCellValue('F10', ': '.$inspeksi->workPermit->unit->nama);
        $excel->getActiveSheet()->setCellValue('F11', ': '.$inspeksi->workPermit->users->name);
        $excel->getActiveSheet()->setCellValue('F13', ': '.$inspeksi->workPermit->workPermitPP->pegawai->nama);
        $excel->getActiveSheet()->setCellValue('F14', ': '.$inspeksi->workPermit->workPermitPPK3->pegawai->nama);
        $excel->getActiveSheet()->setCellValue('F15', $pelaksana);
        $excel->getActiveSheet()->setCellValue('F17', ': '.$inspeksi->workPermit->inspeksi->kondisi_pelaksana_pekerjaan);
        $excel->getActiveSheet()->setCellValue('F18', ': '.$inspeksi->workPermit->inspeksi->penggunaan_apd);
        $excel->getActiveSheet()->setCellValue('F19', ': '.$inspeksi->workPermit->inspeksi->penggunaan_perlengkapan_kerja);
        $excel->getActiveSheet()->setCellValue('F20', ': '.$inspeksi->workPermit->inspeksi->pemasangan_rambu_k3);
        $excel->getActiveSheet()->setCellValue('F21', ': '.$inspeksi->workPermit->inspeksi->pemasangan_loto);
        $excel->getActiveSheet()->setCellValue('F22', ': '.$inspeksi->workPermit->inspeksi->pemasangan_pembumian);
        $excel->getActiveSheet()->setCellValue('F23', ': '.$inspeksi->workPermit->inspeksi->pembebasasn_pemeriksaan_tegangan);
        $excel->getActiveSheet()->setCellValue('F24', ': '.$inspeksi->workPermit->inspeksi->pelaksanaan_breafing);
        $excel->getActiveSheet()->setCellValue('F25', ': '.$inspeksi->workPermit->inspeksi->jsa);
        $excel->getActiveSheet()->setCellValue('F26', ': '.$inspeksi->workPermit->inspeksi->sop);
        $excel->getActiveSheet()->setCellValue('F27', ': '.$inspeksi->workPermit->inspeksi->wp);
        $excel->getActiveSheet()->setCellValue('A29', $inspeksi->workPermit->inspeksi->catatan_temuan);
        $excel->getActiveSheet()->setCellValue('A31', $inspeksi->workPermit->inspeksi->saran_rekomendasi);
        $excel->getActiveSheet()->setCellValue('A33', $inspeksi->workPermit->inspeksi->tindakan_selanjutnya);
        
        
        
        
        $objDrawing = new Drawing();
        $objDrawing->setName('Logo');
        $objDrawing->setDescription('Logo');
        $objDrawing->setPath($inspeksi->app_k3_pln_sign);
        $objDrawing->setHeight(90);
        $objDrawing->setCoordinates('D39');
        $objDrawing->setWorksheet( $excel->getActiveSheet());

        $objDrawing2 = new Drawing();
        $objDrawing2->setName('Logo');
        $objDrawing2->setDescription('Logo');
        $objDrawing2->setPath($inspeksi->app_k3_vendor_sign);
        $objDrawing2->setHeight(90);
        $objDrawing2->setCoordinates('J39');
        $objDrawing2->setWorksheet( $excel->getActiveSheet());
        
        $filename = 'Inpeksi - '.$inspeksi->workPermit->detail_pekerjaan;
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
        $writer = IOFactory::createWriter($excel, 'Xlsx');
        $writer->save('php://output');
    }
}
