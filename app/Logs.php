<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    //
    protected  $table = 'logs';
    public $timestamps = false;

    public function workOrder()
    {
        return $this->belongsTo('App\WorkOrder');
    }
}
