<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PembagianTugasApd extends Model
{
    protected  $table = 'pembagian_tugas_apd';
    public $timestamps = false;

    public function jsaPegawai()
    {
        return $this->belongsTo('App\JsaPegawai');
    }
    
}
