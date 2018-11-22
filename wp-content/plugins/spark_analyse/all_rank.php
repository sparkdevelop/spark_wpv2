<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/9
 * Time: 16:24
 */
ini_set("memory_limit","-1");
set_time_limit(0);
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


//  统计全网活跃用户与近期活跃用户的函数
//function create(){
//    global $wpdb;
////    $user = $wpdb->get_results("SELECT ID FROM `$wpdb->users` order by `ID`");
////    $m=0;
////    foreach ($user as $a) {
////        $userlist[$m] = $a->ID;
////        $m++;
////    }
//////    print_r($userlist);
//    global  $userlist;
//    $c=count($userlist);
//    $m=0;
//    $num=array(0);
//    while($c>0){
//        $num[$m]=$wpdb->get_var("SELECT COUNT(*) FROM `wp_posts` where post_author='$userlist[$m]' and post_type='post' or post_type='revision'");
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
////    echo $id[$pos];
//    $username2=$wpdb->get_var("SELECT user_login FROM `wp_users` where ID='$id[$pos]'");
//
//    unset($num[$pos]);
//    $pos=array_search(max($num),$num);
////    echo $id[$pos];
//    $username3=$wpdb->get_var("SELECT user_login FROM `wp_users` where ID='$id[$pos]'");
//    $username=("$username1,$username2,$username3");
//    return $username;
//}
//function question(){
//    global $wpdb;
////    $user = $wpdb->get_results("SELECT ID FROM `$wpdb->users` order by `ID`");
////    $m=0;
////    foreach ($user as $a) {
////        $userlist[$m] = $a->ID;
////        $m++;
////    }
//   global $userlist;
//    $c=count($userlist);
//    $m=0;
//    while($c>0){
//        $num[$m]=$wpdb->get_var("SELECT COUNT(*) FROM `wp_posts` where post_author='$userlist[$m]' and post_type='dwqa-question'");
//        $id[$m]=$userlist[$m];
//        $m++;
//        $c--;
//    }
////    print_r($num);
////    print_r($id);
//    $pos=array_search(max($num),$num);
////    echo $id[$pos];
//    $username1=$wpdb->get_var("SELECT user_login FROM `wp_users` where ID='$id[$pos]'");
//
//    unset($num[$pos]);
//    $pos=array_search(max($num),$num);
//
//    $username2=$wpdb->get_var("SELECT user_login FROM `wp_users` where ID='$id[$pos]'");
//
//    unset($num[$pos]);
//    $pos=array_search(max($num),$num);
//    $username3=$wpdb->get_var("SELECT user_login FROM `wp_users` where ID='$id[$pos]'");
//    $username=("$username1,$username2,$username3");
//    return $username;
//}
//function answer(){
//    global $wpdb;
////    $user = $wpdb->get_results("SELECT ID FROM `$wpdb->users` order by `ID`");
////    $m=0;
////    foreach ($user as $a) {
////        $userlist[$m] = $a->ID;
////        $m++;
////    }
//    global $userlist;
//    $c=count($userlist);
//    $m=0;
//    while($c>0){
//        $num[$m]=$wpdb->get_var("SELECT COUNT(*) FROM `wp_posts` where post_author='$userlist[$m]' and post_type='dwqa-answer'");
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
//    $username=("$username1,$username2,$username3");
//    return $username;
//}
//function active_before_3(){
//    global $wpdb;
//    $m=0;
//    global $userlist;
//    $c=count($userlist);
//    $now=time();
//    $time = strtotime('-2 day', $now);
//    $beginTime = date('Y-m-d 00:00:00', $time);
////    echo $beginTime;
//    $timelis = $wpdb->get_results("SELECT action_time,ID FROM `wp_user_history` order by `ID`");
//    $m=0;
//    foreach ($timelis as $a) {
//        $timelist[$m] = $a->action_time;
//        $time_ID_list[$m]=$a->ID;
//        $m++;
//    }
//    $c=count($timelis);
//    $m=0;
//    while($c>0){
//        if(strtotime($timelist[$m])>strtotime($beginTime)){
//            $a = $time_ID_list[$m];
//            break;
//         }
//        $m++;
//        $c--;
//    }
////    echo $a ;
//    $m=0;
//    $c=count($userlist);
//    while($c>0){
//        $num[$m]=$wpdb->get_var("SELECT COUNT(*) FROM `wp_user_history` where user_id='$userlist[$m]' and ID>'$a'");
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
//    $username=("$username1,$username2,$username3");
//    return $username;
//}
//function create_before(){
//    global $wpdb;
//    $m=0;
//    global $userlist;
//    $c=count($userlist);
//    $now=time();
//    $time = strtotime('-2 day', $now);
//    $beginTime = date('Y-m-d 00:00:00', $time);
////    echo $beginTime;
//    $postlis = $wpdb->get_results("SELECT post_date,ID FROM `wp_posts` order by `ID`");
//    $m=0;
//    foreach ($postlis as $a) {
//        $postlist[$m] = $a->post_date;
//        $post_ID_list[$m]=$a->ID;
//        $m++;
//    }
//    $c=count($postlist);
//    $m=0;
//    while($c>0){
//        if(strtotime($postlist[$m])>strtotime($beginTime)){
//            $a = $post_ID_list[$m];
//            break;
//        }
//        $m++;
//        $c--;
//    }
////    echo $a ;
//    $m=0;
//    $c=count($userlist);
//    while($c>0){
//        $num[$m]=0;//防止没有人在三天内创建的情况
////         @$num[$m] = $wpdb->get_var("SELECT COUNT(*) FROM `wp_posts` where post_author='$userlist[$m]' and ID>'$a' and post_type='post' or post_type='revision'");
//
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
//    $username=("$username1,$username2,$username3");
//    return $username;
//}
//function question_before(){
//    global $wpdb;
//    $now=time();
//    $time = strtotime('-2 day', $now);
//    $beginTime = date('Y-m-d 00:00:00', $time);
////    echo $beginTime;
//    $postlis = $wpdb->get_results("SELECT post_date,ID FROM `wp_posts` order by `ID`");
//    $m=0;
//    foreach ($postlis as $a) {
//        $postlist[$m] = $a->post_date;
//        $post_ID_list[$m]=$a->ID;
//        $m++;
//    }
//    $c=count($postlist);
//    $m=0;
//    while($c>0){
//        if(strtotime($postlist[$m])>strtotime($beginTime)){
//            $a = $post_ID_list[$m];
//            break;
//        }
//        $m++;
//        $c--;
//    }
//
//    global $userlist;
//    $c=count($userlist);
//    $m=0;
//    while($c>0){
//        $num[$m]=0;//防止没有人在三天内创建的情况
//     //   $num[$m]=$wpdb->get_var("SELECT COUNT(*) FROM `wp_posts` where post_author='$userlist[$m]' and post_type='dwqa-question' and ID>'$a'");
//        $id[$m]=$userlist[$m];
//        $m++;
//        $c--;
//    }
////    print_r($num);
////    print_r($id);
//    $pos=array_search(max($num),$num);
////    echo $id[$pos];
//    $username1=$wpdb->get_var("SELECT user_login FROM `wp_users` where ID='$id[$pos]'");
//
//    unset($num[$pos]);
//    $pos=array_search(max($num),$num);
//
//    $username2=$wpdb->get_var("SELECT user_login FROM `wp_users` where ID='$id[$pos]'");
//
//    unset($num[$pos]);
//    $pos=array_search(max($num),$num);
//    $username3=$wpdb->get_var("SELECT user_login FROM `wp_users` where ID='$id[$pos]'");
//    $username=("$username1,$username2,$username3");
//    return $username;
//}
//function answer_before(){
//    global $wpdb;
////    $user = $wpdb->get_results("SELECT ID FROM `$wpdb->users` order by `ID`");
////    $m=0;
////    foreach ($user as $a) {
////        $userlist[$m] = $a->ID;
////        $m++;
////    }
//    $now=time();
//    $time = strtotime('-2 day', $now);
//    $beginTime = date('Y-m-d 00:00:00', $time);
////    echo $beginTime;
//    $postlis = $wpdb->get_results("SELECT post_date,ID FROM `wp_posts` order by `ID`");
//    $m=0;
//    foreach ($postlis as $a) {
//        $postlist[$m] = $a->post_date;
//        $post_ID_list[$m]=$a->ID;
//        $m++;
//    }
//    $c=count($postlist);
//    $m=0;
//    while($c>0){
//        if(strtotime($postlist[$m])>strtotime($beginTime)){
//            $a = $post_ID_list[$m];
//            break;
//        }
//        $m++;
//        $c--;
//    }
//    global $userlist;
//    $c=count($userlist);
//    $m=0;
//    while($c>0){
//        $num[$m]=0;//防止没有人在三天内创建的情况
//     //   $num[$m]=$wpdb->get_var("SELECT COUNT(*) FROM `wp_posts` where post_author='$userlist[$m]' and post_type='dwqa-answer' and ID>'$a'");
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
//    $username=("$username1,$username2,$username3");
//    return $username;
//}
//function stay_page(){
//    global $wpdb;
////    $c = get_option('spark_search_user_copy_right');
//    $n = 0;
//    $p = 0;
//    //需要更改匹配线上服务器
//    $viewart = $wpdb->get_results("SELECT action_post_id FROM `wp_user_history` where  `action_post_type`!='page' and `action_post_id`!='0'");
//    foreach ($viewart as $a) {
//        $viewart[$n] = $a->action_post_id;
//        $n++;
//    }
//    $infor = $wpdb->get_results("SELECT action_post_id,ID,action_time FROM `wp_user_history` order by ID");
//
//    foreach ($infor as $a) {
//        $IDinfor[$p] = $a->ID;
//        $timeinfor[$p] = $a->action_time;
//        $viewall[$p] = $a->action_post_id;
//        $p++;
//    }
//    $m = 0;
//    $result = array();
//    $c = count($viewall);
//    while ($c > 0) {
//        if (in_array($viewall[$m], $viewart)) {
//            $stay = strtotime($timeinfor[$m + 1]) - strtotime($timeinfor[$m]);
//            if ($stay > 3600)
//                $stay = 0;
//            $result[$viewall[$m]] += $stay;
//        }
//        $m++;
//        $c--;
//    }
//    arsort($result);
//    $num_val = array_values($result);
//    $num_key = array_keys($result);
//    $idcount1 = $num_val[0];
//    $idcount2 = $num_val[1];
//    $idcount3 = $num_val[2];
//    $idcount4 = $num_val[3];
//    $idcount5 = $num_val[4];
//    $idcount6 = $num_val[5];
//    $idcount7 = $num_val[6];
//    $id1 = $num_key[0];
//    $id2 = $num_key[1];
//    $id3 = $num_key[2];
//    $id4 = $num_key[3];
//    $id5 = $num_key[4];
//    $id6 = $num_key[5];
//    $id7 = $num_key[6];
////        $idname1 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id1'");
////        $idname2 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id2'");
////        $idname3 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id3'");
////        $idname4 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id4'");
////        $idname5 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id5'");
////        $idname6 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id6'");
////        $idname7 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id7'");
//
//    $resulttime = "$idcount1 $idcount2 $idcount3 $idcount4 $idcount5 $idcount6 $idcount7 $id1 $id2 $id3 $id4 $id5 $id6 $id7";
//
//    return $resulttime;
//}
function lowtime()
{
    global $wpdb;
    $n = 0;
    $now = time();
    $historytime = "2017-09-04";
    $historytime = strtotime($historytime);
    $betweentime = ($now - $historytime) / 86400;
    $historytime = "2017-09-04";
    $t = 0;
    $n = 0;
    while ($t < $betweentime) {
        $starttime = $historytime;
        $historytime = date("Y-m-d", strtotime("+7days", strtotime($historytime)));
        $c = 0;
        $m = 0;
        $start = $starttime;
        while ($c < 7) {
            $end = date("Y-m-d ", strtotime("+1days", strtotime($start)));
            $start1 = $start . "%";
            $end1 = $end . "%";
            $view[$m] = $wpdb->get_var("SELECT COUNT(*) FROM `wp_user_history` where  `action_time` > '$start1' and `action_time` < '$end1' ");
            $time1[$m] = $start;
            $m++;
            $c++;
            $start = $end;
        }
        $pos = array_search(min($view), $view);
        $time2[$n] = $time1[$pos];
        $t += 7;
        $n++;
    }

    $c=count($time2);
    $m=0;        $p=0;
    while($c>0){
        $start=$time2[$m];
        $end=date("Y-m-d",strtotime("+1days",strtotime($start)));
        $start1=$start." %";$end1=$end." %";
        $view = $wpdb->get_results("SELECT user_id FROM `wp_user_history` where  `action_time` > '$start1' and `action_time` < '$end1' ");
        foreach ($view as $a) {
            $IDinfor[$p] = $a->user_id;
            $p++;
        }
        $c--;
        $m++;
    }
    $ID=$IDinfor;
    $IDinfor_cou=array_count_values($IDinfor);
    arsort($IDinfor_cou);
//    print_r($IDinfor_cou);
    $c=count($IDinfor_cou);
    $IDinfor_val=array_values($IDinfor_cou);
    $IDinfor_key=array_keys($IDinfor_cou);
    if($c%2==0){
        $center=$IDinfor_val[$c / 2];
    }
    else {
        $center=$IDinfor_val[($c+1)/2];
    }
    $m=0;
//    echo $center;
//    print_r($IDinfor_val);
    while($c>0){
        if($IDinfor_val[$m]<$center)
            $unset[$m]=$IDinfor_key[$m];
        $m++;
        $c--;
    }
    array_merge($unset);
//    print_r($ID);
    $c=count($ID);
    $m=0;
    while($c>0){
        if(in_array($ID[$m],$unset))
            unset($ID[$m]);
        $m++;
        $c--;
    }
    array_merge($IDinfor);
     $c=count($ID);
    $m=0;
    while($c>0){
        $name[$m]=$wpdb->get_var("SELECT user_login FROM `wp_users` where  ID=$ID[$m] ");
        $m++;
        $c--;
    }
    echo implode(' ',$name);
}
function findmax_3_key($a){
    $c=3;
    $m=0;
    while($c>0){
        $pos[$m]=array_search(max($a),$a);
        unset( $a[$pos[$m]]);
        $m++;
        $c--;
    }
    return $pos;
}
function findmax_3_val($a){
    $c=3;
    $m=0;
    while($c>0){
        $val[$m]=max($a);
        $pos[$m]=array_search(max($a),$a);
        unset( $a[$pos[$m]]);
        $m++;
        $c--;
    }
    return $val;
}
function getname($a,$b){
    $c=3;
    $m=0;
    global $wpdb;
    while($c>0){
        $d=$b[$a[$m]];
        $name[$m]=$wpdb->get_var("SELECT post_title FROM `wp_posts` where  ID=$d");
        $m++;
        $c--;
    }
    return $name;
}
function getper($a,$b){
    $c=3;
    $m=0;
    global $wpdb;
    while($c>0){
        $view[$m]=round( $a[$m]/$b * 100 , 2);
        $m++;
        $c--;
    }
    return $view;
}
function process(){
    global $wpdb;
    $n = 0;
    $now = time();
    $historytime = date("Y-m-d", strtotime("-7 days"));
    $start=$historytime." %";
    $unit1=array(4591,4595,6959,962,960,965,967);
    $unit2=array(11002,983,985,989,991,987);
    $unit3=array(1231,993,1204,1208,1210,1212,1214,1216,11047,11101,11104,11088,11083,11066);
    $unit4=array(1235,1237,1239,4854,13333,13406,13414,13455,11249,11241);
    $unit5=array(13534,13689,13715,13567,13684,13522,13580,13576,13650,13543,4622,1241);
    $view = $wpdb->get_var("SELECT count(ID) FROM `wp_user_history`  where  `action_post_type`!='page' and `action_post_id`!='0'and `action_post_id`!='235' and  `action_time`>'$start'");
    $c=7;
    $m=0;
    $view1=array();
    while($c>0){
        $view1[$m]= $wpdb->get_var("SELECT count(ID) FROM `wp_user_history`  where   `action_post_id`='$unit1[$m]' and  `action_time`>'$start'");
        $m++;
        $c--;
    }
    $c=6;
    $m=0;
    $view2=array();
    while($c>0){
        $view2[$m]= $wpdb->get_var("SELECT count(ID) FROM `wp_user_history`  where   `action_post_id`='$unit2[$m]' and  `action_time`>'$start'");
        $m++;
        $c--;
    }
    $c=14;
    $m=0;
    $view3=array();
    while($c>0){
        $view3[$m]= $wpdb->get_var("SELECT count(ID) FROM `wp_user_history`  where   `action_post_id`='$unit3[$m]' and  `action_time`>'$start'");
        $m++;
        $c--;
    }
    $c=10;
    $m=0;
    $view4=array();
    while($c>0){
        $view4[$m]= $wpdb->get_var("SELECT count(ID) FROM `wp_user_history`  where   `action_post_id`='$unit4[$m]' and  `action_time`>'$start'");
        $m++;
        $c--;
    }
    $c=12;
    $m=0;
    $view5=array();
    while($c>0){
        $view5[$m]= $wpdb->get_var("SELECT count(ID) FROM `wp_user_history`  where   `action_post_id`='$unit5[$m]'and  `action_time`>'$start' ");
        $m++;
        $c--;
    }
    $pos1=findmax_3_key($view1);$pos2=findmax_3_key($view2);$pos3=findmax_3_key($view3);$pos4=findmax_3_key($view4);$pos5=findmax_3_key($view5);
    $name1=getname($pos1,$unit1);$name2=getname($pos2,$unit2);$name3=getname($pos3,$unit3);$name4=getname($pos4,$unit4);$name5=getname($pos5,$unit5);
    $val1=findmax_3_val($view1);$val2=findmax_3_val($view2);$val3=findmax_3_val($view3);$val4=findmax_3_val($view4);$val5=findmax_3_val($view5);
    $val1_=array_sum($val1);$val2_=array_sum($val2);$val3_=array_sum($val3);$val4_=array_sum($val4);$val5_=array_sum($val5);
    $view1_=array_sum($view1);$view2_=array_sum($view2);$view3_=array_sum($view3);$view4_=array_sum($view4);$view5_=array_sum($view5);
    $val1_oth=$view1_-$val1_;$val2_oth=$view2_-$val2_;$val3_oth=$view3_-$val3_;$val4_oth=$view4_-$val4_;$val5_oth=$view5_-$val5_;
    $val1=getper($val1,$view);$val2=getper($val2,$view);$val3=getper($val3,$view);$val4=getper($val4,$view);$val5=getper($val5,$view);
    $val1_oth=round( $val1_oth/$view * 100 , 2); $val2_oth=round( $val2_oth/$view * 100 , 2);
    $val3_oth=round( $val3_oth/$view * 100 , 2); $val4_oth=round( $val4_oth/$view * 100 , 2); $val5_oth=round( $val5_oth/$view * 100 , 2);
//    $view1per=round( $view1_/$view * 100 , 2); $view2per=round( $view2_/$view * 100 , 2);
//    $view3per=round( $view3_/$view * 100 , 2); $view4per=round( $view4_/$view * 100 , 2); $view5per=round( $view5_/$view * 100 , 2);
      $viewper=array($name1[0],$name1[1],$name1[2],$val1[0],$val1[1],$val1[2],$val1_oth,
                           $name2[0],$name2[1],$name2[2],$val2[0],$val2[1],$val2[2],$val2_oth,
                           $name3[0],$name3[1],$name3[2],$val3[0],$val3[1],$val3[2],$val3_oth,
                           $name4[0],$name4[1],$name4[2],$val4[0],$val4[1],$val4[2],$val4_oth,
                           $name5[0],$name5[1],$name5[2],$val5[0],$val5[1],$val5[2],$val5_oth,
                           );
//    print_r($viewper);
    return $viewper;
}
function user_lesson(){
    //先搁置一会
    global $wpdb;
    $n = 0;
    $now = time();
    $historytime = date("Y-m-d", strtotime("-7 days"));
    $start=$historytime." %";
    $p=0;
    $user = $wpdb->get_results("SELECT user_id FROM `wp_user_history`  where  `action_post_type`!='page' and `action_post_id`!='0'and `action_post_id`!='235' and  `action_time`>'$start'");
    foreach ($user as $a) {
        $IDinfor[$p] = $a->user_id;
        $p++;
    }
    $unit1=array(4591,4595,6959,962,960,965,967);
    $unit2=array(11002,983,985,989,991,987);
    $unit3=array(1231,993,1204,1208,1210,1212,1214,1216,11047,11101,11104,11088,11083,11066);
    $unit4=array(1235,1237,1239,4854,13333,13406,13414,13455,11249,11241);
    $unit5=array(13534,13689,13715,13567,13684,13522,13580,13576,13650,13543,4622,1241);
}
function team(){
    //完成度最高（文字多少）,最低
    //进度平均最高，最低    //模板格式不对
    //团队内部不均匀（进度，访问量）
    global $wpdb;
    $p=0;
    $project = $wpdb->get_results("SELECT apply_content,team_id FROM `wp_gp_task_member`  where  `task_id`=35 and `ID`>69");
    foreach ($project as $a) {
        $project[$p] = $a->apply_content;
        $team[$p]=$a->team_id;
        $p++;
    }
    $project=array_unique($project);
    $team=array_unique($team);
    $project=array_merge($project);
    $team=array_merge($team);
    $c=count($project);
    $m=0;
    while($c>0){
        $id[$m]=strstr($project[$m],'?p');
        $id[$m]=substr($id[$m],3);
        $m++;
        $c--;
    }
//    print_r($id);
    $m=0;
    $c=count($id);
    while($c>0){
        $content[$m] = $wpdb->get_var("SELECT post_content FROM `wp_posts`  where `ID`=$id[$m]");
        $m++;
        $c--;
    }
    $c=count($content);
    $m=0;
    while($c>0){
        $content[$m]=strip_tags($content[$m]);
        $len[$m]=strlen($content[$m]);
        $m++;
        $c--;
    }
    $pos1=array_search(max($len),$len);
    $pos2=array_search(min($len),$len);
    $project[$pos1]=strstr($project[$pos1], ',', TRUE);
    $project[$pos2]=strstr($project[$pos2], ',', TRUE);
    $team=array( $team[$pos1],$project[$pos1],$team[$pos2],$project[$pos2]);
    return $team;
}
function team_question(){
    global $wpdb;
    $p=0;
    $idmax=$wpdb->get_var("select max(team_id) from wp_gp_task_member where task_id=35");
    $m=5;
    while (($idmax-$m)>=0){
        $n=0;
        $project = $wpdb->get_results("SELECT user_id FROM `wp_gp_task_member`  where  `task_id`=35  and `team_id`='$m'");
        foreach ($project as $a) {
            $user[$m][$n] = $a->user_id;
            $n++;
        }
        $m++;
    }
    $m=5;
    while (($idmax-$m)>0) {
        $user1=array();
        $user1=$user[$m];
        $c=count($user1);
//        print_r($user1);
        $n=0;
        while($c>0) {
            $view[$m][$n] = $wpdb->get_var("SELECT count(ID) FROM `wp_user_history`  where user_id='$user1[$n]' and ID>250000");
            $c--;
            $n++;
        }
        $m++;
    }
//    print_r($view);
    $m=5;
    $question=array();
    $n=0;
    while(($idmax-$m)>0) {
        $view1=$view[$m];
        if(is_array($view1)) {
            $max = max($view1);
            $min = min($view1);
            $max2 = $max / 5;
            if ($max2 > $min) {
                $question[$n] = $m;
                $n++;
            }
        }
            $m++;

    }
    echo implode(' ',$question);
}
function team_question_sta(){
    global $wpdb;
    $p=0;
    $idmax=$wpdb->get_var("select max(team_id) from wp_gp_task_member where task_id=35");
    $m=5;
    while (($idmax-$m)>=0){
        $n=0;
        $project = $wpdb->get_results("SELECT user_id FROM `wp_gp_task_member`  where  `task_id`=35  and `team_id`='$m'");
        foreach ($project as $a) {
            $user[$m][$n] = $a->user_id;
            $n++;
        }
        $m++;
    }
    $m=5;
    while (($idmax-$m)>0) {
        $user1=array();
        $user1=$user[$m];
        $c=count($user1);
//        print_r($user1);
        $n=0;
        while($c>0) {
            $view[$m][$n] = $wpdb->get_var("SELECT count(ID) FROM `wp_user_history`  where user_id='$user1[$n]' and ID>250000");
            $c--;
            $n++;
        }
        $m++;
    }
//    print_r($view);
    $m=5;
    $question=array();
    $n=0;
    while(($idmax-$m)>0) {
        $view1=$view[$m];
        if(is_array($view1)) {
            $max = max($view1);
            $min = min($view1);
            $max2 = $max / 5;
            if ($max2 > $min) {
                $question[$n] = $m;
                $n++;
            }
        }
        $m++;
    }
    $m=5;
     $total=$idmax-$m;
     $pro_total=count($question);
    return $num=array($total,$pro_total);
}