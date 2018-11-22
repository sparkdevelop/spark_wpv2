<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/19/019
 * Time: 11:11
 */
header("Content-type: text/html; charset=utf-8");

function group_bad(){
    global $wpdb;
    $n=0;
    $project = $wpdb->get_results("SELECT `name` FROM `students_goal`  ");
    foreach ($project as $a) {
        $user[$n] = $a->name;
        $n++;
    }
    $c=count($user);$m=0;
    while($c>0){
        $class_group[$m]=$wpdb->get_var("SELECT `class-group` FROM `students_group` where `name`='$user[$m]'");
        $m++;
        $c--;
    }
    return $class_group;
}
function group_analysis(){
    $class_group=group_bad();
    $class_group=array_count_values($class_group);
    arsort($class_group);
    return $class_group;
}

function group_low($team)    //小组内低于4分人数
{
    global $wpdb;
    $n=0;
    $project = $wpdb->get_results("SELECT `name` FROM `students_group` where  `class-group`='$team'");
    foreach ($project as $a) {
        $user[$n] = $a->name;
        $n++;
    }
    $c=count($user);$m=0;
    if($c==0)//查无此组
        $user_low=0;
    while($c>0){
        $class_group=$wpdb->get_var("SELECT * FROM `students_goal` where `name`='$user[$m]'");
        if($class_group){
            $user_low[$m]=$user[$m];
        }
        $m++;
        $c--;
    }
    $c=count($user_low);
    if($c==0)
        $user_low=1;//该组所有人都大于4分
    return $user_low;
}
function group_his($team){
    global $wpdb;
    $date=date("Y-m-d H:i:s",strtotime("-7 days"));
    $total=$wpdb->get_var("select count(*) from wp_user_history where unix_timestamp(action_time) > unix_timestamp('$date')");

//    $begin=$total-200000;
    $n=0;
    $project = $wpdb->get_results("SELECT `name` FROM `students_group` where  `class-group`='$team'");
    foreach ($project as $a) {
        $user[$n] = $a->name;
        $n++;
    }
    $c=count($user);        $n=0;
    while($c>0){
        $sparkid[$n] = $wpdb->get_var("SELECT `spark_id` FROM `students` where  `name`='$user[$n]'");
        $n++;
        $c--;
    }
    $c=count($sparkid);  $n=0;           $history_total=0;
    while($c>0){
        $history[$n] = $wpdb->get_var("select count(*) from `wp_user_history` where `user_id`='$sparkid[$n]' and unix_timestamp(action_time) > unix_timestamp('$date')");
        $history_total=$history_total+$history[$n];
        $n++;
        $c--;

    }
    $c=count($sparkid);
    $history_ver=$history_total/$c;
    $total_ver=$total/850;
    $his=["$history_ver","$total_ver","$history[0]","$history[1]","$history[2]","$history[3]","$user[0]","$user[1]","$user[2]","$user[3]"];
    return $his;
}
//function
?>