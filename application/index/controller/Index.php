<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Model;
use think\Cookie;

class Index extends  Controller
{
    //主页显示
    public function index()
    {
        $name = Cookie::get('name');
        $data = Db::query("select * from home");

        $this->assign('data', $data);
        $this->assign('name', $name);

        return view();
    }

    //板块显示
    public function board($id)
    {
        $username = Cookie::get('name');
        $this->assign('name', $username);

        $name = Db::query("select board from home where id=?", [$id]);
//        dump($name[0]['board']);
//        $data = Db::query("select * from ?", [$name[0]['board']]);
        $data = Db::table($name[0]['board'])->select();
//        dump($data);


        $this->assign('board_name', $name[0]['board']);
        $this->assign('data', $data);
//        dump($data);

        return $this->fetch();
    }

    //新话题编辑界面
    public function newTopic($name){
        $username = Cookie::get('name');
        $this->assign('name', $username);

        $id = Db::query("select id from home where board=?", [$name]);
//        dump($id);

        $this->assign('id', $id[0]['id']);
        $this->assign('newName', $name);
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

    //帖子内容  表创建问题
    public function content($name, $topic){
        //查询数据
        $data = Db::query("select * from post where topic = ?", [$topic]);
        $table_name = $name."_".$topic."_"."reply";
        $reply = Db::table($table_name)->select();
//        dump($reply);
        $start = Db::table($name)->where('topic', $topic)->value('start');
//        dump($data);
//        dump($name);
        $username = Cookie::get('name');

        $id = Db::table('home')->where('board', $name)->value('id');
        $this->assign('data', $data[0]);
        $this->assign('name', $username);
        $this->assign('topic_name', $name);
        $this->assign('id', $id);
        $this->assign('start', $start);

        if($reply != null){
            $this->assign('reply', $reply);
        }

        return $this->fetch();
    }
    //回复功能
    public function reply($name, $topic){

        $username = Cookie::get('name');
        $this->assign('name', $username);

        $id = Db::table('home')->where('board', $name)->value('id');
        $this->assign('name', $username);
        $this->assign('topic_name', $name);
        $this->assign('small_topic', $topic);
        $this->assign('id', $id);


        return $this->fetch();
    }
    //回复内容插入数据库
    public function replyInsert(){
        //获取回复内容
        $data = input('post.');

        if($data['text'] == null){
            $this->error('回复不能为空');
        }

//        dump($data);
        //拼凑表名
        $tableName = $data['board']."_".$data['topic']."_reply";
        $board = $data['board'];
        $topic = $data['topic'];
//        dump($tableName);

        //获取当前用户
        $name = Cookie::get('name');
        $this->assign('name', $name);
        //获取第几位评论数
        $rank = Db::table($tableName)->min('ran');
//        dump($rank);
        $rank++;

        $temp['user'] = $name;
        $temp['ran'] = $rank;
        $temp['content'] = $data['text'];
        $code = Db::table($tableName)->insert($temp);

        if($code){
            $this->success('评论成功', "/content/{$board}/{$topic}");
        }
        else{
            $this->error('评论失败');
        }

    }
}
