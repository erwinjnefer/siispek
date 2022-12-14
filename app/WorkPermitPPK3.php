<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkPermitPPK3 extends Model
{
    protected  $table = 'work_permit_ppk3';
    public $timestamps = false;

    public function workPermit()
    {
        return $this->belongsTo('App\WorkPermit');
    }
    public function pegawai()
    {
        return $this->belongsTo('App\Pegawai');
    }
}
