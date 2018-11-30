<?php
namespace app\api\controller;
class User extends Common {
    public function test(){
        $data = $this->params;
        $test = "success";
        /*$db_res = db('wp_users')
            ->field('user_login')
            ->where('id', $data['id'])
            ->find();*/
        $this->return_msg(200, '成功!', $test);
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

    /**
     * 提供用户发布的词条和项目总个数
     */
    public function posts_count(){
        //获取请求参数
        $data = $this->params;
        $this->check_token($data);
        if($data['end_time']){
            $db_res = db('wp_posts')
                ->field('ID')
                ->where('post_date','between time',[$data['start_time'],$data['end_time']])
                ->where('post_status','=','publish')
                ->where('post_type','in',['post','yada_wiki'])
                ->where('post_author',$data['user_id'])
                ->count();
        }else{
            $db_res = db('wp_posts')
                ->field('ID')
                ->whereTime('post_date', '>=', $data['start_time'])
                ->where('post_status','=','publish')
                ->where('post_type','in',['post','yada_wiki'])
                ->where('post_author',$data['user_id'])
                ->count();
        }

        if($db_res){
            $post_res['user_id'] = $data['user_id'];
            $post_res['publish_count'] = $db_res;

            $this->return_msg(200,'查询成功！',$post_res);
        }else{
            $this->return_msg(400,'查询失败！');
        }

    }

    /**
     * 提供用户的积分数据
     */
    public function points(){
        //获取请求参数
        $data = $this->params;
        $this->check_token($data);
        //var_dump($data['user_id']);
        $db_res = db('wp_user_integral')->field('integral')->where('user_id',$data['user_id'])->find();
        if($db_res){
            $db_res['user_id']=$data['user_id'];

            $this->return_msg(200,'查询成功！',$db_res);
        }else{
            $this->return_msg(400,'查询失败！');
        }

    }

    /**
     * 提供用户浏览的词条项目的post_id和次数
     */
    public function posts_browse(){
        //获取请求参数
        $data = $this->params;
        $this->check_token($data);
        if($data['end_time']){
            $db_res = db('wp_user_history')
                ->field('action_post_id')
                ->where('action_time','between time',[$data['start_time'],$data['end_time']])
                ->where('user_action','=','browse')
                ->where('action_post_type','in',['post','yada_wiki'])
                ->where('user_id',$data['user_id'])
                ->order('action_post_id')
                ->select();
        }else{
            $db_res = db('wp_user_history')
                ->field('action_post_id')
                ->whereTime('action_time', '>=', $data['start_time'])
                ->where('user_action','=','browse')
                ->where('action_post_type','in',['post','yada_wiki'])
                ->where('user_id',$data['user_id'])
                ->order('action_post_id')
                ->select();
        }
        if($db_res){
            foreach ($db_res as $k=>$arr){
                $post_res[$k] = $arr['action_post_id'];
            }
            $post_count=array_count_values($post_res);
            foreach ($post_count as $p=>$c) {
                $tmp['Id']=$p;
                $tmp['Count']=$c;
                $post_info[]=$tmp;
            }
            $post['user_id'] = $data['user_id'];
            $post['view_post'] = $post_info;

            $this->return_msg(200,'查询成功！',$post);
        }else{
            $this->return_msg(400,'查询失败！');
        }

    }


}
