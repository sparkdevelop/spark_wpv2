<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/9
 * Time: 16:24
 */
global $wpdb;
$user = $wpdb->get_results("SELECT ID FROM `$wpdb->users` order by `ID`");
$m=0;
foreach ($user as $a) {
    $userlist[$m] = $a->ID;
    $m++;
}
$c=count($userlist);
//function active_p(){
//    global $wpdb;
//    $m=0;
//    global $userlist;
//    $c=count($userlist);
//    while($c>0){
//        $num[$m]=$wpdb->get_var("SELECT COUNT(*) FROM `wp_user_history` where user_id='$userlist[$m]'");
//        $id[$m]=$userlist[$m];
//        $m++;
//        $c--;
//    }
////    print_r($num);
////    print_r($id);
//    $pos=array_search(max($num),$num);
////    echo $id[$pos];
//    $username1=$wpdb->get_var("SELECT user_login FROM `wp_users` where ID='$id[$pos]'");
//    unset($num[$pos]);
//    $pos=array_search(max($num),$num);
//
//    $username2=$wpdb->get_var("SELECT user_login FROM `wp_users` where ID='$id[$pos]'");
//    unset($num[$pos]);
//    $pos=array_search(max($num),$num);
//    $username3=$wpdb->get_var("SELECT user_login FROM `wp_users` where ID='$id[$pos]'");
//$username=("$username1,$username2,$username3");
//    return $username;
//}
function create(){
    global $wpdb;
//    $user = $wpdb->get_results("SELECT ID FROM `$wpdb->users` order by `ID`");
//    $m=0;
//    foreach ($user as $a) {
//        $userlist[$m] = $a->ID;
//        $m++;
//    }
////    print_r($userlist);
    global  $userlist;
    $c=count($userlist);
    $m=0;
    $num=array(0);
    while($c>0){
        $num[$m]=$wpdb->get_var("SELECT COUNT(*) FROM `wp_posts` where post_author='$userlist[$m]' and post_type='post' or post_type='revision'");
        $id[$m]=$userlist[$m];
        $m++;
        $c--;
    }
//    print_r($num);
//    print_r($id);
    $pos=array_search(max($num),$num);
//    echo $id[$pos];
    $username1=$wpdb->get_var("SELECT user_login FROM `wp_users` where ID='$id[$pos]'");
    unset($num[$pos]);
    $pos=array_search(max($num),$num);
//    echo $id[$pos];
    $username2=$wpdb->get_var("SELECT user_login FROM `wp_users` where ID='$id[$pos]'");

    unset($num[$pos]);
    $pos=array_search(max($num),$num);
//    echo $id[$pos];
    $username3=$wpdb->get_var("SELECT user_login FROM `wp_users` where ID='$id[$pos]'");
    $username=("$username1,$username2,$username3");
    return $username;
}
function question(){
    global $wpdb;
//    $user = $wpdb->get_results("SELECT ID FROM `$wpdb->users` order by `ID`");
//    $m=0;
//    foreach ($user as $a) {
//        $userlist[$m] = $a->ID;
//        $m++;
//    }
   global $userlist;
    $c=count($userlist);
    $m=0;
    while($c>0){
        $num[$m]=$wpdb->get_var("SELECT COUNT(*) FROM `wp_posts` where post_author='$userlist[$m]' and post_type='dwqa-question'");
        $id[$m]=$userlist[$m];
        $m++;
        $c--;
    }
//    print_r($num);
//    print_r($id);
    $pos=array_search(max($num),$num);
//    echo $id[$pos];
    $username1=$wpdb->get_var("SELECT user_login FROM `wp_users` where ID='$id[$pos]'");

    unset($num[$pos]);
    $pos=array_search(max($num),$num);

    $username2=$wpdb->get_var("SELECT user_login FROM `wp_users` where ID='$id[$pos]'");

    unset($num[$pos]);
    $pos=array_search(max($num),$num);
    $username3=$wpdb->get_var("SELECT user_login FROM `wp_users` where ID='$id[$pos]'");
    $username=("$username1,$username2,$username3");
    return $username;
}
function answer(){
    global $wpdb;
//    $user = $wpdb->get_results("SELECT ID FROM `$wpdb->users` order by `ID`");
//    $m=0;
//    foreach ($user as $a) {
//        $userlist[$m] = $a->ID;
//        $m++;
//    }
    global $userlist;
    $c=count($userlist);
    $m=0;
    while($c>0){
        $num[$m]=$wpdb->get_var("SELECT COUNT(*) FROM `wp_posts` where post_author='$userlist[$m]' and post_type='dwqa-answer'");
        $id[$m]=$userlist[$m];
        $m++;
        $c--;
    }
//    print_r($num);
//    print_r($id);
    $pos=array_search(max($num),$num);
//    echo $id[$pos];
    $username1=$wpdb->get_var("SELECT user_login FROM `wp_users` where ID='$id[$pos]'");
    unset($num[$pos]);
    $pos=array_search(max($num),$num);

    $username2=$wpdb->get_var("SELECT user_login FROM `wp_users` where ID='$id[$pos]'");
    unset($num[$pos]);
    $pos=array_search(max($num),$num);
    $username3=$wpdb->get_var("SELECT user_login FROM `wp_users` where ID='$id[$pos]'");
    $username=("$username1,$username2,$username3");
    return $username;
}
function active_before(){
    global $wpdb;
    $m=0;
    global $userlist;
    $c=count($userlist);
    $now=time();
    $time = strtotime('-2 day', $now);
    $beginTime = date('Y-m-d 00:00:00', $time);
//    echo $beginTime;
    $timelis = $wpdb->get_results("SELECT action_time,ID FROM `wp_user_history` order by `ID`");
    $m=0;
    foreach ($timelis as $a) {
        $timelist[$m] = $a->action_time;
        $time_ID_list[$m]=$a->ID;
        $m++;
    }
    $c=count($timelis);
    $m=0;
    while($c>0){
        if(strtotime($timelist[$m])>strtotime($beginTime)){
            $a = $time_ID_list[$m];
            break;
         }
        $m++;
        $c--;
    }
//    echo $a ;
    $m=0;
    $c=count($userlist);
    while($c>0){
        $num[$m]=$wpdb->get_var("SELECT COUNT(*) FROM `wp_user_history` where user_id='$userlist[$m]' and ID>'$a'");
        $id[$m]=$userlist[$m];
        $m++;
        $c--;
    }
//    print_r($num);
//    print_r($id);
    $pos=array_search(max($num),$num);
//    echo $id[$pos];
    $username1=$wpdb->get_var("SELECT user_login FROM `wp_users` where ID='$id[$pos]'");
    unset($num[$pos]);
    $pos=array_search(max($num),$num);

    $username2=$wpdb->get_var("SELECT user_login FROM `wp_users` where ID='$id[$pos]'");
    unset($num[$pos]);
    $pos=array_search(max($num),$num);
    $username3=$wpdb->get_var("SELECT user_login FROM `wp_users` where ID='$id[$pos]'");
    $username=("$username1,$username2,$username3");
    return $username;
}
function create_before(){
    global $wpdb;
    $m=0;
    global $userlist;
    $c=count($userlist);
    $now=time();
    $time = strtotime('-2 day', $now);
    $beginTime = date('Y-m-d 00:00:00', $time);
//    echo $beginTime;
    $postlis = $wpdb->get_results("SELECT post_date,ID FROM `wp_posts` order by `ID`");
    $m=0;
    foreach ($postlis as $a) {
        $postlist[$m] = $a->post_date;
        $post_ID_list[$m]=$a->ID;
        $m++;
    }
    $c=count($postlist);
    $m=0;
    while($c>0){
        if(strtotime($postlist[$m])>strtotime($beginTime)){
            $a = $post_ID_list[$m];
            break;
        }
        $m++;
        $c--;
    }
//    echo $a ;
    $m=0;
    $c=count($userlist);
    while($c>0){
        $num[$m]=0;//防止没有人在三天内创建的情况
//         @$num[$m] = $wpdb->get_var("SELECT COUNT(*) FROM `wp_posts` where post_author='$userlist[$m]' and ID>'$a' and post_type='post' or post_type='revision'");

        $id[$m]=$userlist[$m];
        $m++;
        $c--;
    }
//    print_r($num);
//    print_r($id);
    $pos=array_search(max($num),$num);
//    echo $id[$pos];
    $username1=$wpdb->get_var("SELECT user_login FROM `wp_users` where ID='$id[$pos]'");
    unset($num[$pos]);
    $pos=array_search(max($num),$num);

    $username2=$wpdb->get_var("SELECT user_login FROM `wp_users` where ID='$id[$pos]'");
    unset($num[$pos]);
    $pos=array_search(max($num),$num);
    $username3=$wpdb->get_var("SELECT user_login FROM `wp_users` where ID='$id[$pos]'");
    $username=("$username1,$username2,$username3");
    return $username;
}
function question_before(){
    global $wpdb;
    $now=time();
    $time = strtotime('-2 day', $now);
    $beginTime = date('Y-m-d 00:00:00', $time);
//    echo $beginTime;
    $postlis = $wpdb->get_results("SELECT post_date,ID FROM `wp_posts` order by `ID`");
    $m=0;
    foreach ($postlis as $a) {
        $postlist[$m] = $a->post_date;
        $post_ID_list[$m]=$a->ID;
        $m++;
    }
    $c=count($postlist);
    $m=0;
    while($c>0){
        if(strtotime($postlist[$m])>strtotime($beginTime)){
            $a = $post_ID_list[$m];
            break;
        }
        $m++;
        $c--;
    }

    global $userlist;
    $c=count($userlist);
    $m=0;
    while($c>0){
        $num[$m]=0;//防止没有人在三天内创建的情况
     //   $num[$m]=$wpdb->get_var("SELECT COUNT(*) FROM `wp_posts` where post_author='$userlist[$m]' and post_type='dwqa-question' and ID>'$a'");
        $id[$m]=$userlist[$m];
        $m++;
        $c--;
    }
//    print_r($num);
//    print_r($id);
    $pos=array_search(max($num),$num);
//    echo $id[$pos];
    $username1=$wpdb->get_var("SELECT user_login FROM `wp_users` where ID='$id[$pos]'");

    unset($num[$pos]);
    $pos=array_search(max($num),$num);

    $username2=$wpdb->get_var("SELECT user_login FROM `wp_users` where ID='$id[$pos]'");

    unset($num[$pos]);
    $pos=array_search(max($num),$num);
    $username3=$wpdb->get_var("SELECT user_login FROM `wp_users` where ID='$id[$pos]'");
    $username=("$username1,$username2,$username3");
    return $username;
}
function answer_before(){
    global $wpdb;
//    $user = $wpdb->get_results("SELECT ID FROM `$wpdb->users` order by `ID`");
//    $m=0;
//    foreach ($user as $a) {
//        $userlist[$m] = $a->ID;
//        $m++;
//    }
    $now=time();
    $time = strtotime('-2 day', $now);
    $beginTime = date('Y-m-d 00:00:00', $time);
//    echo $beginTime;
    $postlis = $wpdb->get_results("SELECT post_date,ID FROM `wp_posts` order by `ID`");
    $m=0;
    foreach ($postlis as $a) {
        $postlist[$m] = $a->post_date;
        $post_ID_list[$m]=$a->ID;
        $m++;
    }
    $c=count($postlist);
    $m=0;
    while($c>0){
        if(strtotime($postlist[$m])>strtotime($beginTime)){
            $a = $post_ID_list[$m];
            break;
        }
        $m++;
        $c--;
    }
    global $userlist;
    $c=count($userlist);
    $m=0;
    while($c>0){
        $num[$m]=0;//防止没有人在三天内创建的情况
     //   $num[$m]=$wpdb->get_var("SELECT COUNT(*) FROM `wp_posts` where post_author='$userlist[$m]' and post_type='dwqa-answer' and ID>'$a'");
        $id[$m]=$userlist[$m];
        $m++;
        $c--;
    }
//    print_r($num);
//    print_r($id);
    $pos=array_search(max($num),$num);
//    echo $id[$pos];
    $username1=$wpdb->get_var("SELECT user_login FROM `wp_users` where ID='$id[$pos]'");
    unset($num[$pos]);
    $pos=array_search(max($num),$num);

    $username2=$wpdb->get_var("SELECT user_login FROM `wp_users` where ID='$id[$pos]'");
    unset($num[$pos]);
    $pos=array_search(max($num),$num);
    $username3=$wpdb->get_var("SELECT user_login FROM `wp_users` where ID='$id[$pos]'");
    $username=("$username1,$username2,$username3");
    return $username;
}