<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inspeksi extends Model
{
    protected  $table = 'inspeksi';
    public $timestamps = false;

    public function workPermit()
    {
        return $this->belongsTo('App\WorkPermit');
    }

    public function inspeksiLanjut()
    {
        return $this->hasMany('App\InspeksiLanjut');
    }

    public function inspeksiMandiri()
    {
        return $this->hasMany('App\InspeksiMandiri');
    }

    

    public function inspeksiVideo()
    {
        return $this->hasMany('App\InspeksiVideo');
    }
}
