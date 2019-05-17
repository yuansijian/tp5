<?php
/**
 * Created by PhpStorm.
 * User: protecting
 * Date: 19-4-25
 * Time: 下午11:19
 */

namespace app\admin\controller;

use think\Controller;

class Index extends Controller
{
    //后台首页
    public function index(){
        return $this->fetch();
    }
}