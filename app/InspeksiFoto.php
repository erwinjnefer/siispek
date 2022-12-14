<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InspeksiFoto extends Model
{
    protected  $table = 'inspeksi_foto';
    public $timestamps = false;

    public function inspeksi()
    {
        return $this->belongsTo('App\Inspeksi');
    }
}
