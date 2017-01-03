<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bug extends Model
{
    //
    public function creator()
    {
        return $this->hasOne('App\User', 'id', 'creator_user_id');
    }

    public function fixer()
    {
        return $this->hasOne('App\User', 'id', 'fixer_user_id');
    }
}
