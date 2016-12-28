<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\Role;
use App\Permission;

Route::get('/', 'BugController@getIndex');

Route::controller('bug', 'BugController');

Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// 注册路由...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

// 密码重置链接的路由...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// 密码重置的路由...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');


/* 填充数据
Route::get('/seed', function () {
    $qa = new Role();
    $qa->name = 'QA';
    $qa->display_name = '测试'; // optional
    $qa->description = '测试人员'; // optional
    $qa->save();

    $rd = new Role();
    $rd->name = 'RD';
    $rd->display_name = '开发'; // optional
    $rd->description = '开发人员'; // optional
    $rd->save();

//    $user = User::where('name', '=', 'wuzhe')->first();
//    $user->attachRole($admin); // parameter can be an Role object, array, or id

    $createBug = new Permission();
    $createBug->name = 'create-bug';
    $createBug->display_name = '创建bug'; // optional
    // Allow a user to...
    $createBug->description = '创建bug'; // optional
    $createBug->save();

    $reopenBug = new Permission();
    $reopenBug->name = 'reopen-bug';
    $reopenBug->display_name = '重新打开bug'; // optional
    // Allow a user to...
    $reopenBug->description = '如果bug未修复，可重新打开'; // optional
    $reopenBug->save();

    $closeBug = new Permission();
    $closeBug->name = 'close-bug';
    $closeBug->display_name = '关闭bug'; // optional
    // Allow a user to...
    $closeBug->description = '如果bug已修复，可关闭bug'; // optional
    $closeBug->save();

    $fixBug = new Permission();
    $fixBug->name = 'fix-bug';
    $fixBug->display_name = '修复bug'; // optional
    // Allow a user to...
    $fixBug->description = '开发人员对bug进行修复'; // optional
    $fixBug->save();

    $rd->attachPermission($fixBug);
    // equivalent to $admin->perms()->sync(array($createPost->id));

    $qa->attachPermissions(array($createBug, $reopenBug, $closeBug));
    // equivalent to $owner->perms()->sync(array($createPost->id, $editUser->id));

});*/
