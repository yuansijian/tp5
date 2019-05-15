<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

//return [
//    '__pattern__' => [
//        'name' => '\w+',
//    ],
//    '[hello]'     => [
//        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
//        ':name' => ['index/hello', ['method' => 'post']],
//    ],
//];

//引入路由
use think\Route;

Route::rule('board/:id', 'index/index/board');
Route::rule('newTopic/:name', 'index/index/newTopic');
Route::rule('/', 'index/index/index');
Route::rule('insertDatabase/:name', 'index/index/insertDatabase', 'post');
Route::rule('content/:name/:topic', 'index/index/content');
Route::rule('reply/:name/:topic', 'index/index/reply');
Route::rule('checkUser', 'index/login/checkUser', 'post');
Route::rule('signUp/', 'index/login/signUp');
Route::rule('insertDatabase/', 'index/login/insertDatabase');
Route::rule('login/', 'index/login/index');
Route::rule('myAccount', 'index/user/index');
Route::rule('userUpdate', 'index/user/update');
Route::rule('userChangePassword', 'index/user/changePassword');
Route::rule('updatePassword', 'index/user/updatePassword');
Route::rule('forgetPassword', 'index/login/forgetPassword');
Route::rule('replyInsert', 'index/index/replyInsert');