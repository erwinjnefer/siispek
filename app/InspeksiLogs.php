<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InspeksiLogs extends Model
{
    //
    protected  $table = 'inspeksi_logs';
    public $timestamps = false;

    public function inspeksi()
    {
        return $this->belongsTo('App\Inspeksi');
    }
}
