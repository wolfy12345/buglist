<?php
/**
 * Created by PhpStorm.
 * User: wuzhea
 * Date: 2016/12/27
 * Time: 16:52
 */

namespace App;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{

    public function users()
    {
        return $this->belongsToMany('App\User', 'role_user', 'role_id', 'user_id');
    }
}