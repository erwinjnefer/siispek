<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Logs;
use App\Providers\Whatsapp;
use App\Unit;
use App\User;
use App\Vendor;
use App\VResume;
use App\WorkOrder;
use App\WorkPermit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class WorkOrderController extends Controller
{
    //

    public function loadChart(Request $r)
    {
        if(Auth::user()->status == 'Vendor'){
            $data['wp'] = WorkPermit::where('users_id', Auth::id())->get();
            $resume = VResume::where('users_id', Auth::id())->get();
            $wp_done = VResume::where('users_id', Auth::id())->where('man_app', '!=', NULL)->count();
            $inspeksi_done = VResume::where('users_id', Auth::id())->where('inspeksi_id', '!=', NULL)->count();
            $swa_status = VResume::where('users_id', Auth::id())->where('inspeksi_status', 'SWA')->count();
            $data_chart = array(
                ['cat' => 'WP', 'value' => $wp_done,'color' => '#54B435'],
                ['cat' => 'INSPEKSI', 'value' => $inspeksi_done,'color' => '#F49D1A'],
                ['cat' => 'SWA', 'value' => $swa_status, 'color' => '#CF0A0A'],
            );
            // $data['vendor'] = User::where('status','Vendor')->get();
            $data['unit'] = Unit::all();  
        }elseif(Auth::user()->status == 'Admin'){
            $data['wp'] = WorkPermit::all();
            $data['unit'] = Unit::all();

            $resume = VResume::get();

            $wp_done = VResume::where('man_app', '!=', NULL)->count();
            $inspeksi_done = VResume::where('inspeksi_id', '!=', NULL)->count();
            $swa_status = VResume::where('inspeksi_status', 'SWA')->count();

            $data_chart = array(
                ['cat' => 'WP', 'value' => $wp_done,'color' => '#54B435'],
                ['cat' => 'INSPEKSI', 'value' => $inspeksi_done,'color' => '#F49D1A'],
                ['cat' => 'SWA', 'value' => $swa_status, 'color' => '#CF0A0A'],
            );

            

        }elseif( (Auth::user()->level == 2 || Auth::user()->level == 3 || Auth::user()->level == 4) && Auth::user()->usersUnit != null ){
            $data['wp'] = WorkPermit::where('unit_id', Auth::user()->usersUnit->unit_id)->get();
            $data['unit'] = Unit::all();

            $resume = VResume::where('unit_id', Auth::user()->usersUnit->unit_id)->get();
            $wp_done = VResume::where('unit_id', Auth::user()->usersUnit->unit_id)->where('man_app', '!=', NULL)->count();
            $inspeksi_done = VResume::where('unit_id', Auth::user()->usersUnit->unit_id)->where('inspeksi_id', '!=', NULL)->count();
            $swa_status = VResume::where('unit_id', Auth::user()->usersUnit->unit_id)->where('inspeksi_status', 'SWA')->count();

            $data_chart = array(
                ['cat' => 'WP', 'value' => $wp_done,'color' => '#54B435'],
                ['cat' => 'INSPEKSI', 'value' => $inspeksi_done,'color' => '#F49D1A'],
                ['cat' => 'SWA', 'value' => $swa_status, 'color' => '#CF0A0A'],
            );
        }

        return compact('resume','data_chart');
    }

    function view(Request $r)
    {
        $vendor = User::where('status','Vendor')->orderBy('name','asc')->get();
        $unit = Unit::all();
        $u = Auth::user();
        $wo = [];
        if($u->status == 'Admin'){
            $wo = WorkOrder::with('woWp.workPermit.wpApproval')->with('users')->with('unit')->orderBy('id','desc')->get();
        }elseif($u->status == 'Vendor'){
            $wo = WorkOrder::with('woWp.workPermit.wpApproval')->with('users')->with('unit')->where('users_id', $u->id)->orderBy('id','desc')->get();
        }elseif( (Auth::user()->level == 2 || Auth::user()->level == 3 || Auth::user()->level == 4) && $u->usersUnit != null ){
            $wo = WorkOrder::with('woWp.workPermit.wpApproval')->with('users')->with('unit')->where('unit_id', $u->usersUnit->unit_id)->orderBy('id','desc')->get();
        }else{
            $wo = WorkOrder::with('woWp.workPermit.wpApproval')->with('users')->with('unit')->where('users_id', Auth::id())->orWhere('unit_id', $u->usersUnit->unit_id)->orderBy('id','desc')->get();
        }

        return compact('wo','vendor','unit');
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
            $wo = new WorkOrder();
            $wo->date = date('Y-m-d');
            $wo->nama = $r->nama;
            $wo->users_id = $r->vendor_id;
            $wo->unit_id = $r->unit_id;
            $wo->spk_no = $r->spk_no;
            $wo->progress = 'Create WO';
            $wo->save();

            $logs = new Logs();
            $logs->date = date('Y-m-d H:i:s');
            $logs->nama = "Create work order";
            $logs->users = Auth::user()->name;
            $logs->work_order_id = $wo->id;
            $logs->save();

            $msg = "Hi *".$wo->users->name."*,\nAnda ditunjuk untuk melaksanakan pekerjaan \n*$wo->nama*\nSilahkan lanjutkan untuk membuat Work Permit di http://sscpln.com/siispek atau masuk ke menu Work Order kolom Work Permit. Terimakasih !";
            event(new Whatsapp($wo->users->no_wa, $msg));

            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $th->getMessage();
        }
    }
}
