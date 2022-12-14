<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkPermitPP extends Model
{
    protected  $table = 'work_permit_pp';
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
