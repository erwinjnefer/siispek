<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model

{
    protected  $table = 'vendor';
    public $timestamps = false;

    //Hash many Pekerjaan
    public function pekerjaan()
    {
        return $this->hasMany('App\Pekerjaan');
    }
}
