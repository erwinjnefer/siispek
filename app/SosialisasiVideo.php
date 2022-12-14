<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SosialisasiVideo extends Model
{
    protected  $table = 'sosialisasi_video';
    public $timestamps = false;

    public function sosialisasi()
    {
        return $this->belongsTo('App\Sosialisasi');
    }
}
