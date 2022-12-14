<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SosialisasiFoto extends Model
{
    protected  $table = 'sosialisasi_foto';
    public $timestamps = false;

    public function sosialisasi()
    {
        return $this->belongsTo('App\Sosialisasi');
    }
}
