<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JsaPegawai extends Model
{
    protected  $table = 'jsa_pegawai';
    public $timestamps = false;

    public function jsa()
    {
        return $this->belongsTo('App\Jsa');
    }

    public function pegawai()
    {
        return $this->belongsTo('App\Pegawai');
    }

    public function pembagianTugasApd()
    {
        return $this->hasMany('App\PembagianTugasApd');
    }
}
