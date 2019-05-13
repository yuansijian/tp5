<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Model;

class Index extends  Controller
{
    //主页显示
    public function index()
    {
        $data = Db::query("select * from home");

        $this->assign('data', $data);

        return view();
    }

    //板块显示
    public function board($id)
    {
        $name = Db::query("select board from home where id=?", [$id]);
//        dump($name[0]['board']);
//        $data = Db::query("select * from ?", [$name[0]['board']]);
        $data = Db::table($name[0]['board'])->select();
//        dump($data);


        $this->assign('name', $name[0]);
        $this->assign('data', $data);
//        dump($data);

        return $this->fetch();
    }

    //新话题编辑界面
    public function newTopic($name){
        $id = Db::query("select id from home where board=?", [$name]);

        $this->assign('id', $id[0]);
        $this->assign('name', $name);
        return $this->fetch();
    }
    //新话题存储进数据库
    public function insertDatabase($name){
        //接受全部post数据
        $data = input('post.');
        $time = date('Y-m-d H:i:s');
        $data["create_time"] = $time;
//        dump($data);
//        dump($name);
        //插入数据库
        $code1 = Db::execute("insert into post value (null, :topic, :content, :create_time)", $data);
        $temp['topic'] = $data['topic'];
        $temp['start'] = 'jojo';
        $code2 = Db::table($name)->insert($temp);


        if($code2 && $code1){
            $id = Db::table('home')->where('board', $name)->value('id');
            $this->success("发表成功", "/board/{$id}");
        }
        else{
            $this->error("发表失败", "/newTopic/{$name}");
        }
    }

    //帖子内容
    public function content($topic){
        //查询数据
        $data = Db::query("select * from post where topic = ?", [$topic]);

        $this->assign('data', $data[0]);

        return $this->fetch();
    }
}
