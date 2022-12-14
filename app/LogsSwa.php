<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogsSwa extends Model
{
    //
    protected  $table = 'logs_swa';
    public $timestamps = false;

    public function users()
    {
        return $this->belongsTo('App\User');
    }
}
