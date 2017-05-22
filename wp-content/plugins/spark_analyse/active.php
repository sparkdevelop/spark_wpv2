<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/3
 * Time: 10:18
 */
$time1 = isset($_POST['start']) ? $_POST['start'] : null;
$time2 = date("Y-m-d", strtotime('+1 day', strtotime($time1)));
$time3 = date("Y-m-d", strtotime('+2 day', strtotime($time1)));
$time4 = date("Y-m-d", strtotime('+3 day', strtotime($time1)));
$time5 = date("Y-m-d", strtotime('+4 day', strtotime($time1)));
$time6 = date("Y-m-d", strtotime('+5 day', strtotime($time1)));
$time7 = date("Y-m-d", strtotime('+6 day', strtotime($time1)));
$timegeshi = (int)substr($time1, 0, 4) . substr($time1, 5, 2) . substr($time1, 8, 2);
global $wpdb;
$c = get_option('spark_search_user_copy_right');
$sql = $wpdb->get_var("SELECT ID FROM `$wpdb->users` WHERE `user_login` = '$c'");
$time = $wpdb->get_results("SELECT post_date FROM `$wpdb->posts` WHERE `post_author` = '$sql'");
$articulnum = $wpdb->get_var("SELECT COUNT(*) FROM `$wpdb->posts` WHERE `post_author` = '$sql'");
$m = 0;
foreach ($time as $a) {
    $textlist[$m] = $a->post_date;
    $textlist1[$m] = substr($textlist[$m], 0, 10);
    $m++;
}
$result = array(0, 0, 0, 0, 0, 0, 0);
for ($i = 0; $i < $articulnum; $i++) {

    if ($time1 == $textlist1[$i])
        $result[0]++;
    else if ($time2 == $textlist1[$i])
        $result[1]++;
    else if ($time3 == $textlist1[$i])
        $result[2]++;
    else if ($time4 == $textlist1[$i])
        $result[3]++;
    else if ($time5 == $textlist1[$i])
        $result[4]++;
    else if ($time6 == $textlist1[$i])
        $result[5]++;
    else if ($time7 == $textlist1[$i])
        $result[6]++;
}

echo $result[0];
