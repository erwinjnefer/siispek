<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    //

    protected  $table = 'work_order';
    public $timestamps = false;
    
    public function users()
    {
        return $this->belongsTo('App\User');
    }
    
    public function unit()
    {
        return $this->belongsTo('App\Unit');
    }

    public function woWp()
    {
        return $this->hasOne('App\WoWp');
    }
}
