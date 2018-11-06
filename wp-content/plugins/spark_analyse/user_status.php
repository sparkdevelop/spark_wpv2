<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/10/010
 * Time: 10:29
 */
ini_set("memory_limit","-1");
set_time_limit(0);
global $wpdb;
$total=$wpdb->get_var("select count(*) from `wp_user_history`");
$begin=$total-200000;
$user = $wpdb->get_results("SELECT `name`,`spark_id`,`stu_number` FROM `students` ");
$m=0;
foreach ($user as $a) {
    $userid[$m] = $a->spark_id;
    $username[$m]=$a->name;
    $usernum[$m]=$a->stu_number;
    $m++;
}

$c=count($userid);
//取两个数据表history 和 chain_log中的数据
$user = $wpdb->get_results("SELECT user_id,ID,action_post_id FROM `wp_user_history` where ID>$begin");
$m=0;
foreach ($user as $a) {
    $user_history_id[$m] = $a->user_id;
    $user_history_ID[$m]=$a->ID;
    $user_history_action_id[$m]=$a->action_post_id;
    $m++;
}
$user = $wpdb->get_results("SELECT user_id,page,Id FROM `chain_log` ");
$m=0;
foreach ($user as $a) {
    $user_chain_id[$m] = $a->user_id;
    $user_chain_page[$m]=$a->page;
    $user_chain_ID[$m]=$a->Id;
    $m++;
}
function noundata(){
    global $user_chain_id;
    global $user_history_id;
    global $usernum;
    global $username;

    $c=791;$m=0;        $b=2018210001;
    while($c>0){
        $student_total[$m]=$b;
        $b=$b+1;
        $m++;
        $c--;
    }
    $user_noun=array_diff($student_total,$usernum);
    return $user_noun;

//    print_r($usernum);
}
function history_backward()
{
    global $userid;
    global $usernum;
    global $wpdb;
    global $user_history_id;
    global $user_history_ID;
    global $user_history_action_id;
    global $user_chain_id;
    global $user_chain_page;
    global $user_chain_ID;
    $c = count($user_history_id);
    $m = 0;
    $user_history_old = [];
    $user_history_old_num = [];
    $user_history_old_num_geshu = [];//计算平均浏览
    while ($c > 0) {
        if (!in_array($user_history_action_id[$m], $user_history_old)) {
            $user_history_old[$m] = $user_history_action_id[$m];
            $user_history_old_num[$m] = 0;
            $user_history_old_num[$m] = $user_history_old_num[$m] + $user_history_ID[$m];
            $user_history_old_num_geshu[$m] = 0;
            $user_history_old_num_geshu[$m]++;
        } else {
            $key = array_search($user_history_action_id[$m], $user_history_old);
            $user_history_old_num[$key] = $user_history_old_num[$key] + $user_history_ID[$m];
            $user_history_old_num_geshu[$key]++;
        }
        $m++;
        $c--;
    }
    //排除个别人浏览页面过于超前影响
    $c = count($user_history_old_num);
    $m = 0;
    while ($c > 0) {
        if ($user_history_old_num_geshu[$m] < 40)
            $user_history_old_num_geshu[$m] = $user_history_old_num_geshu[$m] + 20000;
        $m++;
        $c--;
    }
    //计算页面浏览进度排序
    $c = count($user_history_old_num);
    $m = 0;
    while ($c > 0) {
        $user_history_old_num_per[$m] = $user_history_old_num[$m] / $user_history_old_num_geshu[$m];
        $m++;
        $c--;
    }
    arsort($user_history_old_num_per);
    $user_history_old_num_per_key = array_keys($user_history_old_num_per);
    $c = 20;
    $m = 0;
    while ($c > 0) {
        $history[$m] = $user_history_old[$user_history_old_num_per_key[$m]];
        $m++;
        $c--;
    }
//    print_r($user_history_old_num_per);
//    print_r($user_history_old);
    $c=count($history);$m=0;
    while($c>0){
        if($history[$m]==432 or $history[$m]==235 or $history[$m]==426 or $history[$m]==418 or $history[$m]==0 or $history[$m]==4605 or $history[$m]==481 or $history[$m]==420 or $history[$m]==422)
            unset($history[$m]);
        $m++;
        $c--;
    }
    $history=array_merge($history);
    return $history;
}
function history_show(){
    global $wpdb;
    $history=history_backward();
    $c=10;$m=0;
    while($c>0){
        $title[$m] = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$history[$m]'");
        $m++;
        $c--;
    }
    return $title;
}
function chain_backward(){
    global $userid;
    global $usernum;
    global $wpdb;
    global $user_history_id;
    global $user_history_ID;
    global $user_history_action_id;
    global $user_chain_id;
    global $user_chain_page;
    global $user_chain_ID;
    $c=count($user_chain_id);
    $m=0;
    $user_chain_old=[];
    $user_chain_old_num=[];
    $user_chain_old_num_geshu=[];//计算平均浏览
    while($c>0){
        if(!in_array($user_chain_page[$m],$user_chain_old)){
            $user_chain_old[$m]=$user_chain_page[$m];
            $user_chain_old_num[$m]=0;
            $user_chain_old_num[$m]=$user_chain_old_num[$m]+$user_chain_ID[$m];
            $user_chain_old_num_geshu[$m]=0;
            $user_chain_old_num_geshu[$m]++;
        }
        else{
            $key = array_search($user_chain_page[$m],$user_chain_old);
            $user_chain_old_num[$key]=$user_chain_old_num[$key]+$user_chain_ID[$m];
            $user_chain_old_num_geshu[$key]++;
        }
        $m++;
        $c--;
    }
//    print_r($user_chain_old_num);
//    print_r($user_chain_old_num_geshu);
//    print_r($user_chain_old);
    //排除个别人浏览页面过于超前影响
    $c=count($user_chain_old_num);
    $m=0;
    while($c>0){
        if($user_chain_old_num_geshu[$m]<30)
            $user_chain_old_num_geshu[$m]=$user_chain_old_num_geshu[$m]+20000;
        $m++;
        $c--;
    }
    //计算页面浏览进度排序
    $c=count($user_chain_old_num);
    $m=0;
    while($c>0){
        $user_chain_old_num_per[$m]=$user_chain_old_num[$m]/$user_chain_old_num_geshu[$m];
        $m++;
        $c--;
    }
    arsort($user_chain_old_num_per);
    $user_chain_old_num_per_key=array_keys($user_chain_old_num_per);
    $c=20;$m=0;
    while($c>0){
        $chain[$m]=$user_chain_old[$user_chain_old_num_per_key[$m]];
        $m++;
        $c--;
    }
//    print_r($user_history_old_num_per);
//    print_r($user_history_old);
    return $chain;
}

