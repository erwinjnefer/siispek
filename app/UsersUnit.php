<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersUnit extends Model
{
    //

    protected  $table = 'users_unit';
    public $timestamps = false;

    public function unit()
    {
        return $this->belongsTo('App\Unit');
    }
    
    public function users()
    {
        return $this->belongsTo('App\User');
    }
}
