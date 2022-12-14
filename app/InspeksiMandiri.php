<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InspeksiMandiri extends Model
{
    protected  $table = 'inspeksi_mandiri';
    public $timestamps = false;

    public function inspeksi()
    {
        return $this->belongsTo('App\Inspeksi');
    }

    public function jsaPegawai()
    {
        return $this->belongsTo('App\JsaPegawai');
    }
}
