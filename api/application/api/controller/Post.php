<?php
namespace app\api\controller;
class Post extends Common {
    public function keywords(){
        $data = $this->params;
        $this->check_token($data);
        if($data['end_time']){
            $post_res = db('wp_posts')
                ->field('ID,post_title,post_content')
                ->where('post_date','between time',[$data['start_time'],$data['end_time']])
                ->where('post_status','=','publish')
                ->where('post_type','in',['post','yada_wiki'])
                ->order('ID')
                ->select();
        }else{
            $post_res = db('wp_posts')
                ->field('ID,post_title,post_content')
                ->whereTime('post_date', '>=', $data['start_time'])
                ->where('post_status','=','publish')
                ->where('post_type','in',['post','yada_wiki'])
                ->order('ID')
                ->select();
        }
        if($post_res){
            foreach ($post_res as $k =>$arr){
                $keyword_res = db('wp_post_keywords')
                    ->field('keyword')
                    ->where('post_id', $arr['ID'])
                    ->select();
                if($keyword_res){
                    $keywords  = $this->array_select($keyword_res);
                    $post_res[$k]['keywords'] = $keywords;
                }
            }
            $this->return_msg(200, '获取文章信息成功!',$post_res);
        }else{
            $this->return_msg(400, '该时间段内无文章!');
        }

    }
}