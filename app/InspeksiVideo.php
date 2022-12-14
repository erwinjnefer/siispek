<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InspeksiVideo extends Model
{
    protected  $table = 'inspeksi_video';
    public $timestamps = false;

    public function inspeksi()
    {
        return $this->belongsTo('App\Inspeksi');
    }
}
