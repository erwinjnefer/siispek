<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InspeksiLanjut extends Model
{
    //
    protected  $table = 'inspeksi_lanjut';
    public $timestamps = false;

    public function inspeksi()
    {
        return $this->belongsTo('App\Inspeksi');
    }

    public function inspeksiFoto()
    {
        return $this->hasMany('App\InspeksiFoto');
    }
}
