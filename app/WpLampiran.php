<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WpLampiran extends Model
{
    protected  $table = 'wp_lampiran';
    public $timestamps = false;

    public function workPermit()
    {
        return $this->belongsTo('App\WorkPermit');
    }

    public function hirarc()
    {
        return $this->hasOne('App\Hirarc');
    }

    public function jsa()
    {
        return $this->hasOne('App\Jsa');
    }

    public function prosedurKerja()
    {
        return $this->hasOne('App\ProsedurKerja');
    }

    public function sertifikat()
    {
        return $this->hasOne('App\Sertifikat');
    }
    
}
