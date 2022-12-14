<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkPermit extends Model
{
    protected  $table = 'work_permit';
    public $timestamps = false;
    
    public function users()
    {
        return $this->belongsTo('App\User');
    }
    
    public function woWp()
    {
        return $this->hasOne('App\WoWp');
    }

    public function unit()
    {
        return $this->belongsTo('App\Unit');
    }
    
    public function wpApproval()
    {
        return $this->hasOne('App\WpApproval');
    }

    public function waLampiran()
    {
        return $this->hasOne('App\WpLampiran');
    }
    public function jsa()
    {
        return $this->hasOne('App\Jsa','work_permit_id');
    }

    public function workPermitHirarc()
    {
        return $this->hasOne('App\WorkPermitHirarc');
    }

    public function workPermitProsedurKerja()
    {
        return $this->hasOne('App\WorkPermitProsedurKerja');
    }

    public function workPermitPP()
    {
        return $this->hasOne('App\WorkPermitPP');
    }

    public function workPermitPPK3()
    {
        return $this->hasOne('App\WorkPermitPPK3');
    }
    
    public function pengawasManuver()
    {
        return $this->hasOne('App\PengawasManuver');
    }
    public function inspeksi()
    {
        return $this->hasOne('App\Inspeksi');
    }
    
    
}
