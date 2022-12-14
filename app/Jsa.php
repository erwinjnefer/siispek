<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jsa extends Model
{
    protected  $table = 'jsa';
    public $timestamps = false;

    public function workPermit()
    {
        return $this->belongsTo('App\WorkPermit');
    }
    
    public function jsaPegawai()
    {
        return $this->hasMany('App\JsaPegawai');
    }
}
