<?php
/**
 * Created by PhpStorm.
 * User: protecting
 * Date: 19-5-13
 * Time: 下午8:54
 */

namespace app\index\controller;
use think\Controller;


class Login extends Controller
{
    public function index(){
        return $this->fetch();
    }
}