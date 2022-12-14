<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProsedurKerja extends Model
{
    protected  $table = 'prosedur_kerja';
    public $timestamps = false;

    public function waLampiran()
    {
        return $this->belongsTo('App\WaLampiran');
    }
}
