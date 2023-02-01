<?php

namespace App\Http\Controllers;

use App\Inspeksi;
use App\Logs;
use App\Providers\Whatsapp;
use App\Unit;
use App\User;
use App\WorkOrder;
use App\WorkPermit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WorkOrderController extends Controller
{
    //
    public function __construct()
    {
        return $this->middleware('auth')->except(['logsHistory']);
    }
    
    function view(Request $r)
    {

        $user = User::where('status','Vendor')->orderBy('name')->get();
        $u = Auth::user();
        $wo = [];
        $unit = Unit::all();
        $create_wp = 'NO';

        $date = $r->has('date') ? $r->date : null;
        if($date != null){
            $d1 = date('Y-m-d', strtotime($r->date));
            $d2 = date('Y-m-d', strtotime($d1." +30 days"));

        }else{
            $d2 = date('Y-m-d', strtotime('+10 days'));
            $d1 = date('Y-m-d', strtotime($d2." -30 days"));
        }

        if($u->status == 'Admin'|| (Auth::user()->status == 'Manajer' && Auth::user()->usersUnit->unit->nama == 'UP2K')){
            $wo = WorkOrder::where('tgl_mulai','>=', $d1)->where('tgl_mulai','<=', $d2)->orderBy('id','desc')->get();
        }elseif($u->status == 'Vendor'){
            $wo = WorkOrder::where('users_id', $u->id)->where('tgl_mulai','>=', $d1)->where('tgl_mulai','<=', $d2)->orderBy('id','desc')->get();

            $cek_swa = Inspeksi::where('status','SWA')->get();
            $create_wp = ($cek_swa->count() > 0) ? 'NO' : 'YES';
        }elseif( (Auth::user()->level == 2 || Auth::user()->level == 3 || Auth::user()->level == 4) && $u->usersUnit != null ){
            $wo = WorkOrder::where('unit_id', $u->usersUnit->unit_id)->where('tgl_mulai','>=', $d1)->where('tgl_mulai','<=', $d2)->orderBy('id','desc')->get();
        }
        return view('work-order.view', compact('wo','user','unit','create_wp','d1','d2'));
    }

    public function logsHistory(Request $r)
    {
        $logs = Logs::where('work_order_id', $r->id)->get();
        return compact('logs');
    }

    public function create(Request $r)
    {
        DB::beginTransaction();
        try {

            $file = $r->file('file');

            $wo = new WorkOrder();
            $wo->date = date('Y-m-d');
            $wo->nama = $r->nama;
            if($file != null){
                $wo->file = 'file/' . date('YmdHis') . '-' . $file->getClientOriginalName();
            }
            $wo->users_id = $r->vendor_id;
            $wo->unit_id = $r->unit_id;
            $wo->spk_no = $r->spk_no;
            $wo->tgl_mulai = date('Y-m-d', strtotime($r->tgl_mulai));
            $wo->tgl_selesai = date('Y-m-d', strtotime($r->tgl_selesai));
            $wo->progress = 'Create WO';
            $wo->save();
            if($file != null){
                $file->move('file', $wo->file);
            }
            

            $logs = new Logs();
            $logs->date = date('Y-m-d H:i:s');
            $logs->nama = "Create work order";
            $logs->users = Auth::user()->name;
            $logs->work_order_id = $wo->id;
            $logs->save();

            $msg = "Hi *".$wo->users->name."*,\nAnda ditunjuk untuk melaksanakan pekerjaan \n*$wo->nama*\nSilahkan lanjutkan untuk membuat Work Permit di http://sscpln.com/wp atau masuk ke menu Work Order kolom Work Permit. Terimakasih !";
            event(new Whatsapp($wo->users->no_wa, $msg));

            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $th->getMessage();
        }
    }

    public function delete(Request $r)
    {
        $wo = WorkOrder::find($r->id);
        $wo->delete();
        return 'success';
    }

    public function editUnit(Request $r)
    {
        DB::beginTransaction();
        try {
            $wo = WorkOrder::find($r->id);
            $wo->unit_id = $r->unit_id;
            $wo->save();
            
            if($wo->wowp != null){
                $wp = WorkPermit::find($wo->woWp->work_permit_id);
                $wp->unit_id = $r->unit_id;
                $wp->save();
            }
            
            
            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $th->getMessage();
        }
    }
}
