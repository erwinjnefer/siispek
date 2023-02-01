<?php

namespace App\Http\Controllers;

use App\ApkUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApkUpdateController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }
    
    public function index()
    {
        $apk = ApkUpdate::all();
        return view('apk-update.view', compact('apk'));
    }

    public function create(Request $r)
    {
        DB::beginTransaction();
        try {
            $file = $r->file('file');
            
            $v = new ApkUpdate();
            $v->version = $r->version;
            $v->deskripsi = $r->deskripsi;
            $v->file = 'app.apk';
            $v->save();

            if(file_exists('apk/app.apk')){
                unlink('apk/app.apk');
            }
            
            $file->move('apk', 'apk/'.$v->file);
            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }
    
    
    public function update(Request $r)
    {
        DB::beginTransaction();
        try {
            $file = $r->file('file');
            
            $v = ApkUpdate::find($r->id);
            $v->version = $r->version;
            $v->deskripsi = $r->deskripsi;
            if($file != null){
                $v->file = 'app.apk';
            }
            $v->save();
            if($file != null){
                if(file_exists('apk/app.apk')){
                    unlink('apk/app.apk');
                }
                $file->move('apk', 'apk/'.$v->file);
            }
            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }
    
    
    
    public function delete(Request $r)
    {
        DB::beginTransaction();
        try {
            $v = ApkUpdate::find($r->id);
            $v->delete();
            if(file_exists('apk/app.apk')){
                unlink('app.apk');
            }
            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }
}
