<?php

namespace App\Http\Controllers;

use App\BA;
use App\BaImport;
use App\Imports\BaImports;
use App\LogsSwa;
use App\Pekerjaan;
use App\Req;
use App\Unit;
use App\User;
use App\Vendor;
use App\VResume;
use App\WorkOrder;
use App\WorkPermit;
use Carbon\Carbon;
// use App\Imports\BaImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Contracts\Support\Renderable
    */
    public function index(Request $r)
    {
        // $date = $r->has('date') ? $r->date : date('Y-m-d');
        // ->where('tgl_selesai','>=', $date)
        $resume = [];
        if(Auth::user()->status == 'Vendor'){
            $data['wp'] = WorkPermit::where('users_id', Auth::id())->orderBy('id','desc')->get();
            $resume = VResume::where('users_id', Auth::id())->orderBy('id','desc')->get();
            $wp_done = VResume::where('users_id', Auth::id())->where('man_app', '!=', NULL)->count();
            $inspeksi_done = VResume::where('users_id', Auth::id())->where('inspeksi_id', '!=', NULL)->count();
            $swa_status = VResume::where('users_id', Auth::id())->where('inspeksi_status', 'SWA')->count();
            $data_chart = array(
                ['cat' => 'WP', 'value' => $wp_done,'color' => '#109868'],
                ['cat' => 'INSPEKSI', 'value' => $inspeksi_done,'color' => '#d19a66'],
                ['cat' => 'SWA', 'value' => $swa_status, 'color' => '#cc6633'],
            );

            $swa_group = LogsSwa::where('users_id', Auth::id())->groupBy('users_id')->get();
            $swa = [];
            foreach ($swa_group as $sg) {
                $row = LogsSwa::where('users_id', $sg->users_id)->orderBy('id','desc')->get();

                array_push($swa, array(
                    'users' => $sg->users,
                    'swa' => $row
                ));
            }

            $data['swa_rec'] = $swa;
            
            // $data['vendor'] = User::where('status','Vendor')->get();
            $data['unit'] = Unit::all();  
            

        }elseif(Auth::user()->status == 'Admin' || (Auth::user()->usersUnit != null && Auth::user()->usersUnit->unit_id == 8)){
            $data['wp'] = WorkPermit::orderBy('id','desc')->get();
            $data['unit'] = Unit::all();

            $resume = VResume::orderBy('id','desc')->get();

            $wp_done = VResume::where('man_app', '!=', NULL)->count();
            $inspeksi_done = VResume::where('inspeksi_id', '!=', NULL)->count();
            $swa_status = VResume::where('inspeksi_status', 'SWA')->count();

            $data_chart = array(
                ['cat' => 'WP', 'value' => $wp_done,'color' => '#109868'],
                ['cat' => 'INSPEKSI', 'value' => $inspeksi_done,'color' => '#d19a66'],
                ['cat' => 'SWA', 'value' => $swa_status, 'color' => '#cc6633'],
            );

            $swa_group = LogsSwa::groupBy('users_id')->get();
            $swa = [];
            foreach ($swa_group as $sg) {
                $row = LogsSwa::where('users_id', $sg->users_id)->orderBy('id','desc')->get();

                array_push($swa, array(
                    'users' => $sg->users,
                    'swa' => $row
                ));
            }

            $data['swa_rec'] = $swa;

            

        }elseif( (Auth::user()->level == 0 || Auth::user()->level == 2 || Auth::user()->level == 3 || Auth::user()->level == 4) && Auth::user()->usersUnit != null ){
            $data['wp'] = WorkPermit::where('unit_id', Auth::user()->usersUnit->unit_id)->orderBy('id','desc')->get();
            $data['unit'] = Unit::all();

            $resume = VResume::where('unit_id', Auth::user()->usersUnit->unit_id)->orderBy('id','desc')->get();
            $wp_done = VResume::where('unit_id', Auth::user()->usersUnit->unit_id)->where('man_app', '!=', NULL)->count();
            $inspeksi_done = VResume::where('unit_id', Auth::user()->usersUnit->unit_id)->where('inspeksi_id', '!=', NULL)->count();
            $swa_status = VResume::where('unit_id', Auth::user()->usersUnit->unit_id)->where('inspeksi_status', 'SWA')->count();

            $swa_group = LogsSwa::groupBy('users_id')->get();
            $swa = [];
            foreach ($swa_group as $sg) {
                $row = LogsSwa::where('users_id', $sg->users_id)->orderBy('id','desc')->get();

                array_push($swa, array(
                    'users' => $sg->users,
                    'swa' => $row
                ));
            }

            $data['swa_rec'] = $swa;

            $data_chart = array(
                ['cat' => 'WP', 'value' => $wp_done,'color' => '#109868'],
                ['cat' => 'INSPEKSI', 'value' => $inspeksi_done,'color' => '#d19a66'],
                ['cat' => 'SWA', 'value' => $swa_status, 'color' => '#cc6633'],
            );
        }else{
            return view('unverified');
        }

        $data['resume'] = $resume;
        $data['data_chart'] = $data_chart;
        
        // return $data;
        return view('home', $data);
    }
    
     
}
