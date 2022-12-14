<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WoWp extends Model
{
    //
    protected  $table = 'wo_wp';
    public $timestamps = false;

    public function workPermit()
    {
        return $this->belongsTo('App\WorkPermit');
    }
    public function workOrder()
    {
        return $this->belongsTo('App\WorkOrder');
    }
}
