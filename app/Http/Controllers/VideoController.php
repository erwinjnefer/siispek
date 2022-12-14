<?php

namespace App\Http\Controllers;

use App\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VideoController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }
    
    public function index()
    {
        $video = Video::all();
        return view('video.view', compact('video'));
    }

    public function create(Request $r)
    {
        DB::beginTransaction();
        try {
            $file = $r->file('file');
            
            $v = new Video();
            $v->title = $r->title;
            $v->deskripsi = $r->deskripsi;
            $v->file = 'file/' . date('YmdHis') . '-' . $file->getClientOriginalName();
            $v->save();
            
            $file->move('file', $v->file);
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
            
            $v = Video::find($r->id);
            $v->title = $r->title;
            $v->deskripsi = $r->deskripsi;
            if($file != null){
                $v->file = 'file/' . date('YmdHis') . '-' . $file->getClientOriginalName();
            }
            $v->save();
            if($file != null){
                $file->move('file', $v->file);
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
            $v = Video::find($r->id);
            $v->delete();
            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }
}
