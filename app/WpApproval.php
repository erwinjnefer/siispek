<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WpApproval extends Model
{
    //

    protected  $table = 'wp_approval';
    public $timestamps = false;

    public function workPermit()
    {
        return $this->belongsTo('App\WorkPermit');
    }
}
