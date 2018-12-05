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

    /**
     *  1.有user_id: 返回[post_id]
     * 2.无user_id: 返回user_id和[post_id]
     * start_time和end_time可选,
     * 有start_time无end_time默认到当前时间
     */
    public function get_user_post_ids(){
        $data = $this->params;
        $this->check_token($data);

        if($data['user_id']) {
            if (!$data['start_time'] && !$data['end_time']) {
                $db_res = db('wp_posts')
                    ->field('ID')
                    ->where('post_author', $data['user_id'])
                    ->where('post_type', 'in', ['post', 'yada_wiki'])
                    ->select();
            } else if ($data['start_time'] && $data['end_time']) {
                $db_res = db('wp_posts')
                    ->field('ID')
                    ->where('post_author', $data['user_id'])
                    ->where('post_date', 'between time', [$data['start_time'], $data['end_time']])
                    ->where('post_type', 'in', ['post', 'yada_wiki'])
                    ->select();
            } else if ($data['start_time'] && !$data['end_time']) {
                $db_res = db('wp_posts')
                    ->field('ID')
                    ->where('post_author', $data['user_id'])
                    ->whereTime('post_date', '>=', $data['start_time'])
                    ->where('post_type', 'in', ['post', 'yada_wiki'])
                    ->select();
            }


            $return_res = array();
            if ($db_res) {
                foreach ($db_res as $k => $val) {
                    foreach ($val as $k2 => $val2) {
                        $id_list[] = $val2;
                    }
                }

                $return_res['post_id'] = $id_list;
            }
        }else {
            if( $data['start_time'] && $data['end_time']) {
                $db_res = db('wp_posts')
                    ->field('ID,post_author')
                    ->where('post_date', 'between time', [$data['start_time'], $data['end_time']])
                    ->where('post_type', 'in', ['post', 'yada_wiki'])
                    ->select();
            }
            else if($data['start_time'] && ! $data['end_time']){
                $db_res = db('wp_posts')
                    ->field('ID,post_author')
                    ->whereTime('post_date', '>=', $data['start_time'])
                    ->where('post_type', 'in', ['post', 'yada_wiki'])
                    ->select();
            }

            $user_id_list = array();
            foreach ($db_res as $item) {
                if(! in_array($item['post_author'], $user_id_list)){
                    $user_id_list[] = $item['post_author'];
                }
            }

            //var_dump($user_id_list);

            $return_res_arr = array();
            foreach ($db_res as $ele) {
                if(in_array($ele['post_author'] , $user_id_list )){
                    $return_res_arr[$ele['post_author']][] = $ele['ID'];
                }
            }

            foreach ($return_res_arr as $k=>$val){
                $return_res_temp['user_id'] = $k;
                $return_res_temp['post_id'] = $val;

                $return_res[] = $return_res_temp;
            }
        }


        if ($return_res) {
            $this->return_msg(200, '查询成功！', $return_res);
        } else {
            $this->return_msg(400, '查询失败！');
        }
    }


    public function get_online_info(){
        //获取请求参数
        $data = $this->params;

        $this->check_token($data);

        /*if($data['user_id'] ){
            if( !$data['start_time'] && !$data['end_time']) {
                $history_res = db('wp_simple_history_contexts')
                    ->field('history_id')
                    ->where('key', 'user_id')
                    ->where('value', $data['user_id'])
                    ->select();


                $history_id_list = $this->array_select($history_res);

                $time_res = db('wp_simple_history')
                    ->field('date')
                    ->where('logger', 'SimpleUserLogger')
                    ->where('message', 'Logged in')
                    ->where('id', 'in', $history_id_list)
                    ->select();
            }
        }*/

        $db_res = db('wp_simple_history')
            ->alias('a')
            ->join('wp_simple_history_contexts c','a.id = c.history_id')
            ->field('value,date')
            ->where('logger', 'SimpleUserLogger')
            ->where('message', 'Logged in')
            ->where('key', 'user_id')
            ->select();

        if($data['user_id'] ){ //has user id in param

            if($data['start_time'] && $data['end_time']){
                foreach ($db_res as $item){
                    if($item['value'] == $data['user_id'] && $item['date'] >= $data['start_time'] && $item['date'] <= $data['end_time']){
                        $filter_res[] = $item;
                    }
                }
            }else if($data['start_time'] && ! $data['end_time']){
                foreach ($db_res as $item){
                    if($item['value'] == $data['user_id'] && $item['date'] >= $data['start_time'] ){
                        $filter_res[] = $item;
                    }
                }
            }else {
                foreach ($db_res as $item) {
                    if ($item['value'] == $data['user_id']) {
                        $filter_res[] = $item;
                    }
                }
            }

            foreach ($filter_res as $item){
                $time_list[] = $item['date'];
            }

            $return_res['online_time'] = $this->online_duration_count($time_list);
        }else if($data['start_time'] ){ //No user id in param

            if($data['end_time']){
                foreach ($db_res as $item){
                    if($item['date'] >= $data['start_time'] && $item['date'] <= $data['end_time']){
                        $filter_res[] = $item;
                    }
                }
            }else{
                foreach ($db_res as $item){
                    if($item['date'] >= $data['start_time'] ){
                        $filter_res[] = $item;
                    }
                }
            }


            //get all user ids
            $user_id_list = array();
            foreach ($filter_res as $item) {
                if(! in_array($item['value'], $user_id_list)){
                    $user_id_list[] = $item['value'];
                }
            }

            foreach ($user_id_list as $user){
                $temp_res['user_id'] = $user;
                $time_list = array();
                foreach ($filter_res as $item) {
                    if($item['value'] == $user){
                        $time_list[] = $item['date'];
                    }
                }

                $temp_res['online_time'] = $this->online_duration_count($time_list);

                $return_res[] = $temp_res;
            }
        }


        if ($return_res) {
            $this->return_msg(200, '查询成功！', $return_res);
        } else {
            $this->return_msg(400, '查询失败！');
        }
    }

    /**
     * 获得morning、noon、afternoon、evening、midnight的登录次数
     * @param [array] $time_list: 时间的数组
     * @return [json]
    */
    public function online_duration_count($time_list){
        $return_res['morning'] = 0 ;
        $return_res['noon'] = 0 ;
        $return_res['afternoon'] = 0 ;
        $return_res['evening'] = 0 ;
        $return_res['midnight'] = 0 ;

        foreach ($time_list as $date){
            $time = explode(' ',$date)[1];
            if($time >= "06:00:00" &&  $time <= "12:00:00"){
                $return_res['morning']++;
            }else if($time >= "12:00:00" &&  $time <= "14:00:00"){
                $return_res['noon']++;
            }else if($time >= "14:00:00" &&  $time <= "18:00:00") {
                $return_res['afternoon']++;
            }else if($time >= "18:00:00" &&  $time <= "24:00:00"){
                $return_res['evening']++;
            }else if($time >= "00:00:00" &&  $time <= "06:00:00"){
                $return_res['midnight']++;
            }
        }

        return $return_res;
    }

    public function get_register_time(){
        //获取请求参数
        $data = $this->params;

        $this->check_token($data);

        if($data['user_id'] && !$data['start_time'] && !$data['end_time']) {
            $db_res = db('wp_users')
                ->field('user_registered')
                ->where('ID', $data['user_id'])
                ->find();
            //if($db_res['user_registered']){
            //   $db_res['register_time'] = $db_res['user_registered'];
            //}

        }else if(!$data['user_id'] && $data['start_time'] && $data['end_time']){
            $db_res = db('wp_users')
                ->field('ID,user_registered')
                ->where('user_registered', 'between time',[$data['start_time'],$data['end_time']])
                ->order('ID')
                ->select();

        }else if(!$data['user_id'] && $data['start_time'] && !$data['end_time']){
            $db_res = db('wp_users')
                ->field('ID,user_registered')
                ->whereTime('user_registered', '>=', $data['start_time'])
                ->order('ID')
                ->select();
        }

        if ($db_res) {
            $this->return_msg(200, '查询成功！', $db_res);
        } else {
            $this->return_msg(400, '查询失败！');
        }
    }

}
