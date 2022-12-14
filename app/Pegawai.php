<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected  $table = 'pegawai';
    public $timestamps = false;

    public function users()
    {
        return $this->belongsTo('App\User');
    }

    public function JsaPegawai()
    {
        return $this->hasMany('App\JsaPegawai');
    }
    
    public function sertifikat()
    {
        return $this->hasMany('App\Sertifikat');
    }
}