function is_user_backward(){

    global $wpdb;
    global $userid;
    global $begin;
    global $username;
    $history=history_backward();
    $c=count($userid);$m=0;
    while($c>0){
        $user_history = $wpdb->get_results("SELECT action_post_id FROM `wp_user_history` where user_id='$userid[$m]' and ID>$begin ");
        $n=0;
        foreach ($user_history as $a) {
            $user_history_id[$m][$n]=$a->action_post_id;
            $n++;
        }
        $history_jiaoji[$m]=array_intersect($history,$user_history_id[$m]);
        $m++;
        $c--;
    }
    $chain=chain_backward();
    $c=count($userid);$m=0;
    while($c>0){
        $user_chain = $wpdb->get_results("SELECT page FROM `chain_log` where user_id='$userid[$m]'");
        $n=0;
        foreach ($user_chain as $a) {
            $user_chain_id[$m][$n]=$a->page;
            $n++;
        }
        $chain_jiaoji[$m]=array_intersect($chain,$user_chain_id[$m]);
        $m++;
        $c--;
    }
    $c=count($userid);$m=0;
    while($c>0){
        if(count($history_jiaoji[$m])<2 and count($chain_jiaoji[$m])<2){
                $user_backward[$m]=$username[$m];
        }
        $m++;
        $c--;
    }

    return $user_backward;
}
//function data_geshi(){
//    global $userid;
//    global $usernum;
//    $c=count($userid);
//    $m=0;
//    while($c>0){
//        if($userid[$m]<10000){
//            unset($userid[$m]);
//            unset($usernum[$m]);
//        }
//        $m++;
//        $c--;
//    }
//    $userid=array_merge($userid);
//    $usernum=array_merge($usernum);
//}
