<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/27
 * Time: 22:56
 */
global $c;
global $textlist1;
global $m;
global $time1,$time2,$time3,$time4,$time5,$time6,$time7;

function timechart($time1=0,$time2=0,$time3=0,$time4=0,$time5=0,$time6=0,$time7=0){
    global $textlist;
    global $textlist1;
    global $wpdb;
    global $time1, $time2, $time3, $time4, $time5, $time6, $time7;
    $time1=0;
    $time2=0;
    $time3=0;
    $time4=0;
    $time5=0;
    $time6=0;
    $time7=0;
    $m=0;
    $c=get_option('spark_search_user_copy_right');
    $sql =$wpdb->get_var( "SELECT ID FROM `$wpdb->users` WHERE `user_login` = '$c'");
    $time =$wpdb->get_results( "SELECT post_date FROM `$wpdb->posts` WHERE `post_author` = '$sql'and post_status='inherit'");
    foreach($time as $a){
        $textlist[$m]=$a->post_date;
        $textlist1[$m]= substr($textlist[$m],11,2);
        $m++;
    }
    $articulnum=$wpdb->get_var("SELECT COUNT(*) FROM `$wpdb->posts` WHERE `post_author` = '$sql'and post_status='inherit'");
    $c = $articulnum;
    $m=0;
    while($c>0) {
        if ($textlist1[$m] < 8 && $textlist1[$m] >= 0)
            $time1++;
        if ($textlist1[$m] < 11 && $textlist1[$m] >= 8)
            $time2++;
        if ($textlist1[$m] < 14 && $textlist1[$m] >= 11)
            $time3++;
        if ($textlist1[$m] < 17 && $textlist1[$m] >= 14)
            $time4++;
        if ($textlist1[$m] < 20 && $textlist1[$m] >= 17)
            $time5++;
        if ($textlist1[$m] < 22 && $textlist1[$m] >= 20)
            $time6++;
        if ($textlist1[$m] < 24 && $textlist1[$m] >= 22)
            $time7++;
        $m++;
        $c--;
    }

    return $time="$time1 $time2 $time3 $time4 $time5 $time6 $time7";
}
function time1(){
    global $time1;
    echo $time1;
}
function time2(){
    global $time2;
    echo $time2;
}
function time3(){
    global $time3;
    echo $time3;
}
function time4(){
    global $time4;
    echo $time4;
}
function time5(){
    global $time5;
    echo $time5;
}
function time6(){
    global $time6;
    echo $time6;
}
function time7(){
    global $time7;
    echo $time7;
}
function edittimezhou(){
    global $wpdb;
    global $m;
    global $textchuli;
    $m=0;
    $c=get_option('spark_search_user_copy_right');
    $sql =$wpdb->get_var( "SELECT ID FROM `$wpdb->users` WHERE `user_login` = '$c'");
    $time =$wpdb->get_results( "SELECT post_date FROM `$wpdb->posts` WHERE `post_author` = '$sql'and post_status='inherit' and post_type = 'revision'");
    foreach($time as $a){
        $textlist[$m]=$a->post_date;
        $textlist1[$m]= substr($textlist[$m],5,5);
        $spattern1 = "/-/i";
        $textchuli[$m]= preg_replace($spattern1, '', $textlist1[$m]);
        $m++;
    }
    $now = time();
    $time = '1' == date('w') ? strtotime('Monday', $now) : strtotime('last Monday', $now);
    $begintime = date('m-d ', $time);
    $endtime = date('m-d ', strtotime('Sunday', $now));
    //echo $begintime;
    $spattern1 = "/-/i";
    $articulnum=$wpdb->get_var("SELECT COUNT(*) FROM `$wpdb->posts` WHERE `post_author` = '$sql'and post_status='inherit'and post_type = 'revision'");
    $c = $articulnum;
    $beginwugang = preg_replace($spattern1, '', $begintime);
    $endwugang = preg_replace($spattern1, '', $endtime);
    $m=0;
    global $countzhou;
    $countzhou=0;
    while($c>0){
        if ($textchuli[$m]>=$beginwugang && $textchuli[$m]<=$endwugang)
            $countzhou++;
        $m++;
        $c--;
    }
    echo $countzhou;
}
function edittimemonth(){
    global $wpdb;
    global $m;
    global $textchuli;
    $m=0;
    $c=get_option('spark_search_user_copy_right');
    $sql =$wpdb->get_var( "SELECT ID FROM `$wpdb->users` WHERE `user_login` = '$c'");
    $time =$wpdb->get_results( "SELECT post_date FROM `$wpdb->posts` WHERE `post_author` = '$sql'and post_status='inherit' and post_type = 'revision'");
    foreach($time as $a){
        $textlist[$m]=$a->post_date;
        $textlist1[$m]= substr($textlist[$m],5,5);
        $spattern1 = "/-/i";
        $textchuli[$m]= preg_replace($spattern1, '', $textlist1[$m]);
        $m++;
    }
    $now = time();
    $begintime = date('m-d', mktime(0, 0, 0, date('m', $now), '1'));
    $endtime = date('m-d', mktime(0, 0, 0, date('m', $now), date('t', $now)));
    //echo $begintime;
    $spattern1 = "/-/i";
    $articulnum=$wpdb->get_var("SELECT COUNT(*) FROM `$wpdb->posts` WHERE `post_author` = '$sql'and post_status='inherit'and post_type = 'revision'");
    $c = $articulnum;
    $beginwugang = preg_replace($spattern1, '', $begintime);
    $endwugang = preg_replace($spattern1, '', $endtime);
    $m=0;
    global $countmonth;
    $countmonth=0;
    while($c>0){
        if ($textchuli[$m]>=$beginwugang && $textchuli[$m]<=$endwugang)
            $countmonth++;
        $m++;
        $c--;
    }
    echo $countmonth;
}
function editsum(){
    global $wpdb;
    global $m;
    global $textchuli;
    $m=0;
    $c=get_option('spark_search_user_copy_right');
    $sql =$wpdb->get_var( "SELECT ID FROM `$wpdb->users` WHERE `user_login` = '$c'");

    $articulnum=$wpdb->get_var("SELECT COUNT(*) FROM `$wpdb->posts` WHERE `post_author` = '$sql'and post_status='inherit'and post_type = 'revision'");
    $c = $articulnum;

    echo $c;
}
function publishtimezhou(){
    global $wpdb;
    global $m;
    global $textchuli;
    $m=0;
    $c=get_option('spark_search_user_copy_right');
    $sql =$wpdb->get_var( "SELECT ID FROM `$wpdb->users` WHERE `user_login` = '$c'");
    $time =$wpdb->get_results( "SELECT post_date FROM `$wpdb->posts` WHERE `post_author` = '$sql'and post_status='publish' and post_type = 'post'");
    foreach($time as $a){
        $textlist[$m]=$a->post_date;
        $textlist1[$m]= substr($textlist[$m],5,5);
        $spattern1 = "/-/i";
        $textchuli[$m]= preg_replace($spattern1, '', $textlist1[$m]);
        $m++;
    }
    $now = time();
    $time = '1' == date('w') ? strtotime('Monday', $now) : strtotime('last Monday', $now);
    $begintime = date('m-d ', $time);
    $endtime = date('m-d ', strtotime('Sunday', $now));
    //echo $begintime;
    $spattern1 = "/-/i";
    $articulnum=$wpdb->get_var("SELECT COUNT(*) FROM `$wpdb->posts` WHERE `post_author` = '$sql'and post_status='publish'and post_type = 'post'");
    $c = $articulnum;
    $beginwugang = preg_replace($spattern1, '', $begintime);
    $endwugang = preg_replace($spattern1, '', $endtime);
    $m=0;
    global $countzhou;
    $countzhou=0;
    while($c>0){
        if ($textchuli[$m]>=$beginwugang && $textchuli[$m]<=$endwugang)
            $countzhou++;
        $m++;
        $c--;
    }
    echo $countzhou;
}
function publishtimemonth(){
    global $wpdb;
    global $m;
    global $textchuli;
    $m=0;
    $c=get_option('spark_search_user_copy_right');
    $sql =$wpdb->get_var( "SELECT ID FROM `$wpdb->users` WHERE `user_login` = '$c'");
    $time =$wpdb->get_results( "SELECT post_date FROM `$wpdb->posts` WHERE `post_author` = '$sql'and post_status='publish' and post_type = 'post'");
    foreach($time as $a){
        $textlist[$m]=$a->post_date;
        $textlist1[$m]= substr($textlist[$m],5,5);
        $spattern1 = "/-/i";
        $textchuli[$m]= preg_replace($spattern1, '', $textlist1[$m]);
        $m++;
    }
    $now = time();
    $begintime = date('m-d', mktime(0, 0, 0, date('m', $now), '1'));
    $endtime = date('m-d', mktime(0, 0, 0, date('m', $now), date('t', $now)));
    //echo $begintime;
    $spattern1 = "/-/i";
    $articulnum=$wpdb->get_var("SELECT COUNT(*) FROM `$wpdb->posts` WHERE `post_author` = '$sql'and post_status='publish'and post_type = 'post'");
    $c = $articulnum;
    $beginwugang = preg_replace($spattern1, '', $begintime);
    $endwugang = preg_replace($spattern1, '', $endtime);
    $m=0;
    global $countmonth;
    $countmonth=0;
    while($c>0){
        if ($textchuli[$m]>=$beginwugang && $textchuli[$m]<=$endwugang)
            $countmonth++;
        $m++;
        $c--;
    }
    echo $countmonth;
}
function publishsum(){
    global $wpdb;
    global $m;
    global $textchuli;
    $m=0;
    $c=get_option('spark_search_user_copy_right');
    $sql =$wpdb->get_var( "SELECT ID FROM `$wpdb->users` WHERE `user_login` = '$c'");

    $articulnum=$wpdb->get_var("SELECT COUNT(*) FROM `$wpdb->posts` WHERE `post_author` = '$sql'and post_status='publish'and post_type = 'post'");
    $c = $articulnum;

    echo $c;
}
function wikiviewmost(){
    global $wpdb;
    global $m;
    global $textlist;
    global $textlist1;
    $m=0;
    $c=get_option('spark_search_user_copy_right');
    $sql =$wpdb->get_var( "SELECT ID FROM `$wpdb->users` WHERE `user_login` = '$c'");
    $time =$wpdb->get_results( "SELECT ID FROM `$wpdb->posts` WHERE `post_author` = '$sql'and post_status='publish' and post_type = 'post'");
    foreach($time as $a){
        $textlist[$m]=$a->ID;

        $m++;
    }

    $articulnum=$wpdb->get_var("SELECT COUNT(*) FROM `$wpdb->posts` WHERE `post_author` = '$sql'and post_status='publish'and post_type = 'post'");
    $c = $articulnum;
    $m=0;
    global $most;
    $most=0;
    while($c>0){
        $textlist1 =$wpdb->get_var( "SELECT meta_value FROM `$wpdb->postmeta` WHERE `meta_key` = 'views'and post_id=$textlist[$m]");
        if ($textlist1>$most){
            $most=$textlist1;
        }
        $m++;
        $c--;
    }
    echo $most;

}
function wikiviewaverage(){
    global $wpdb;
    global $m;
    global $textlist;
    global $textlist1;
    $m=0;
    $c=get_option('spark_search_user_copy_right');
    $sql =$wpdb->get_var( "SELECT ID FROM `$wpdb->users` WHERE `user_login` = '$c'");
    $time =$wpdb->get_results( "SELECT ID FROM `$wpdb->posts` WHERE `post_author` = '$sql'and post_status='publish' and post_type = 'post'");
    foreach($time as $a){
        $textlist[$m]=$a->ID;

        $m++;
    }

    $articulnum=$wpdb->get_var("SELECT COUNT(*) FROM `$wpdb->posts` WHERE `post_author` = '$sql'and post_status='publish'and post_type = 'post'");
    $c = $articulnum;
    $m=0;
    global $average;
    $average=0;
    while($c>0){
        $textlist1[$m] =$wpdb->get_var( "SELECT meta_value FROM `$wpdb->postmeta` WHERE `meta_key` = 'views'and post_id=$textlist[$m]");
        $m++;
        $c--;
    }
    $c = $articulnum;
    $m=0;
    while($c>0){
        $average+=$textlist1[$m];
        $m++;
        $c--;
    }
   $average=$average/$articulnum;
    echo sprintf("%.2f", $average);
}
function commentpost(){
    global $wpdb;
    global $m;
    global $textlist;
    global $textlist1;
    $m=0;
    $user=get_option('spark_search_user_copy_right');

    $articulnum=$wpdb->get_var("SELECT COUNT(*) FROM `$wpdb->comments` WHERE `comment_author` = '$user'");
    $c = $articulnum;
    echo $c;
}
function wikiviewtimechart($vtime1=0,$vtime2=0,$vtime3=0,$vtime4=0,$vtime5=0,$vtime6=0,$vtime7=0){
    global $vtextlist;
    global $vtextlist1;
    global $wpdb;
    global $vtime1, $vtime2, $vtime3, $vtime4, $vtime5, $vtime6, $vtime7;
    $vtime1=0;
    $vtime2=0;
    $vtime3=0;
    $vtime4=0;
    $vtime5=0;
    $vtime6=0;
    $vtime7=0;
    $m=0;
    $c=get_option('spark_search_user_copy_right');
    $sql =$wpdb->get_var( "SELECT ID FROM `$wpdb->users` WHERE `user_login` = '$c'");
    $time =$wpdb->get_results( "SELECT comment_date FROM `$wpdb->comments` WHERE `comment_author` = '$c'");
    foreach($time as $a){
        $vtextlist[$m]=$a->comment_date;
        $vtextlist1[$m]= substr($vtextlist[$m],11,2);
        $m++;
    }
    $articulnum=$wpdb->get_var("SELECT COUNT(*) FROM `$wpdb->comments` WHERE `comment_author` = '$c'");
    $m=0;
    while($articulnum>0) {
        if ($vtextlist1[$m] < 8 && $vtextlist1[$m] >= 0)
            $vtime1++;
        if ($vtextlist1[$m] < 11 && $vtextlist1[$m] >= 8)
            $vtime2++;
        if ($vtextlist1[$m] < 14 && $vtextlist1[$m] >= 11)
            $vtime3++;
        if ($vtextlist1[$m] < 17 && $vtextlist1[$m] >= 14)
            $vtime4++;
        if ($vtextlist1[$m] < 20 && $vtextlist1[$m] >= 17)
            $vtime5++;
        if ($vtextlist1[$m] < 22 && $vtextlist1[$m] >= 20)
            $vtime6++;
        if ($vtextlist1[$m] < 24 && $vtextlist1[$m] >= 22)
            $vtime7++;
        $m++;
        $articulnum--;
    }

    return $time="$vtime1 $vtime2 $vtime3 $vtime4 $vtime5 $vtime6 $vtime7";
}
function vtime1(){
    global $vtime1;
    echo $vtime1;
}
function vtime2(){
    global $vtime2;
    echo $vtime2;
}
function vtime3(){
    global $vtime3;
    echo $vtime3;
}
function vtime4(){
    global $vtime4;
    echo $vtime4;
}
function vtime5(){
    global $vtime5;
    echo $vtime5;
}
function vtime6(){
    global $vtime6;
    echo $vtime6;
}
function vtime7(){
    global $vtime7;
    echo $vtime7;
}
function questiontimechart($qtime1=0,$qtime2=0,$qtime3=0,$qtime4=0,$qtime5=0,$qtime6=0,$qtime7=0){
    global $qtextlist;
    global $qtextlist1;
    global $wpdb;
    global $qtime1, $qtime2, $qtime3, $qtime4, $qtime5, $qtime6, $qtime7;
    $qtime1=0;
    $qtime2=0;
    $qtime3=0;
    $qtime4=0;
    $qtime5=0;
    $qtime6=0;
    $qtime7=0;
    $m=0;
    $c=get_option('spark_search_user_copy_right');
    $sql =$wpdb->get_var( "SELECT ID FROM `$wpdb->users` WHERE `user_login` = '$c'");
    $time =$wpdb->get_results( "SELECT post_date FROM `$wpdb->posts` WHERE `post_author` = '$sql'and post_status='publish'and post_type='dwqa-question'");
    foreach($time as $a){
        $textlist[$m]=$a->post_date;
        $textlist1[$m]= substr($textlist[$m],11,2);
        $m++;
    }
    $articulnum=$wpdb->get_var("SELECT COUNT(*) FROM `$wpdb->posts` WHERE `post_author` = '$sql'and post_status='publish'and post_type='dwqa-question'");
    $c = $articulnum;
    $m=0;
    while($c>0) {
        if ($textlist1[$m] < 8 && $textlist1[$m] >= 0)
            $qtime1++;
        if ($textlist1[$m] < 11 && $textlist1[$m] >= 8)
            $qtime2++;
        if ($textlist1[$m] < 14 && $textlist1[$m] >= 11)
            $qtime3++;
        if ($textlist1[$m] < 17 && $textlist1[$m] >= 14)
            $qtime4++;
        if ($textlist1[$m] < 20 && $textlist1[$m] >= 17)
            $qtime5++;
        if ($textlist1[$m] < 22 && $textlist1[$m] >= 20)
            $qtime6++;
        if ($textlist1[$m] < 24 && $textlist1[$m] >= 22)
            $qtime7++;
        $m++;
        $c--;
    }

    return $time="$qtime1 $qtime2 $qtime3 $qtime4 $qtime5 $qtime6 $qtime7";
}
function qtime1(){
    global $qtime1;
    echo $qtime1;
}
function qtime2(){
    global $qtime2;
    echo $qtime2;
}
function qtime3(){
    global $qtime3;
    echo $qtime3;
}
function qtime4(){
    global $qtime4;
    echo $qtime4;
}
function qtime5(){
    global $qtime5;
    echo $qtime5;
}
function qtime6(){
    global $qtime6;
    echo $qtime6;
}
function qtime7(){
    global $qtime7;
    echo $qtime7;
}
function answertimechart($atime1=0,$atime2=0,$atime3=0,$atime4=0,$atime5=0,$atime6=0,$atime7=0){
    global $atextlist;
    global $atextlist1;
    global $wpdb;
    global $atime1, $atime2, $atime3, $atime4, $atime5, $atime6, $atime7;
    $atime1=0;
    $atime2=0;
    $atime3=0;
    $atime4=0;
    $atime5=0;
    $atime6=0;
    $atime7=0;
    $m=0;
    $c=get_option('spark_search_user_copy_right');
    $sql =$wpdb->get_var( "SELECT ID FROM `$wpdb->users` WHERE `user_login` = '$c'");
    $time =$wpdb->get_results( "SELECT post_date FROM `$wpdb->posts` WHERE `post_author` = '$sql'and post_status='publish'and post_type='dwqa-answer'");
    foreach($time as $a){
        $textlist[$m]=$a->post_date;
        $textlist1[$m]= substr($textlist[$m],11,2);
        $m++;
    }
    $articulnum=$wpdb->get_var("SELECT COUNT(*) FROM `$wpdb->posts` WHERE `post_author` = '$sql'and post_status='publish'and post_type='dwqa-answer'");
    $c = $articulnum;
    $m=0;
    while($c>0) {
        if ($textlist1[$m] < 8 && $textlist1[$m] >= 0)
            $atime1++;
        if ($textlist1[$m] < 11 && $textlist1[$m] >= 8)
            $atime2++;
        if ($textlist1[$m] < 14 && $textlist1[$m] >= 11)
            $atime3++;
        if ($textlist1[$m] < 17 && $textlist1[$m] >= 14)
            $atime4++;
        if ($textlist1[$m] < 20 && $textlist1[$m] >= 17)
            $atime5++;
        if ($textlist1[$m] < 22 && $textlist1[$m] >= 20)
            $atime6++;
        if ($textlist1[$m] < 24 && $textlist1[$m] >= 22)
            $atime7++;
        $m++;
        $c--;
    }

    return $time="$atime1 $atime2 $atime3 $atime4 $atime5 $atime6 $atime7";
}
function atime1(){
    global $atime1;
    echo $atime1;
}
function atime2(){
    global $atime2;
    echo $atime2;
}
function atime3(){
    global $atime3;
    echo $atime3;
}
function atime4(){
    global $atime4;
    echo $atime4;
}
function atime5(){
    global $atime5;
    echo $atime5;
}
function atime6(){
    global $atime6;
    echo $atime6;
}
function atime7(){
    global $atime7;
    echo $atime7;
}
function questiontimezhou(){
    global $wpdb;
    global $m;
    global $textchuli;
    $m=0;
    $c=get_option('spark_search_user_copy_right');
    $sql =$wpdb->get_var( "SELECT ID FROM `$wpdb->users` WHERE `user_login` = '$c'");
    $time =$wpdb->get_results( "SELECT post_date FROM `$wpdb->posts` WHERE `post_author` = '$sql'and post_status='publish' and post_type='dwqa-question'");
    foreach($time as $a){
        $textlist[$m]=$a->post_date;
        $textlist1[$m]= substr($textlist[$m],5,5);
        $spattern1 = "/-/i";
        $textchuli[$m]= preg_replace($spattern1, '', $textlist1[$m]);
        $m++;
    }
    $now = time();
    $time = '1' == date('w') ? strtotime('Monday', $now) : strtotime('last Monday', $now);
    $begintime = date('m-d ', $time);
    $endtime = date('m-d ', strtotime('Sunday', $now));
    //echo $begintime;
    $spattern1 = "/-/i";
    $articulnum=$wpdb->get_var("SELECT COUNT(*) FROM `$wpdb->posts` WHERE `post_author` = '$sql'and post_status='publish' and post_type='dwqa-question'");
    $c = $articulnum;
    $beginwugang = preg_replace($spattern1, '', $begintime);
    $endwugang = preg_replace($spattern1, '', $endtime);
    $m=0;
    global $countzhou;
    $countzhou=0;
    while($c>0){
        if ($textchuli[$m]>=$beginwugang && $textchuli[$m]<=$endwugang)
            $countzhou++;
        $m++;
        $c--;
    }
    echo $countzhou;
}
function questiontimemonth(){
    global $wpdb;
    global $m;
    global $textchuli;
    $m=0;
    $c=get_option('spark_search_user_copy_right');
    $sql =$wpdb->get_var( "SELECT ID FROM `$wpdb->users` WHERE `user_login` = '$c'");
    $time =$wpdb->get_results( "SELECT post_date FROM `$wpdb->posts` WHERE `post_author` = '$sql'and post_status='publish' and post_type='dwqa-question'");
    foreach($time as $a){
        $textlist[$m]=$a->post_date;
        $textlist1[$m]= substr($textlist[$m],5,5);
        $spattern1 = "/-/i";
        $textchuli[$m]= preg_replace($spattern1, '', $textlist1[$m]);
        $m++;
    }
    $now = time();
    $begintime = date('m-d', mktime(0, 0, 0, date('m', $now), '1'));
    $endtime = date('m-d', mktime(0, 0, 0, date('m', $now), date('t', $now)));
    //echo $begintime;
    $spattern1 = "/-/i";
    $articulnum=$wpdb->get_var("SELECT COUNT(*) FROM `$wpdb->posts` WHERE `post_author` = '$sql'and post_status='publish' and post_type='dwqa-question'");
    $c = $articulnum;
    $beginwugang = preg_replace($spattern1, '', $begintime);
    $endwugang = preg_replace($spattern1, '', $endtime);
    $m=0;
    global $countmonth;
    $countmonth=0;
    while($c>0){
        if ($textchuli[$m]>=$beginwugang && $textchuli[$m]<=$endwugang)
            $countmonth++;
        $m++;
        $c--;
    }
    echo $countmonth;
}
function questionsum(){
    global $wpdb;
    global $m;
    global $textchuli;
    $m=0;
    $c=get_option('spark_search_user_copy_right');
    $sql =$wpdb->get_var( "SELECT ID FROM `$wpdb->users` WHERE `user_login` = '$c'");

    $articulnum=$wpdb->get_var("SELECT COUNT(*) FROM `$wpdb->posts` WHERE `post_author` = '$sql'and post_status='publish' and post_type='dwqa-question'");
    $c = $articulnum;

    echo $c;
}
function answertimezhou(){
    global $wpdb;
    global $m;
    global $textchuli;
    $m=0;
    $c=get_option('spark_search_user_copy_right');
    $sql =$wpdb->get_var( "SELECT ID FROM `$wpdb->users` WHERE `user_login` = '$c'");
    $time =$wpdb->get_results( "SELECT post_date FROM `$wpdb->posts` WHERE `post_author` = '$sql'and post_status='publish' and post_type = 'dwqa-answer'");
    foreach($time as $a){
        $textlist[$m]=$a->post_date;
        $textlist1[$m]= substr($textlist[$m],5,5);
        $spattern1 = "/-/i";
        $textchuli[$m]= preg_replace($spattern1, '', $textlist1[$m]);
        $m++;
    }
    $now = time();
    $time = '1' == date('w') ? strtotime('Monday', $now) : strtotime('last Monday', $now);
    $begintime = date('m-d ', $time);
    $endtime = date('m-d ', strtotime('Sunday', $now));
    //echo $begintime;
    $spattern1 = "/-/i";
    $articulnum=$wpdb->get_var("SELECT COUNT(*) FROM `$wpdb->posts` WHERE `post_author` = '$sql'and post_status='publish' and post_type = 'dwqa-answer'");
    $c = $articulnum;
    $beginwugang = preg_replace($spattern1, '', $begintime);
    $endwugang = preg_replace($spattern1, '', $endtime);
    $m=0;
    global $countzhou;
    $countzhou=0;
    while($c>0){
        if ($textchuli[$m]>=$beginwugang && $textchuli[$m]<=$endwugang)
            $countzhou++;
        $m++;
        $c--;
    }
    echo $countzhou;
}
function answertimemonth(){
    global $wpdb;
    global $m;
    global $textchuli;
    $m=0;
    $c=get_option('spark_search_user_copy_right');
    $sql =$wpdb->get_var( "SELECT ID FROM `$wpdb->users` WHERE `user_login` = '$c'");
    $time =$wpdb->get_results( "SELECT post_date FROM `$wpdb->posts` WHERE `post_author` = '$sql'and post_status='publish' and post_type = 'dwqa-answer'");
    foreach($time as $a){
        $textlist[$m]=$a->post_date;
        $textlist1[$m]= substr($textlist[$m],5,5);
        $spattern1 = "/-/i";
        $textchuli[$m]= preg_replace($spattern1, '', $textlist1[$m]);
        $m++;
    }
    $now = time();
    $begintime = date('m-d', mktime(0, 0, 0, date('m', $now), '1'));
    $endtime = date('m-d', mktime(0, 0, 0, date('m', $now), date('t', $now)));
    //echo $begintime;
    $spattern1 = "/-/i";
    $articulnum=$wpdb->get_var("SELECT COUNT(*) FROM `$wpdb->posts` WHERE `post_author` = '$sql'and post_status='publish' and post_type = 'dwqa-answer'");
    $c = $articulnum;
    $beginwugang = preg_replace($spattern1, '', $begintime);
    $endwugang = preg_replace($spattern1, '', $endtime);
    $m=0;
    global $countmonth;
    $countmonth=0;
    while($c>0){
        if ($textchuli[$m]>=$beginwugang && $textchuli[$m]<=$endwugang)
            $countmonth++;
        $m++;
        $c--;
    }
    echo $countmonth;
}
function answersum(){
    global $wpdb;
    global $m;
    global $textchuli;
    $m=0;
    $c=get_option('spark_search_user_copy_right');
    $sql =$wpdb->get_var( "SELECT ID FROM `$wpdb->users` WHERE `user_login` = '$c'");

    $articulnum=$wpdb->get_var("SELECT COUNT(*) FROM `$wpdb->posts` WHERE `post_author` = '$sql'and post_status='publish' and post_type = 'dwqa-answer'");
    $c = $articulnum;

    echo $c;
}
function questionviewmost(){
    global $wpdb;
    global $m;
    global $textlist;
    global $textlist1;
    $m=0;
    $c=get_option('spark_search_user_copy_right');
    $sql =$wpdb->get_var( "SELECT ID FROM `$wpdb->users` WHERE `user_login` = '$c'");
    $time =$wpdb->get_results( "SELECT ID FROM `$wpdb->posts` WHERE `post_author` = '$sql'and post_status='publish' and post_type = 'dwqa-question'");
    foreach($time as $a){
        $textlist[$m]=$a->ID;

        $m++;
    }

    $articulnum=$wpdb->get_var("SELECT COUNT(*) FROM `$wpdb->posts` WHERE `post_author` = '$sql'and post_status='publish'and post_type = 'dwqa-question'");
    $c = $articulnum;
    $m=0;
    global $most;
    $most=0;
    while($c>0){
        $textlist1 =$wpdb->get_var( "SELECT meta_value FROM `$wpdb->postmeta` WHERE `meta_key` = '_dwqa_views'and post_id=$textlist[$m]");
        if ($textlist1>$most){
            $most=$textlist1;
        }
        $m++;
        $c--;
    }
    echo $most;

}
function questionviewaverage(){
    global $wpdb;
    global $m;
    global $textlist;
    global $textlist2;
    $m=0;
    $c=get_option('spark_search_user_copy_right');
    $sql =$wpdb->get_var( "SELECT ID FROM `$wpdb->users` WHERE `user_login` = '$c'");
    $time =$wpdb->get_results( "SELECT ID FROM `$wpdb->posts` WHERE `post_author` = '$sql'and post_status='publish' and post_type = 'dwqa-question'");
    foreach($time as $a){
        $textlist[$m]=$a->ID;
        $m++;
    }

    $articulnum=$wpdb->get_var("SELECT COUNT(*) FROM `$wpdb->posts` WHERE `post_author` = '$sql'and post_status='publish'and post_type = 'dwqa-question'");
    $c = $articulnum;
    $m=0;
    global $average;
    $average=0;
    while($c>0){
        $textlist2[$m] =$wpdb->get_var( "SELECT meta_value FROM `$wpdb->postmeta` WHERE `meta_key` = '_dwqa_views'and post_id=$textlist[$m]");
        $m++;
        $c--;
    }
    $c = $articulnum;
    $m=0;
    while($c>0){

        $average+=$textlist2[$m];
        $m++;
        $c--;

    }
     $average=$average/$articulnum;
    echo sprintf("%.2f", $average);

}
function getchoice(){
    global $wpdb;
    global $m;
    global $textlist;
    global $textlist3;
    $m=0;
    $c=get_option('spark_search_user_copy_right');
    $sql =$wpdb->get_var( "SELECT ID FROM `$wpdb->users` WHERE `user_login` = '$c'");
    $time =$wpdb->get_results( "SELECT ID FROM `$wpdb->posts` WHERE `post_author` = '$sql'and post_status='publish' and post_type = 'dwqa-answer'");
    foreach($time as $a){
        $textlist[$m]=$a->ID;
        $m++;
    }
    $art=$wpdb->get_var("SELECT COUNT(*) FROM `$wpdb->posts` WHERE `post_author` = '$sql'and post_status='publish'and post_type = 'dwqa-answer'");
    $m=0;
    global $count;
    $count=0;
    $articulnum=$wpdb->get_results( "SELECT meta_value FROM `$wpdb->postmeta` WHERE `meta_key` = '_dwqa_best_answer'");
    foreach($articulnum as $b){
        $textlist3[$m]=$b->meta_value;
        for($i=0;$i<$art;$i++) {
            if ($textlist3[$m] == $textlist[$i])
                $count++;
        }
        $m++;
    }
    echo $count;
}
function getzan(){

    global $wpdb;
    global $m;
    global $textlist;
    global $textlist3;
    $m=0;
    global $count;
    $count=0;
    $c=get_option('spark_search_user_copy_right');
    $sql =$wpdb->get_var( "SELECT ID FROM `$wpdb->users` WHERE `user_login` = '$c'");
    $time =$wpdb->get_results( "SELECT ID FROM `$wpdb->posts` WHERE `post_author` = '$sql'and post_status='publish' and post_type = 'dwqa-answer'");
    foreach($time as $a){
        $textlist[$m]=$a->ID;
    $articulnum=$wpdb->get_var( "SELECT meta_value FROM `$wpdb->postmeta` WHERE `meta_key` = '_dwqa_votes' and post_id='$textlist[$m]'");

      $count+=$articulnum;

        $m++;
    }
    echo $count;
}
function getcomment(){
    global $wpdb;
    global $m;
    global $textlist;
    global $textlist3;
    $m=0;
    $c=get_option('spark_search_user_copy_right');
    $sql =$wpdb->get_var( "SELECT ID FROM `$wpdb->users` WHERE `user_login` = '$c'");
    $time =$wpdb->get_results( "SELECT ID FROM `$wpdb->posts` WHERE `post_author` = '$sql'and post_status='publish' and post_type = 'post'");
    foreach($time as $a){
        $textlist[$m]=$a->ID;
        $m++;
    }
    $art=$wpdb->get_var("SELECT COUNT(*) FROM `$wpdb->posts` WHERE `post_author` = '$sql'and post_status='publish'and post_type = 'post'");
    $m=0;
    global $count;
    $count=0;
    $articulnum=$wpdb->get_results( "SELECT comment_post_ID FROM `$wpdb->comments` ");
    foreach($articulnum as $b){
        $textlist3[$m]=$b->comment_post_ID;
        for($i=0;$i<$art;$i++) {
            if ($textlist3[$m] == $textlist[$i])
                $count++;
        }
        $m++;
    }
    echo $count;
}