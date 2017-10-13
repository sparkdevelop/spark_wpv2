<?php
/**
 * 词条频度页面
 */
    global $wpdb;
    $type = isset($_GET['type']) ? $_GET['type'] : 'fre';
    $start = isset($_GET['start']) ? $_GET['start'] : '';
    $end = isset($_GET['end']) ? $_GET['end'] : '';
    $words = isset($_GET['words']) ? $_GET['words'] : '';
    $tagss = isset($_GET['tags']) ? $_GET['tags'] : '';
    date_default_timezone_set("Asia/Shanghai");
    if ($start == '' && $end == '') {
        $start = date("Y-m-d", strtotime("-6 day"));
        $end = date("Y-m-d", strtotime("-0 day"));
    } else if ($end == '') {
        $end = date("Y-m-d", strtotime("$start+6 day"));
    } else if ($start == '') {
    $start = date("Y-m-d", strtotime("$end-6 day"));
}
//----------词条频度--------------
    if ($type == 'fre' || $type == '') {
        $vresults = [];
        $results = [];
        $viewTop10 = $wpdb->get_results('SELECT `post_title`, COUNT(`post_title`) as c FROM `wp_user_history` LEFT JOIN `wp_posts` ON `wp_user_history`.`action_post_id` = `wp_posts`.`ID` WHERE `action_post_type`!="page" AND `post_title`!= "" AND `post_title` LIKE "%' . $words . '%" AND `action_time` >= "' . date("Y-m-d 00:00:00", strtotime($start)) . '" AND `action_time` <= "' . date("Y-m-d 23:59:59", strtotime($end)) . '" GROUP BY `post_title` ORDER BY c DESC LIMIT 10');
        $searchTop10 = $wpdb->get_results('SELECT `words`,COUNT(`words`) as c FROM wp_search_datas WHERE `words` LIKE "%' . $words . '%" AND `date` >= "' . date("Y-m-d 00:00:00", strtotime($start)) . '" AND `date` <= "' . date("Y-m-d 23:59:59", strtotime($end)) . '" GROUP BY `words` ORDER BY c DESC LIMIT 10');
        for ($i = 0; $i < ((strtotime($end) - strtotime($start)) / 86400 + 1); $i++) {
            $currentDate = date("Y-m-d", strtotime("$start +" . $i . " day"));
            $startTime = date("Y-m-d 00:00:00", strtotime($currentDate));
            $endTime = date("Y-m-d 23:59:59", strtotime($currentDate));
            $xData[] = $currentDate;
            $vresult = $wpdb->get_results('SELECT `post_title`, COUNT(`post_title`) as c FROM `wp_user_history` LEFT JOIN `wp_posts` ON `wp_user_history`.`action_post_id` = `wp_posts`.`ID` WHERE `action_post_type`!="page" AND `post_title`!= "" AND `post_title` LIKE "%' . $words . '%" AND `action_time` >= "' . $startTime . '" AND `action_time` <= "' . $endTime . '" GROUP BY `post_title` ORDER BY c DESC LIMIT 10');
            $result = $wpdb->get_results('SELECT `words`,COUNT(`words`) as c FROM wp_search_datas WHERE `words` LIKE "%' . $words . '%" AND `date` >= "' . $startTime . '" AND `date` <= "' . $endTime . '" GROUP BY `words` ORDER BY c DESC LIMIT 10');
            $newResult = [];
            $newvResult = [];
            foreach ($result as $value) {
                $newResult[$value->words] = $value->c;
            }
            $results[$currentDate] = $newResult;
            foreach ($vresult as $value) {
                $newvResult[$value->post_title] = $value->c;
            }
            $vresults[$currentDate] = $newvResult;
        }
    }