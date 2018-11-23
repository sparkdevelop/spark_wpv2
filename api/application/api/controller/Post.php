<?php
namespace app\api\controller;
class Post extends Common {
    public function keywords(){
        $data = $this->params;
        $this->check_token($data);
        $db_res = db('wp_post_keywords')
            ->field('keyword')
            ->where('post_id', $data['post_id'])
            ->select();
        if($db_res){
            var_dump($data);
            $keywords  = $this->array_select($db_res);
            $this->return_msg(200, '获取关键词成功!', $keywords);
        }else{
            $this->return_msg(400, '无关键词!');
        }

    }
}