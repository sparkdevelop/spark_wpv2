<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/10
 * Time: 15:23
 */

add_action('wp_ajax_view_action', 'view_ajax');
function view_ajax(){
    $time1 = isset($_POST['start2']) ? $_POST['start2'] : null;
    $id= isset($_POST['number']) ? $_POST['number'] : null;
    $rank= isset($_POST['rank']) ? $_POST['rank'] : 1;
    $time1 = date("Y-m-d", strtotime($time1));
    $time2 = date("Y-m-d", strtotime('+1 day', strtotime($time1)));
    $time3 = date("Y-m-d", strtotime('+2 day', strtotime($time1)));
    $time4 = date("Y-m-d", strtotime('+3 day', strtotime($time1)));
    $time5 = date("Y-m-d", strtotime('+4 day', strtotime($time1)));
    $time6 = date("Y-m-d", strtotime('+5 day', strtotime($time1)));
    $time7 = date("Y-m-d", strtotime('+6 day', strtotime($time1)));
    $timegeshi1 = (int)substr($time1, 0, 4) . substr($time1, 5, 2) . substr($time1, 8, 2);
    $timegeshi2 = (int)substr($time2, 0, 4) . substr($time2, 5, 2) . substr($time2, 8, 2);
    $timegeshi3 = (int)substr($time3, 0, 4) . substr($time3, 5, 2) . substr($time3, 8, 2);
    $timegeshi4 = (int)substr($time4, 0, 4) . substr($time4, 5, 2) . substr($time4, 8, 2);
    $timegeshi5 = (int)substr($time5, 0, 4) . substr($time5, 5, 2) . substr($time5, 8, 2);
    $timegeshi6 = (int)substr($time6, 0, 4) . substr($time6, 5, 2) . substr($time6, 8, 2);
    $timegeshi7 = (int)substr($time7, 0, 4) . substr($time7, 5, 2) . substr($time7, 8, 2);

    if($id!=0) {
        $id = explode(",", $id);
        $flag=0;
    }
    else{ $flag=1;}

    if($flag==0) {
        global $wpdb;
//    $c = get_option('spark_search_user_copy_right');
        $c = 5;
        $m = 0;
        while ($c > 0) {
            //需要更改匹配线上服务器
            $time = $wpdb->get_results("SELECT action_post_id ,action_time FROM `wp_user_history` WHERE `user_id` ='$id[$m]' and `action_post_type`!='page' and `action_post_id`!='0'");
            $n = 0;
            foreach ($time as $a) {
                $idlist[$m][$n] = $a->action_post_id;
                $historytime[$m][$n] = $a->action_time;
                $n++;
            }
            $m++;
            $c--;
        }
        $a = 5;
        $m = 0;
        $num = count($historytime,1);
        while ($a > 0) {
            $c = $num;
            $nn = 0;
            while ($c > 0) {
                $timegeshi_action[$m][$nn] = (int)substr($historytime[$m][$nn], 0, 4) . substr($historytime[$m][$nn], 5, 2) . substr($historytime[$m][$nn], 8, 2);
                $nn++;
                $c--;
            }
            $m++;
            $a--;
        }
        $a = 5;$m = 0;$idnum1 = 0;$idnum2 = 0;$idnum3 = 0;$idnum4 = 0;$idnum5 = 0;$idnum6 = 0;$idnum7 = 0;
        $idview1 = array();$idview2 = array();$idview3 = array();$idview4 = array();$idview5 = array();$idview6 = array();$idview7 = array();
        while ($a > 0) {
            $c = $num;
            $n = 0;
            while ($c > 0) {
                if ($timegeshi1 == $timegeshi_action[$m][$n]) {
                    $idview1[$idnum1] = $idlist[$m][$n];
                    $idnum1++;
                } else if ($timegeshi2 == $timegeshi_action[$m][$n]) {
                    $idview2[$idnum2] = $idlist[$m][$n];
                    $idnum2++;
                } else if ($timegeshi3 == $timegeshi_action[$m][$n]) {
                    $idview3[$idnum3] = $idlist[$m][$n];
                    $idnum3++;
                } else if ($timegeshi4 == $timegeshi_action[$m][$n]) {
                    $idview4[$idnum4] = $idlist[$m][$n];
                    $idnum4++;
                } else if ($timegeshi5 == $timegeshi_action[$m][$n]) {
                    $idview5[$idnum5] = $idlist[$m][$n];
                    $idnum5++;
                } else if ($timegeshi6 == $timegeshi_action[$m][$n]) {
                    $idview6[$idnum6] = $idlist[$m][$n];
                    $idnum6++;
                } else if ($timegeshi7 == $timegeshi_action[$m][$n]) {
                    $idview7[$idnum7] = $idlist[$m][$n];
                    $idnum7++;
                }
                $n++;
                $c--;
            }
            $m++;
            $a--;
        }
        $idview1=array_count_values ($idview1);$idview2=array_count_values ($idview2);$idview3=array_count_values ($idview3);$idview4=array_count_values ($idview4);
        $idview5=array_count_values ($idview5);$idview6=array_count_values ($idview6);$idview7=array_count_values ($idview7);
        arsort($idview1);arsort($idview2);arsort($idview3);arsort($idview4);arsort($idview5);arsort($idview6);arsort($idview7);
        $idview_val1=array_values($idview1);$idview_val2=array_values($idview2);$idview_val3=array_values($idview3);$idview_val4=array_values($idview4);
        $idview_val5=array_values($idview5);$idview_val6=array_values($idview6);$idview_val7=array_values($idview7);
        $idview_key1=array_keys($idview1);$idview_key2=array_keys($idview2);$idview_key3=array_keys($idview3);$idview_key4=array_keys($idview4);
        $idview_key5=array_keys($idview5);$idview_key6=array_keys($idview6);$idview_key7=array_keys($idview7);
        if($rank==1) {
            $idmax1 = $idview_val1[0];
            $idmax2 = $idview_val2[0];
            $idmax3 = $idview_val3[0];
            $idmax4 = $idview_val4[0];
            $idmax5 = $idview_val5[0];
            $idmax6 = $idview_val6[0];
            $idmax7 = $idview_val7[0];
            $id1 = $idview_key1[0];
            $id2 = $idview_key2[0];
            $id3 = $idview_key3[0];
            $id4 = $idview_key4[0];
            $id5 = $idview_key5[0];
            $id6 = $idview_key6[0];
            $id7 = $idview_key7[0];
            //需要更改匹配线上服务器
            $idname1 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id1'");
            $idname2 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id2'");
            $idname3 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id3'");
            $idname4 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id4'");
            $idname5 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id5'");
            $idname6 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id6'");
            $idname7 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id7'");
            $resulttime = "$idmax1 $idmax2 $idmax3 $idmax4 $idmax5 $idmax6 $idmax7 $idname1 $idname2 $idname3 $idname4 $idname5 $idname6 $idname7";
        }
        else if($rank==2){
            $idmax1 = $idview_val1[1];
            $idmax2 = $idview_val2[1];
            $idmax3 = $idview_val3[1];
            $idmax4 = $idview_val4[1];
            $idmax5 = $idview_val5[1];
            $idmax6 = $idview_val6[1];
            $idmax7 = $idview_val7[1];
            $id1 = $idview_key1[1];
            $id2 = $idview_key2[1];
            $id3 = $idview_key3[1];
            $id4 = $idview_key4[1];
            $id5 = $idview_key5[1];
            $id6 = $idview_key6[1];
            $id7 = $idview_key7[1];
            //需要更改匹配线上服务器
            $idname1 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id1'");
            $idname2 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id2'");
            $idname3 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id3'");
            $idname4 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id4'");
            $idname5 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id5'");
            $idname6 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id6'");
            $idname7 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id7'");
            $resulttime = "$idmax1 $idmax2 $idmax3 $idmax4 $idmax5 $idmax6 $idmax7 $idname1 $idname2 $idname3 $idname4 $idname5 $idname6 $idname7";
        }
        else if($rank==3){
            $idmax1 = $idview_val1[2];
            $idmax2 = $idview_val2[2];
            $idmax3 = $idview_val3[2];
            $idmax4 = $idview_val4[2];
            $idmax5 = $idview_val5[2];
            $idmax6 = $idview_val6[2];
            $idmax7 = $idview_val7[2];
            $id1 = $idview_key1[2];
            $id2 = $idview_key2[2];
            $id3 = $idview_key3[2];
            $id4 = $idview_key4[2];
            $id5 = $idview_key5[2];
            $id6 = $idview_key6[2];
            $id7 = $idview_key7[2];
            //需要更改匹配线上服务器
            $idname1 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id1'");
            $idname2 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id2'");
            $idname3 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id3'");
            $idname4 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id4'");
            $idname5 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id5'");
            $idname6 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id6'");
            $idname7 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id7'");
            $resulttime = "$idmax1 $idmax2 $idmax3 $idmax4 $idmax5 $idmax6 $idmax7 $idname1 $idname2 $idname3 $idname4 $idname5 $idname6 $idname7";
        }
        else if($rank==4){
            $idmax1 = $idview_val1[3];
            $idmax2 = $idview_val2[3];
            $idmax3 = $idview_val3[3];
            $idmax4 = $idview_val4[3];
            $idmax5 = $idview_val5[3];
            $idmax6 = $idview_val6[3];
            $idmax7 = $idview_val7[3];
            $id1 = $idview_key1[3];
            $id2 = $idview_key2[3];
            $id3 = $idview_key3[3];
            $id4 = $idview_key4[3];
            $id5 = $idview_key5[3];
            $id6 = $idview_key6[3];
            $id7 = $idview_key7[3];
            //需要更改匹配线上服务器
            $idname1 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id1'");
            $idname2 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id2'");
            $idname3 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id3'");
            $idname4 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id4'");
            $idname5 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id5'");
            $idname6 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id6'");
            $idname7 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id7'");
            $resulttime = "$idmax1 $idmax2 $idmax3 $idmax4 $idmax5 $idmax6 $idmax7 $idname1 $idname2 $idname3 $idname4 $idname5 $idname6 $idname7";
        }
        echo $resulttime;
    }
    else {
        global $wpdb;
        //需要更改匹配线上服务器
            $time = $wpdb->get_results("SELECT action_post_id ,action_time FROM `wp_user_history` where `action_post_type`!='page' and `action_post_id`!='0' ");
            $n = 0;
            foreach ($time as $time_a) {
                $idlist[$n] = $time_a->action_post_id;
                $historytime[$n] = $time_a->action_time;
                $n++;
            }
        $num = count($historytime);
            $c = $num;
            $nn = 0;

            while ($c > 0) {
                $timegeshi_action[$nn] = (int)substr($historytime[$nn], 0, 4) . substr($historytime[$nn], 5, 2) . substr($historytime[$nn], 8, 2);
                $nn++;
                $c--;
            }
        $idnum1 = 0;$idnum2 = 0;$idnum3 = 0;$idnum4 = 0;$idnum5 = 0;$idnum6 = 0;$idnum7 = 0;
        $n=0;$c=$num;
        $idview1 = array();$idview2 = array();$idview3 = array();$idview4 = array();$idview5 = array();$idview6 = array();$idview7 = array();
            while ($c > 0) {
                if ($timegeshi1 == $timegeshi_action[$n]) {
                    $idview1[$idnum1] = $idlist[$n];
                    $idnum1++;
                } else if ($timegeshi2 == $timegeshi_action[$n]) {
                    $idview2[$idnum2] = $idlist[$n];
                    $idnum2++;
                } else if ($timegeshi3 == $timegeshi_action[$n]) {
                    $idview3[$idnum3] = $idlist[$n];
                    $idnum3++;
                } else if ($timegeshi4 == $timegeshi_action[$n]) {
                    $idview4[$idnum4] = $idlist[$n];
                    $idnum4++;
                } else if ($timegeshi5 == $timegeshi_action[$n]) {
                    $idview5[$idnum5] = $idlist[$n];
                    $idnum5++;
                } else if ($timegeshi6 == $timegeshi_action[$n]) {
                    $idview6[$idnum6] = $idlist[$n];
                    $idnum6++;
                } else if ($timegeshi7 == $timegeshi_action[$n]) {
                    $idview7[$idnum7] = $idlist[$n];
                    $idnum7++;
                }
                $n++;
                $c--;
            }
        $idview1=array_count_values ($idview1);$idview2=array_count_values ($idview2);$idview3=array_count_values ($idview3);$idview4=array_count_values ($idview4);
        $idview5=array_count_values ($idview5);$idview6=array_count_values ($idview6);$idview7=array_count_values ($idview7);
        arsort($idview1);arsort($idview2);arsort($idview3);arsort($idview4);arsort($idview5);arsort($idview6);arsort($idview7);
        $idview_val1=array_values($idview1);$idview_val2=array_values($idview2);$idview_val3=array_values($idview3);$idview_val4=array_values($idview4);
        $idview_val5=array_values($idview5);$idview_val6=array_values($idview6);$idview_val7=array_values($idview7);
        $idview_key1=array_keys($idview1);$idview_key2=array_keys($idview2);$idview_key3=array_keys($idview3);$idview_key4=array_keys($idview4);
        $idview_key5=array_keys($idview5);$idview_key6=array_keys($idview6);$idview_key7=array_keys($idview7);
        if($rank==1) {
            $idmax1 = $idview_val1[0];
            $idmax2 = $idview_val2[0];
            $idmax3 = $idview_val3[0];
            $idmax4 = $idview_val4[0];
            $idmax5 = $idview_val5[0];
            $idmax6 = $idview_val6[0];
            $idmax7 = $idview_val7[0];
            $id1 = $idview_key1[0];
            $id2 = $idview_key2[0];
            $id3 = $idview_key3[0];
            $id4 = $idview_key4[0];
            $id5 = $idview_key5[0];
            $id6 = $idview_key6[0];
            $id7 = $idview_key7[0];
            //需要更改匹配线上服务器
            $idname1 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id1'");
            $idname2 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id2'");
            $idname3 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id3'");
            $idname4 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id4'");
            $idname5 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id5'");
            $idname6 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id6'");
            $idname7 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id7'");
            $resulttime = "$idmax1 $idmax2 $idmax3 $idmax4 $idmax5 $idmax6 $idmax7 $idname1 $idname2 $idname3 $idname4 $idname5 $idname6 $idname7";
        }
        else if($rank==2){
            $idmax1 = $idview_val1[1];
            $idmax2 = $idview_val2[1];
            $idmax3 = $idview_val3[1];
            $idmax4 = $idview_val4[1];
            $idmax5 = $idview_val5[1];
            $idmax6 = $idview_val6[1];
            $idmax7 = $idview_val7[1];
            $id1 = $idview_key1[1];
            $id2 = $idview_key2[1];
            $id3 = $idview_key3[1];
            $id4 = $idview_key4[1];
            $id5 = $idview_key5[1];
            $id6 = $idview_key6[1];
            $id7 = $idview_key7[1];
            //需要更改匹配线上服务器
            $idname1 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id1'");
            $idname2 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id2'");
            $idname3 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id3'");
            $idname4 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id4'");
            $idname5 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id5'");
            $idname6 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id6'");
            $idname7 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id7'");
            $resulttime = "$idmax1 $idmax2 $idmax3 $idmax4 $idmax5 $idmax6 $idmax7 $idname1 $idname2 $idname3 $idname4 $idname5 $idname6 $idname7";
        }
        else if($rank==3){
            $idmax1 = $idview_val1[2];
            $idmax2 = $idview_val2[2];
            $idmax3 = $idview_val3[2];
            $idmax4 = $idview_val4[2];
            $idmax5 = $idview_val5[2];
            $idmax6 = $idview_val6[2];
            $idmax7 = $idview_val7[2];
            $id1 = $idview_key1[2];
            $id2 = $idview_key2[2];
            $id3 = $idview_key3[2];
            $id4 = $idview_key4[2];
            $id5 = $idview_key5[2];
            $id6 = $idview_key6[2];
            $id7 = $idview_key7[2];
            //需要更改匹配线上服务器
            $idname1 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id1'");
            $idname2 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id2'");
            $idname3 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id3'");
            $idname4 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id4'");
            $idname5 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id5'");
            $idname6 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id6'");
            $idname7 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id7'");
            $resulttime = "$idmax1 $idmax2 $idmax3 $idmax4 $idmax5 $idmax6 $idmax7 $idname1 $idname2 $idname3 $idname4 $idname5 $idname6 $idname7";
        }
        else if($rank==4){
            $idmax1 = $idview_val1[3];
            $idmax2 = $idview_val2[3];
            $idmax3 = $idview_val3[3];
            $idmax4 = $idview_val4[3];
            $idmax5 = $idview_val5[3];
            $idmax6 = $idview_val6[3];
            $idmax7 = $idview_val7[3];
            $id1 = $idview_key1[3];
            $id2 = $idview_key2[3];
            $id3 = $idview_key3[3];
            $id4 = $idview_key4[3];
            $id5 = $idview_key5[3];
            $id6 = $idview_key6[3];
            $id7 = $idview_key7[3];
            //需要更改匹配线上服务器
            $idname1 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id1'");
            $idname2 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id2'");
            $idname3 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id3'");
            $idname4 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id4'");
            $idname5 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id5'");
            $idname6 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id6'");
            $idname7 = $wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id7'");
            $resulttime = "$idmax1 $idmax2 $idmax3 $idmax4 $idmax5 $idmax6 $idmax7 $idname1 $idname2 $idname3 $idname4 $idname5 $idname6 $idname7";
        }

        echo $resulttime;

    }
    die();

}
add_action('wp_ajax_team_action', 'team_ajax');
function team_ajax(){
    $team = isset($_POST['team_number']) ? $_POST['team_number'] : null;
    global $wpdb;
    $team1=$team;
        $n=0;
        $project = $wpdb->get_results("SELECT user_id FROM `wp_gp_task_member`  where  `task_id`=35  and `team_id`='$team1'");
        foreach ($project as $a) {
            $user[$n] = $a->user_id;
            $n++;
        }

        $c=count($user);
        $n=0;
        while($c>0) {
            $view[$n] = $wpdb->get_var("SELECT count(ID) FROM `wp_user_history`  where user_id='$user[$n]' and ID>250000");
            $c--;
            $n++;
        }
        $n=0;
        $c=count($user);
        while($c>0) {
        $name[$n] = $wpdb->get_var("SELECT user_login FROM `wp_users`  where ID='$user[$n]'");
        $c--;
        $n++;
    }
       $view=implode(" ",$view);
       $name=implode(" ",$name);
    $result="$view $name";
    echo $result;
    die();
}


