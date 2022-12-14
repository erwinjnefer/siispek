<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sertifikat extends Model
{
    protected  $table = 'sertifikat';
    public $timestamps = false;

    public function waLampiran()
    {
        return $this->belongsTo('App\WaLampiran');
    }
}
