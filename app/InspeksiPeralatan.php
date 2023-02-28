<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InspeksiPeralatan extends Model
{
    protected  $table = 'inspeksi_peralatan';
    public $timestamps = false;

    public function users()
    {
        return $this->belongsTo('App\User');
    }
    public function mapRef()
    {
        return $this->belongsTo('App\MapRef');
    }
}