function spark_settings_submenu_page3(){
//
$viewper=process();
$team=team();

?>
    <!DOCTYPE html>
    <html >
   <head>
       <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>用户统计</title>
       <script>
           $(function () {
               var text = "<?php lowtime()?>";
               var data = text.split(" ")
                   .reduce(function (arr, word) {
                       var obj = arr.find(function (obj) {
                           return obj.name === word;
                       });
                       if (obj) {
                           obj.weight += 1;
                       } else {
                           obj = {
                               name: word,
                               weight: 1
                           };
                           arr.push(obj);
                       }
                       return arr;
                   }, []);
               var chart_low = new Highcharts.Chart('container_low', {
                   series: [{
                       type: 'wordcloud',
                       data: data
                   }],
                   title: {
                       text: '用户云图'
                   }
               });

               $('#container_process').highcharts({
                   chart: {
                       type: 'bar'
                   },
                   title: {
                       text: '近七天学习进度分布'
                   },
                   xAxis: {
                       categories: ['unit1', 'unit2', 'unit3', 'unit4', 'unit5']
                   },
                   yAxis: {
                       min: 0,
                       title: {
                           text: '浏览量占比'
                       }
                   },
                   legend: {
                       reversed: true
                   },
                   plotOptions: {
                       series: {
                           stacking: 'normal'
                       }
                   },
                   series: [{
                       name: '<?php echo $viewper[0]?>',
                       data: [<?php echo $viewper[3]?>]
                   },  {
                       name: '<?php echo $viewper[1]?>',
                       data: [<?php echo $viewper[4]?>]
                   },{
                       name: '<?php echo $viewper[2]?>',
                       data: [<?php echo $viewper[5]?>]
                   },{
                       name: '其他',
                       data: [<?php echo $viewper[6]?>]
                   },{
                       name: '<?php echo $viewper[7]?>',
                       data: [0,<?php echo $viewper[10]?>]
                   },  {
                       name: '<?php echo $viewper[8]?>',
                       data: [0,<?php echo $viewper[11]?>]
                   },{
                       name: '<?php echo $viewper[9]?>',
                       data: [0,<?php echo $viewper[12]?>]
                   },{
                       name: '其他',
                       data: [0,<?php echo $viewper[13]?>]
                   },
                       {
                           name: '<?php echo $viewper[14]?>',
                           data: [0,0,<?php echo $viewper[17]?>]
                       },  {
                           name: '<?php echo $viewper[15]?>',
                           data: [0,0,<?php echo $viewper[18]?>]
                       },{
                           name: '<?php echo $viewper[16]?>',
                           data: [0,0,<?php echo $viewper[19]?>]
                       },{
                           name: '其他',
                           data: [0,0,<?php echo $viewper[20]?>]
                       },
                       {
                           name: '<?php echo $viewper[21]?>',
                           data: [0,0,0,<?php echo $viewper[24]?>]
                       },  {
                           name: '<?php echo $viewper[22]?>',
                           data: [0,0,0,<?php echo $viewper[25]?>]
                       },{
                           name: '<?php echo $viewper[23]?>',
                           data: [0,0,0,<?php echo $viewper[26]?>]
                       },{
                           name: '其他',
                           data: [0,0,0,<?php echo $viewper[27]?>]
                       },
                       {
                           name: '<?php echo $viewper[28]?>',
                           data: [0,0,0,0,<?php echo $viewper[31]?>]
                       },  {
                           name: '<?php echo $viewper[29]?>',
                           data: [0,0,0,0,<?php echo $viewper[32]?>]
                       },{
                           name: '<?php echo $viewper[30]?>',
                           data: [0,0,0,0,<?php echo $viewper[33]?>]
                       },{
                           name: '其他',
                           data: [0,0,0,0,<?php echo $viewper[34]?>]
                       }]
               });
               var text_que = "<?php team_question()?>";
               var data_que = text_que.split(" ")
                   .reduce(function (arr, word) {
                       var obj_que = arr.find(function (obj) {
                           return obj.name === word;
                       });
                       if (obj_que) {
                           obj_que.weight += 1;
                       } else {
                           obj_que = {
                               name: word,
                               weight: 1
                           };
                           arr.push(obj_que);
                       }
                       return arr;
                   }, []);
               var chart_question = new Highcharts.Chart('container_question', {
                   series: [{
                       type: 'wordcloud',
                       data: data_que
                   }],
                   title: {
                       text: '小组云图'
                   }
               });
           })
       </script>

   </head>

   <body style=" background-color: #f1f2f7; ">

   <div class="container">
       <p style="font-size: 18px;    margin: 8px;">系统统计</p>
       <div class="row">
           <div class="col-md-6" style="background-color: white;width: 47%">
               <p style="margin-top: 20px; margin-left: 10px;">全网活跃统计(有待开发)</p>
               <table class="table ">
                   <tr>
                       <th>总计</th>
<!--                       <th>浏览</th>-->
                       <th>创建编辑</th>
                       <th>提问</th>
                       <th>回答</th>
                   </tr>
                   <tr>
                       <td>第一名</td>
<!--                       <td>--><?php //echo $vusername0?><!--</td>-->
<!--                       <td>--><?php //echo $cusername0?><!--</td>-->
<!--                       <td>--><?php //echo $qusername0?><!--</td>-->
<!--                       <td>--><?php //echo $ausername0?><!--</td>-->
                       <td>spark_admin</td>
                       <td>spark_admin</td>
                       <td>spark_admin</td>
                   </tr>
                   <tr>
                       <td>第二名</td>
<!--                       <td>--><?php //echo $vusername1?><!--</td>-->
<!--                       <td>--><?php //echo $cusername1?><!--</td>-->
<!--                       <td>--><?php //echo $qusername1?><!--</td>-->
<!--                       <td>--><?php //echo $ausername1?><!--</td>-->
                       <td>Test1</td>
                       <td>Test1</td>
                       <td>Test1</td>
                   </tr>
                   <tr>
                       <td>第三名</td>
<!--                       <td>--><?php //echo $vusername2?><!--</td>-->
<!--                       <td>--><?php //echo $cusername2?><!--</td>-->
<!--                       <td>--><?php //echo $qusername2?><!--</td>-->
<!--                       <td>--><?php //echo $ausername2?><!--</td>-->
                       <td>Cherie</td>
                       <td>Cherie</td>
                       <td>Cherie</td>
                   </tr>
               </table>
               </div>
           <div class="col-md-6" style="background-color: white;width: 47%">
               <p style="margin-top: 20px; margin-left: 10px;">近期三天活跃统计(有待开发)</p>
               <table class="table ">
                   <tr>
                       <th>总计</th>
                       <th>浏览</th>
                       <th>创建编辑</th>
                       <th>提问</th>
                       <th>回答</th>
                   </tr>
                   <tr>
                       <td>第一名</td>
<!--                       <td>--><?php //echo $vusername3?><!--</td>-->
<!--                       <td>--><?php //echo $cusername3?><!--</td>-->
<!--                       <td>--><?php //echo $qusername3?><!--</td>-->
<!--                       <td>--><?php //echo $ausername3?><!--</td>-->
                       <td>zyl</td>
                       <td>zyl</td>
                       <td>zyl</td>
                       <td>zyl</td>
                   </tr>
                   <tr>
                       <td>第二名</td>
<!--                       <td>--><?php //echo $vusername4?><!--</td>-->
<!--                       <td>--><?php //echo $cusername4?><!--</td>-->
<!--                       <td>--><?php //echo $qusername4?><!--</td>-->
<!--                       <td>--><?php //echo $ausername4?><!--</td>-->
                       <td>YANSHUAI</td>
                       <td>YANSHUAI</td>
                       <td>YANSHUAI</td>
                       <td>YANSHUAI</td>
                   </tr>
                   <tr>
                       <td>第三名</td>
<!--                       <td>--><?php //echo $vusername5?><!--</td>-->
<!--                       <td>--><?php //echo $cusername5?><!--</td>-->
<!--                       <td>--><?php //echo $qusername5?><!--</td>-->
<!--                       <td>--><?php //echo $ausername5?><!--</td>-->
                       <td>haoyi</td>
                       <td>haoyi</td>
                       <td>haoyi</td>
                       <td>haoyi</td>

                   </tr>
               </table>
           </div>
           </div>
       <div class="row">
           <label for="start2">起始日期：</label><input id="start2" name="start2" type="date" />
           <label for="id">用户id：</label><input id="number" name="text" multiple="multiple"type="text" />
           <select id="rank">
               <option  value="1">最多浏览</option>
               <option  value="2">第二浏览</option>
               <option  value="3">第三浏览</option>
               <option  value="4">第四浏览</option>
               </select>
           <label>可以输入五位用户的id,之间用逗号隔开；若不输入则默认全网用户</label>
           <div id="viewInfo">请输入起始日期和用户id,查询用户七天的浏览量变化</div>
           <button id="button_view">查询</button><p id="button1"></p>
           <div id="container_view" style="min-width:400px;height:400px;"></div>
       </div>
       <div class="row">
           <div class="col-md-6" style="background-color: white;width: 47%">
           <p>成长性用户</p>
               <div id="container_low"></div>
           </div>
           <div class="col-md-6" style="background-color: white;width: 47%">
               <p>学习进度</p>
               <div id="container_process"></div>
           </div>
       </div>
       <div class="row" style="    margin-top: 15px;">
           <div class="col-md-6" style="background-color: white;width: 47%">
               <p style="font-size: 18px;    margin: 8px;">群组分析</p>
               <p>目前完成最多的组是：第<?php echo $team[0]?>组，他们的题目是：<?php echo $team[1]?></p>
               <p>目前完成最少的组是：第<?php echo $team[2]?>组，他们的题目是：<?php echo $team[3]?></p>
               <p>估测存在问题的小组（小组内最少浏览量还不足小组内最多浏览量的五分之一）</p>
               <p>总共有：<?php $a=team_question_sta(); echo $a[0]?>个组，有问题的组有：<?php echo $a[1]?>个</p>
               <div id="container_question"></div>
           </div>
           <div class="col-md-6" style="background-color: white;width: 47%">
              <label for="id">小组id：</label><input id="team_number" name="text" multiple="multiple"type="text" />
               <p id="team_info">请输入小组id,查询小组成员的浏览量变化</p>
               <button id="button_team">查询</button>
               <div id="container_team" ></div>
           </div>
       </div>
       </div>

   </body>
   </html>
<?php
}
