<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkPermitHirarc extends Model
{
    protected  $table = 'work_permit_hirarc';
    public $timestamps = false;

    public function workPermit()
    {
        return $this->belongsTo('App\WorkPermit');
    }
    public function hirarc()
    {
        return $this->belongsTo('App\Hirarc');
    }
}
