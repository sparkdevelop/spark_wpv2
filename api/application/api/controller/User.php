<?php
namespace app\api\controller;
class User extends Common {
    public function test(){
        $data = $this->params;
        $keywords = array();
        $keywords = array_select($db_res);
        $test = "success";
        $db_res = db('wp_users')
            ->field('user_login')
            ->where('id', $data['id'])
            ->find();
        $this->return_msg(200, '成功!', $db_res);
    }

    public function user(){
        //获取请求参数
        $data = $this->params;
        $this->check_token($data);
        //var_dump($data['user_id']);
        $db_res = db('user_rank')->field('rank2')->where('user_id',$data['user_id'])->find();
        if($db_res){
            $this->return_msg(200,'查询成功！',$db_res);
        }else{
            $this->return_msg(400,'查询失败！');
        }

    }

}
