<?php
/**
 * Created by PhpStorm.
 * User: zylbl
 * Date: 2020/4/6
 * Time: 20:24
 */

namespace app\api\controller;

use think\Request;

class Statement extends Common
{
    public function index()
    {
        // 是否为 GET 请求
        if (Request::instance()->isGet()) {
            //获取请求参数
            $data = array(
                'user_id' => 1
            );
            $this->return_msg(200,'查询成功！',$db_res);
            //var_dump($data['user_id']);
//            $db_res = db('wp_user_integral')->field('integral')->where('user_id',$data['user_id'])->find();
//            if($db_res){
//                $db_res['user_id']=$data['user_id'];
//
//                $this->return_msg(200,'查询成功！',$db_res);
//            }else{
//                $this->return_msg(400,'查询失败！');
//            }
        }
        // 是否为 POST 请求
        if (Request::instance()->isPost()) {
            //获取请求参数
            $data = array(
                'user_id' => 1,
                'start_time' => '2017-01-01',
                'end_time' => '2020-01-01'
            );
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


    }
}