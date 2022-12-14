<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sosialisasi extends Model
{
    protected  $table = 'sosialisasi';
    public $timestamps = false;

    public function users()
    {
        return $this->belongsTo('App\User');
    }

    public function sosialisasiFoto()
    {
        return $this->hasMany('App\SosialisasiFoto');
    }
}
