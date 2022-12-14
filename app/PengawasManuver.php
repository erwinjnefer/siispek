<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PengawasManuver extends Model
{
    protected  $table = 'pengawas_manuver';
    public $timestamps = false;

    public function workPermit()
    {
        return $this->belongsTo('App\WorkPermit');
    }
    public function users()
    {
        return $this->belongsTo('App\User');
    }
}
