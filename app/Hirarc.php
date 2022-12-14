<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hirarc extends Model
{
    protected  $table = 'hirarc';
    public $timestamps = false;

    public function waLampiran()
    {
        return $this->belongsTo('App\WaLampiran');
    }
    
}
