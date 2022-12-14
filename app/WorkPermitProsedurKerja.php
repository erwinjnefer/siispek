<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkPermitProsedurKerja extends Model
{
    protected  $table = 'work_permit_prosedur_kerja';
    public $timestamps = false;

    public function workPermit()
    {
        return $this->belongsTo('App\WorkPermit');
    }
    public function prosedurKerja()
    {
        return $this->belongsTo('App\ProsedurKerja');
    }
}
