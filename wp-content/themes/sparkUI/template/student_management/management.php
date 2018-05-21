<?php
/**
 * Created by PhpStorm.
 * User: wangchuwei
 * Date: 2018/3/1
 * Time: 下午2:41
 */
global $wpdb;
$type = $_GET['type'];
$start = $_GET['start'];
$end = $_GET['end'];
$words = $_GET['words'];
$tagss = $_GET['tags'];
$memberID = $_GET['memberID'];
$separatePage = $_GET['separatePage'];
$pageNum = $_GET['pageNum'];
$recordStart = $_GET['recordStart'];
$recordEnd = $_GET['recordEnd'];

$url = $_SERVER['QUERY_STRING'];
if($pageNum ==null){
    $pageNum = 0;
}

function cut_str($str,$sign,$number){
    $array=explode($sign, $str);
    $length=count($array);
    if($number<0){
        $new_array=array_reverse($array);
        $abs_number=abs($number);
        if($abs_number>$length){
            return 'error';
        }else{
            return $new_array[$abs_number-1];
        }
    }else{
        if($number>=$length){
            return 'error';
        }else{
            return $array[$number];
        }
    }
}
$get_id = cut_str($url,'&',1);

$group_id = substr($get_id,3);

//筛选出整组成员及相关信息
$group_member = $wpdb->get_results('SELECT `user_id` , `user_login` FROM  `wp_gp_member` LEFT JOIN `wp_users` ON `wp_gp_member`.`user_id` = `wp_users`.`ID` 
                                               WHERE `group_id` = "'. $group_id .'"' );
//print_r($group_member);

$nickname = [];
$mem_id =[];
foreach ($group_member as $key => $member_list){
    $nickname[] = $member_list->user_login;
    $mem_id[] = $member_list->user_id;
}
//print_r($memberID);
//print_r($mem_id);

//个人学习路径部分

if($memberID == null){
    $memberID = $mem_id[0];
}

//选定用户昵称
$p_name = $wpdb->get_results('SELECT `user_login`FROM `wp_users` WHERE `ID` = "'.$memberID.'"  ');
$chosenPerson = [];
foreach($p_name as $key => $k){
    $chosenPerson[] = $k ->user_login;
}
//选定用户昵称结束
//筛选出整组成员信息结束



date_default_timezone_set("Asia/Shanghai");
if ($start == '' && $end == '') {
    $start = date("Y-m-d", strtotime("-6 day"));
    $end = date("Y-m-d", strtotime("-0 day"));
} else if ($end == '') {
    $end = date("Y-m-d", strtotime("$start+6 day"));
} else if ($start == '') {
    $start = date("Y-m-d", strtotime("$end-6 day"));
}

if ($recordStart == '' && $recordEnd == '') {
    $recordStart = date("Y-m-d", strtotime("-1000 day"));
    $recordEnd = date("Y-m-d", strtotime("-0 day"));
}

//----------词条频度--------------
if ($type == 'fre' || $type == null) {
    $vresults = [];
    $results = [];
    $pieResults = [];
    $viewTop10 = $wpdb->get_results('SELECT `post_title`, COUNT(`post_title`) as c FROM `wp_user_history` LEFT JOIN `wp_posts` ON `wp_user_history`.`action_post_id` = `wp_posts`.`ID` 
                                            LEFT JOIN `wp_gp_member` ON `wp_user_history`.`user_id`= `wp_gp_member`.`user_id` 
                                            WHERE `action_post_type`!="page" AND `post_title`!= ""  AND `group_id` = "'. $group_id .'" 
                                            AND `action_time` >= "' . date("Y-m-d 00:00:00", strtotime($start)) . '" AND `action_time` <= "' . date("Y-m-d 23:59:59", strtotime($end)) . '" 
                                            GROUP BY `post_title` ORDER BY c DESC LIMIT 10');
    $searchTop10 = $wpdb->get_results('SELECT `words`,COUNT(`words`) as c FROM wp_search_datas LEFT JOIN `wp_gp_member`ON `wp_search_datas`.`user_id` = `wp_gp_member`.`user_id` 
                                              WHERE  `group_id` = "'. $group_id .'" AND `date` >= "' . date("Y-m-d 00:00:00", strtotime($start)) . '" 
                                              AND `date` <= "' . date("Y-m-d 23:59:59", strtotime($end)) . '" GROUP BY `words` ORDER BY c DESC LIMIT 10');

    //print_r($viewTop10);
    //print_r(json_encode($pieResults));
    //$test = [];


    for ($i = 0; $i < ((strtotime($end) - strtotime($start)) / 86400 + 1); $i++) {
        $currentDate = date("Y-m-d", strtotime("$start +" . $i . " day"));
        $startTime = date("Y-m-d 00:00:00", strtotime($currentDate));
        $endTime = date("Y-m-d 23:59:59", strtotime($currentDate));
        $xData[] = $currentDate;
        $vresult = $wpdb->get_results('SELECT `post_title`, COUNT(`post_title`) as c FROM `wp_user_history` LEFT JOIN `wp_posts`ON `wp_user_history`.`action_post_id` = `wp_posts`.`ID` 
                                              LEFT JOIN `wp_gp_member` ON `wp_user_history`.`user_id`= `wp_gp_member`.`user_id` 
                                              WHERE `action_post_type`!="page" AND `post_title`!= "" AND `group_id` = "'. $group_id .'" 
                                              AND `action_time` >= "' . $startTime . '" AND `action_time` <= "' . $endTime . '" GROUP BY `post_title` ORDER BY c DESC LIMIT 10');
        $result = $wpdb->get_results('SELECT `words`,COUNT(`words`) as c FROM wp_search_datas LEFT JOIN `wp_gp_member`ON `wp_search_datas`.`user_id` = `wp_gp_member`.`user_id` 
                                             WHERE  `group_id` = "'. $group_id .'" AND `date` >= "' . $startTime . '" AND `date` <= "' . $endTime . '" GROUP BY `words` ORDER BY c DESC LIMIT 10');
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

//--------成员词频统计-------------
if($type == 'memberfre'){
    $vresults = [];
    $results = [];
    $pieResults = [];
    $viewTop10 = $wpdb->get_results('SELECT `post_title`, COUNT(`post_title`) as c FROM `wp_user_history` LEFT JOIN `wp_posts` ON `wp_user_history`.`action_post_id` = `wp_posts`.`ID` 
                                            LEFT JOIN `wp_gp_member` ON `wp_user_history`.`user_id`= `wp_gp_member`.`user_id` 
                                            WHERE `action_post_type`!="page" AND `post_title`!= ""  AND `group_id` = "'. $group_id .'"AND `wp_gp_member`.`user_id` = "'.$memberID.'" 
                                            AND `action_time` >= "' . date("Y-m-d 00:00:00", strtotime($start)) . '" AND `action_time` <= "' . date("Y-m-d 23:59:59", strtotime($end)) . '" 
                                            GROUP BY `post_title` ORDER BY c DESC LIMIT 10');
    $searchTop10 = $wpdb->get_results('SELECT `words`,COUNT(`words`) as c FROM wp_search_datas LEFT JOIN `wp_gp_member`ON `wp_search_datas`.`user_id` = `wp_gp_member`.`user_id` 
                                              WHERE  `group_id` = "'. $group_id .'"AND `wp_gp_member`.`user_id` = "'.$memberID.'" AND `date` >= "' . date("Y-m-d 00:00:00", strtotime($start)) . '" 
                                              AND `date` <= "' . date("Y-m-d 23:59:59", strtotime($end)) . '" GROUP BY `words` ORDER BY c DESC LIMIT 10');

    //print_r($viewTop10);
    //print_r(json_encode($pieResults));
    //$test = [];


    for ($i = 0; $i < ((strtotime($end) - strtotime($start)) / 86400 + 1); $i++) {
        $currentDate = date("Y-m-d", strtotime("$start +" . $i . " day"));
        $startTime = date("Y-m-d 00:00:00", strtotime($currentDate));
        $endTime = date("Y-m-d 23:59:59", strtotime($currentDate));
        $xData[] = $currentDate;
        $vresult = $wpdb->get_results('SELECT `post_title`, COUNT(`post_title`) as c FROM `wp_user_history` LEFT JOIN `wp_posts`ON `wp_user_history`.`action_post_id` = `wp_posts`.`ID` 
                                              LEFT JOIN `wp_gp_member` ON `wp_user_history`.`user_id`= `wp_gp_member`.`user_id` 
                                              WHERE `action_post_type`!="page" AND `post_title`!= "" AND `group_id` = "'. $group_id .'" AND `wp_gp_member`.`user_id` = "'.$memberID.'" 
                                              AND `action_time` >= "' . $startTime . '" AND `action_time` <= "' . $endTime . '" GROUP BY `post_title` ORDER BY c DESC LIMIT 10');
        $result = $wpdb->get_results('SELECT `words`,COUNT(`words`) as c FROM wp_search_datas LEFT JOIN `wp_gp_member`ON `wp_search_datas`.`user_id` = `wp_gp_member`.`user_id` 
                                             WHERE  `group_id` = "'. $group_id .'"AND `wp_gp_member`.`user_id` = "'.$memberID.'" AND `date` >= "' . $startTime . '" AND `date` <= "' . $endTime . '" GROUP BY `words` ORDER BY c DESC LIMIT 10');
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
//--------成员词频统计结束----------

//-----------行为轨迹--------------
if($type == 'tra'&& $separatePage == null){
    //轨迹节点
    $trackNode = [];
    $trackNodes = [];
    $trackResult = [];

    //个人轨迹节点
    $memberNode = [];
    $memberNodes = [];
    $memberResult = [];

    for ($i = 0; $i < ((strtotime($end) - strtotime($start)) / 86400 + 1); $i++) {
        $currentDate = date("Y-m-d", strtotime("$start +" . $i . " day"));
        $startTime = date("Y-m-d 00:00:00", strtotime($currentDate));
        $endTime = date("Y-m-d 23:59:59", strtotime($currentDate));
        $xData[] = $currentDate;
        $vresult = $wpdb->get_results('SELECT `post_title`, COUNT(`post_title`) as c FROM `wp_user_history` LEFT JOIN `wp_posts`ON `wp_user_history`.`action_post_id` = `wp_posts`.`ID` 
                                              LEFT JOIN `wp_gp_member` ON `wp_user_history`.`user_id`= `wp_gp_member`.`user_id` 
                                              WHERE `action_post_type`!="page" AND `post_title`!= "" AND `group_id` = "'. $group_id .'" 
                                              AND `action_time` >= "' . $startTime . '" AND `action_time` <= "' . $endTime . '" GROUP BY `post_title` ORDER BY c DESC LIMIT 1');

        array_push($trackNode,$vresult);

    }
    //print_r($trackNode);


    function delEmpty($v)
    {
        if ($v=== array())
        {
            return false;
        }
        return true;
    }

    $trackNodes = array_filter($trackNode,'delEmpty');
    foreach($trackNodes as $value){
        array_push($trackResult,$value);
    }
    //print_r($trackResult);




    for ($i = 0; $i < ((strtotime($end) - strtotime($start)) / 86400 + 1); $i++) {
        $currentDate = date("Y-m-d", strtotime("$start +" . $i . " day"));
        $startTime = date("Y-m-d 00:00:00", strtotime($currentDate));
        $endTime = date("Y-m-d 23:59:59", strtotime($currentDate));
        $xData[] = $currentDate;
        $mResult = $wpdb->get_results('SELECT `post_title`, COUNT(`post_title`) as c FROM `wp_user_history` LEFT JOIN `wp_posts`ON `wp_user_history`.`action_post_id` = `wp_posts`.`ID` 
                                              LEFT JOIN `wp_gp_member` ON `wp_user_history`.`user_id`= `wp_gp_member`.`user_id` 
                                              WHERE `action_post_type`!="page" AND `post_title`!= "" AND `group_id` = "'. $group_id .'" 
                                              AND `wp_gp_member`.`user_id` = "'.$memberID.'" AND `action_time` >= "' . $startTime . '" AND `action_time` <= "' . $endTime . '" 
                                              GROUP BY `post_title` ORDER BY c DESC LIMIT 1');

        array_push($memberNode,$mResult);

    }
    //print_r($memberNode);

    $memberNodes = array_filter($memberNode,'delEmpty');
    foreach($memberNodes as $value){
        array_push($memberResult,$value);
    }

}
//------------问答统计界面(新增界面)-------------
if($type == 'tra' && $separatePage == 'openRecord'){

    $questionName = [];
    //浏览次数
    $questionViewTimes = [];
    $questionGuild = [];
    $lastViewTime = [];

    $pageCount = 0;
    $pageSize = 10;
    $rowCount = 0;

    $startTime = date("Y-m-d 00:00:00", strtotime($recordStart));
    $endTime = date("Y-m-d 23:59:59", strtotime($recordEnd));



//================统计条数信息==============
    $question = $wpdb->get_results('SELECT `post_title`,`action_time`,COUNT(`post_title`)as c FROM `wp_gp_member` LEFT JOIN `wp_user_history`ON `wp_gp_member`.`user_id` = `wp_user_history`.`user_id`
                                           LEFT JOIN  `wp_posts` ON `wp_user_history`.`action_post_id` = `wp_posts`.`ID`
                                           WHERE `post_type` LIKE "dwqa%" AND `group_id` = "'.$group_id.'"AND `action_time` >= "' . $startTime . '" AND `action_time` <= "' . $endTime . '" GROUP BY `post_title` ORDER BY c DESC');
    $rowCount = count($question);
    //print_r($rowCount);
    $pageCount =ceil($rowCount/$pageSize);
    //print_r($pageCount);
    $startRow = $pageNum * 10;
//===============结束统计===================

    $sql = 'SELECT `post_title`,`guid`,`action_time`,COUNT(`post_title`)as c FROM `wp_gp_member` LEFT JOIN `wp_user_history`ON `wp_gp_member`.`user_id` = `wp_user_history`.`user_id`
            LEFT JOIN  `wp_posts` ON `wp_user_history`.`action_post_id` = `wp_posts`.`ID`
            WHERE `post_type` LIKE "dwqa%" AND `group_id` = "'.$group_id.'"AND `action_time` >= "' . $startTime . '" AND `action_time` <= "' . $endTime . '" GROUP BY `post_title` ORDER BY c DESC LIMIT '.$startRow.',10';
    $questionList = $wpdb->get_results($sql);
    //print_r($questionList);
    foreach ($questionList as $key => $value){
        array_push($questionName,$value->post_title);
    }
    foreach ($questionList as $key => $value){
        array_push($questionViewTimes,$value->c);
    }
    foreach ($questionList as $key => $value){
        array_push($lastViewTime,$value->action_time);
    }

    foreach($questionList as $key => $value){
        array_push($questionGuild,$value->guid);
    }

    //print_r($questionList);


}


//-----------兴趣分布--------------
if($type == 'int'){
    $tag_id = array();
    $tag_name = array();//存储每个链接的名字;
//    $link = array(); // 存储每个标签的链接;
    $tag_count = array();

//==============获取所有tag的id信息===============
    $tags = get_terms( 'post_tag', array_merge( array( 'orderby' => 'count', 'order' => 'DESC' )));
    //print_r($end);


//==============获取小组使用的tag的相关信息===============
    $sql = 'SELECT `wp_posts`.`ID`, COUNT(`wp_posts`.`ID`) as c FROM `wp_user_history` LEFT JOIN `wp_posts` ON `wp_user_history`.`action_post_id` = `wp_posts`.`ID` 
            LEFT JOIN `wp_gp_member` ON `wp_user_history`.`user_id`= `wp_gp_member`.`user_id`  
            WHERE `action_post_type`="post" AND `group_id` = "'. $group_id .'"AND `action_time` >= "' . date("Y-m-d 00:00:00", strtotime($start)) . '" AND `action_time` <= "' . date("Y-m-d 23:59:59", strtotime($end)) . '" 
            GROUP BY `wp_posts`.`ID` ORDER BY c DESC';
    $postID = $wpdb->get_results($sql);
    //print_r($postID);
    $tagGet = [];
    $tagID = [];
    $tagName = [];
    foreach ($postID as $value) {
        $info = get_the_terms($value->ID,'post_tag');
        //print_r($info);
        array_push($groupTag,$info);
        foreach ($info as $in){
            $tagGet[$in->name] += $value->c;
            array_push($tagID,$in->term_id);
            array_push($tagName,$in->name);
            //$groupTag[$in->name] = $in->term_id;
            }

    }
    $clearTI = array_unique($tagID);
    $clearTN = array_unique($tagName);

    $clearTagID = [];
    $clearTagName = [];

    foreach($clearTI as $key){
        array_push($clearTagID,$key);
    }

    foreach($clearTN as $key){
        array_push($clearTagName,$key);
    }

    //print_r($clearTN);

//=============================


//===================*获取浏览tag TOP10*================
    $viewTop10 = $wpdb->get_results('SELECT `post_title`, COUNT(`post_title`) as c FROM `wp_user_history` LEFT JOIN `wp_posts` ON `wp_user_history`.`action_post_id` = `wp_posts`.`ID` 
                                            LEFT JOIN `wp_gp_member` ON `wp_user_history`.`user_id`= `wp_gp_member`.`user_id`
                                            LEFT JOIN `wp_term_relationships` ON `wp_posts`.`ID` = `wp_term_relationships`.`object_id`
                                            LEFT  JOIN  `wp_term_taxonomy` ON `wp_term_taxonomy`.`term_taxonomy_id` = `wp_term_relationships`.`term_taxonomy_id`
                                            WHERE `action_post_type`="post" AND `post_title`!= "" AND `group_id` = "'. $group_id .'" AND `taxonomy` = "post_tag"
                                            AND `action_time` >= "' . date("Y-m-d 00:00:00", strtotime($start)) . '" AND `action_time` <= "' . date("Y-m-d 23:59:59", strtotime($end)) . '" 
                                            GROUP BY `post_title` ORDER BY c DESC LIMIT 10');
    //print_r($viewTop10);
//=============================

    foreach($tags as $key => $temp){
        $tag_id[]=$temp->term_id;
        $tag_name[]=$temp->name;
        $tag_count[]=$temp->count;
    }


    $tagArr =[];
    if($tagss == ''){
        for($i=0;$i<count($clearTagName);$i++){
            $tagArr[$i]=$clearTagID[$i].'_'.$clearTagName[$i];
        }
    }else{
        $tagArr=explode(",", $tagss);
    }
    $xData = [];
    foreach ($tagArr as $tag){
        $xData[]=explode("_", $tag)[1];
    }
    //print_r($xData);
    function getTagInfo($start,$end,$wpdb,$type,$xData,$group_id){
        $results=[];
        for ($i = 0; $i < ((strtotime($end) - strtotime($start)) / 86400 + 1); $i++) {
            $currentDate = date("Y-m-d", strtotime("$start +" . $i . " day"));
            $startTime = date("Y-m-d 00:00:00", strtotime($currentDate));
            $endTime = date("Y-m-d 23:59:59", strtotime($currentDate));
            $presult = $wpdb->get_results('SELECT `wp_posts`.`ID`, COUNT(`wp_posts`.`ID`) as c FROM `wp_user_history` LEFT JOIN `wp_posts` ON `wp_user_history`.`action_post_id` = `wp_posts`.`ID` 
                                           LEFT JOIN `wp_gp_member` ON `wp_user_history`.`user_id`= `wp_gp_member`.`user_id`  
                                           WHERE `action_post_type`="'.$type.'" AND `group_id` = "'. $group_id .'"AND `action_time` >= "' . $startTime . '" AND `action_time` <= "' . $endTime . '" GROUP BY `wp_posts`.`ID`');
            //print_r($presult);
            $newPresult=[];
            foreach ($presult as $value) {
                $info = get_the_terms($value->ID,$type.'_tag');
                //print_r($info);
                foreach ($info as $in){
                    $newPresult[$in->name] += $value->c;
//                    echo $in->term_id;
//                    echo $in->name;
                }
                //print_r($newPresult);
            }

            $newPresult2=[];
            foreach ($xData as $xd){
                $newPresult2[] = $newPresult[$xd]?$newPresult[$xd]:0;
            }
            $results[$currentDate]=$newPresult2;
        }
        return $results;

    }
    //print_r($group_id);
    $presults = getTagInfo($start,$end,$wpdb,'post',$xData,$group_id);
    //$qresults = getTagInfo($start,$end,$wpdb,'dwqa-question',$xData,$group_id);
    //print_r($presults);
}
?>

<style>
    .datepicker, #tags {
        border-radius: 4px;
        border: 1px solid #ccc;
    }

    #submit {
        width: 50px;
        height: 25px;
        cursor: pointer;
    }
    .button a {
        display: block;
        float: left;
        background: rgba(0, 0, 0, 0.1);
        color: #555;
        width: 50px;
        height: 25px;
        text-align: center;
        border: solid 1px #ccc;
        margin-right: 15px;
        border-radius: 5px;
        line-height: 25px;
        text-decoration: none;
    }
    .time{
        margin-top: 10px;
    }
    .time input {
        border: 1px solid #ccc;
    }
    .title{
        line-height: 26px;
        margin-right: 10px;
    }
    input[type=radio]{
        line-height: 26px;
        margin: 0 4px;
    }
    .chart_title {
        color: #fe642d;
    }
</style>
<link href="<?php bloginfo('stylesheet_directory') ?>/css/jquery-ui-1.9.2.custom.min.css" rel="stylesheet">
<script src="<?php bloginfo('stylesheet_directory') ?>/javascripts/jquery-1.8.3.js"></script>
<script src="<?php bloginfo('stylesheet_directory') ?>/javascripts/jquery-ui-1.9.2.custom.min.js"></script>
<script src="<?php bloginfo('stylesheet_directory') ?>/javascripts/datepicker-zh-CN.js"></script>
<!--页面内容 开始-->
<div class="col-md-9 col-sm-9 col-xs-12">
    <!--    学生管理导航栏 开始-->
    <div class="archive-nav">
        <ul id="leftTab" class="nav nav-tabs" style="float: left;height: 42px;">
            <li class="<?php echo $type == 'fre' ? 'active' : ''; ?>" id="project"><a
                    href="<?php echo esc_url(add_query_arg(array('type' => 'fre'), remove_query_arg(array('start', 'end', 'words', 'tags','memberID','separatePage','recordStart','recordEnd','pageNum')))); ?>">词条频度</a>
            </li>
            <li class="<?php echo $type == 'tra' ? 'active' : ''; ?>" id="project"><a
                    href="<?php echo esc_url(add_query_arg(array('type' => 'tra'), remove_query_arg(array('start', 'end', 'words', 'tags','memberID','separatePage','recordStart','recordEnd','pageNum')))); ?>">行为轨迹</a>
            </li>
            <li class="<?php echo $type == 'int' ? 'active' : ''; ?>" id="project"><a
                    href="<?php echo esc_url(add_query_arg(array('type' => 'int'), remove_query_arg(array('start', 'end', 'words', 'tags','memberID','separatePage','recordStart','recordEnd','pageNum')))); ?>">兴趣分布</a>
            </li>
        </ul>
    </div>
    <div style="height: 2px;background-color: lightgray"></div>
    <br>
    <!--    学生管理导航栏 结束-->

    <!--    词条频度 开始-->
    <?php if ($type == 'fre' || $type == '') { ?>
        <style>
            .nav_bar span {
                font-size: 24px;
                margin-right: 15px;
            }

            .search_bar {
                width: 40%;
            }

            .clearfix:after {
                content: "."; /* Older browser do not support empty content */
                visibility: hidden;
                display: block;
                height: 0;
                clear: both;

            }

            #search_table, #view_table {
                width: 50%;
                float: left;
            }

            table caption {
                color: #fe642d;
            }
        </style>
        <div>
            <label class="title">类别:</label>
            <a id="learningTrajectory"
               href="<?php echo esc_url(add_query_arg(array('type' => 'fre'), remove_query_arg(array('start', 'end', 'words', 'tags','memberID','separatePage')))); ?>">
                小组词频统计</a> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
            <a id="qaRecording"
               href="<?php echo esc_url(add_query_arg(array('type' => 'memberfre'), remove_query_arg(array('start', 'end', 'words', 'tags','memberID')))); ?>">成员词频统计</a>
        </div>

        <div>
            <p class="time">
                <label class="title" for="">开始时间:</label><input type="text" class="datepicker" id="datepicker1"/>
                <label class="title" for="">结束时间:</label><input type="text" class="datepicker" id="datepicker2"/>
            </p>
            <p class="button clearfix">
                <a id="submit">提交</a>
                <a href="<?php echo esc_url(add_query_arg(array(), remove_query_arg(array('start', 'end', 'words')))); ?>">默认</a>
            </p>
            <table class="table" id="view_table">
                <caption>浏览词条TOP10</caption>
                <tbody>
                <?php foreach ($viewTop10 as $key => $value) { ?>
                    <tr>
                        <td style="width:70%"><?php echo $value->post_title; ?></td>
                        <td><?php echo $value->c; ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <table class="table" id="search_table">
                <caption>搜索词条TOP10</caption>
                <tbody>
                <?php foreach ($searchTop10 as $key => $value) { ?>
                    <tr>
                        <td><?php echo $value->words; ?></td>
                        <td><?php echo $value->c; ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <div style="width: 100%;clear: both;">
                <div class="chart_title">浏览词条TOP10</div>
                <div id="view_chart" style="width:60vw;height:30vw;right:100px;"></div>
                <br>
                <!-- 饼状图测试 -->
                <div class="chart_title">浏览词条TOP10比例</div>
                <div id="view_chart2" style="width:60vw;height:30vw;right:100px;"></div>
                <br>
                <!-- 饼状图测试结束 -->
                <div class="chart_title">搜索词条TOP10</div>
                <div id="search_chart" style="width:60vw;height:30vw;right:100px;"></div>
            </div>
        </div>

        <script>
            $(function () {
                $("#submit").click(function () {
                    var start = $("#datepicker1").datepicker("getDate");
                    var end = $("#datepicker2").datepicker("getDate");

                    if(end==null && start == null){
                        alert("请选择一个时间段");
                    }
                    if (end == null && start != null) {
                        //end = new Date().toLocaleDateString()
                        end = new Date(Date.parse(start) + 3600 * 1000 * 24 * 6).toLocaleDateString();
                    } else {
                        end = end.toLocaleDateString();
                    }

                    if (start == null && end != null) {
                         start = new Date(Date.parse(end) - 3600 * 1000 * 24 * 6).toLocaleDateString();
                    } else {
                        start = start.toLocaleDateString();
                    }
                    var current_url = '<?php echo esc_url(add_query_arg(array(), remove_query_arg(array('start', 'end', 'words', 'type')))); ?>';
                    console.info(current_url);
                    var words = $('#tags').val();
                    var clearCurrent_url = current_url.replace(/#038;/g,'');
                    console.info(clearCurrent_url);
                    location.href = clearCurrent_url + '\&type=fre' + '\&start=' + start + '\&end=' + end;


                })
                $("#datepicker1").datepicker({
                    maxDate: "+0D",
                    numberOfMonths: 2,
                    onSelect: function (startDate) {
                        var $startDate = $("#datepicker1");
                        var $endDate = $('#datepicker2');
                        $endDate.datepicker('option', 'maxDate', (new Date(Math.min(Date.parse(startDate) + 3600 * 1000 * 24 * 30, Date.parse(new Date())))));
                        $endDate.datepicker('option', 'minDate', startDate)
                    }
                });
                $("#datepicker2").datepicker({
                    maxDate: "+0D",
                    numberOfMonths: 2,
                    onSelect: function (endDate) {
                        var $startDate = $("#datepicker1");
                        var $endDate = $('#datepicker2');
                        $startDate.datepicker('option', 'minDate', new Date(Date.parse(endDate) - 3600 * 1000 * 24 * 30));
                        $startDate.datepicker('option', 'maxDate', endDate)
                    }
                })



                var item_view = [];

                var item_search = [];
                var search_datas = [];
                <?php foreach ($searchTop10 as $key=>$value){ ?>
                var da = [];
                <?php foreach ($results as $index=>$item){ ?>
                var num = '<?php echo $item[$value->words]; ?>';
                da.push(num == '' ? 0 : num)
                <?php } ?>
                item_search.push('<?php echo $value->words; ?>')
                search_datas.push(da);
                <?php } ?>


                var syData = [];
                for (var i = 0; i < item_search.length; i++) {
                    syData.push({
                        name: item_search[i],
                        type: 'line',
//                stack: '总量',
                        data: search_datas[i]
                    })
                }
                var view_datas = [];
                var viewCount=[];//储存饼状图计数数据
                <?php foreach ($viewTop10 as $key=>$value){ ?>
                var dav = [];
                <?php foreach ($vresults as $index=>$item){ ?>
                var num = '<?php echo $item[$value->post_title]; ?>';
                dav.push(num == '' ? 0 : num)
                <?php } ?>
                item_view.push('<?php echo $value->post_title; ?>')
                //饼状图计数测试
                viewCount.push('<?php echo $value->c; ?>')
                //饼状图计数测试
                view_datas.push(dav);
                <?php } ?>
                //console.log(view_datas);

                var vyData = [];
                for (var i = 0; i < view_datas.length; i++) {
                    vyData.push({
                        name: item_view[i],
                        type: 'line',
                        data: view_datas[i]
                    })
                }



                //饼状图数据存储
                var pieData = [];
                for(var i = 0; i < view_datas.length;i++){
                    pieData.push({
                        name:item_view[i],
                        value:viewCount[i]
                        }

                    )
                }







                var myChart1 = echarts.init(document.getElementById('view_chart'));
                var myChart2 = echarts.init(document.getElementById('search_chart'));
                var myChart3 = echarts.init(document.getElementById('view_chart2'));
                var xData = [];


                <!--测试饼状图 -->
                option = {
                    title : {
                        text: '',
                        subtext: '',
                        x:'center'
                    },
                    tooltip : {
                        trigger: 'item',
                        formatter: "{a} <br/>{b} : {c} ({d}%)"
                    },
                    legend: {
                        orient: 'vertical',
                        left: 'left',
                        data: item_view
                    },
                    series : [
                        {
                            name: '访问来源',
                            type: 'pie',
                            radius : '55%',
                            center: ['50%', '60%'],
                            data:pieData,
                            itemStyle: {
                                emphasis: {
                                    shadowBlur: 10,
                                    shadowOffsetX: 0,
                                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                                }
                            }
                        }
                    ]
                };
                ;myChart3.setOption(option, true);
                <!-- 测试饼状图结束 -->

                <?php foreach ($xData as $value){ ?>
                xData.push('<?php echo $value; ?>');
                <?php } ?>
                console.info(vyData);
                myChart1.setOption({
                    title: {
//                text: '浏览词条TOP10'
                    },
                    tooltip: {
                        trigger: 'axis'
                    },
                    legend: {
                        data: item_view
                    },
                    grid: {
                        left: '3%',
                        right: '4%',
                        bottom: '3%',
                        containLabel: true
                    },
                    xAxis: {
                        type: 'category',
                        boundaryGap: false,
                        data: xData
                    },
                    yAxis: {
                        type: 'value'
                    },
                    series: vyData
                });
                myChart2.setOption({
                    title: {
//                text: '搜索词条TOP10'
                    },
                    tooltip: {
                        trigger: 'axis'
                    },
                    legend: {
                        data: item_search
                    },
                    grid: {
                        left: '3%',
                        right: '4%',
                        bottom: '3%',
                        containLabel: true
                    },
                    xAxis: {
                        type: 'category',
                        boundaryGap: false,
                        data: xData
                    },
                    yAxis: {
                        type: 'value'
                    },
                    series: syData
                })

                console.log('--------');
                console.log(pieData);
                console.log('--------');


            });
        </script>
    <?php } ?>
    <!--    词条频度 结束-->

    <!--    成员词频统计 -->
    <?php if ($type =='memberfre'){?>
        <style>
            .nav_bar span {
                font-size: 24px;
                margin-right: 15px;
            }

            .search_bar {
                width: 40%;
            }

            .clearfix:after {
                content: "."; /* Older browser do not support empty content */
                visibility: hidden;
                display: block;
                height: 0;
                clear: both;

            }

            #search_table, #view_table {
                width: 50%;
                float: left;
            }

            table caption {
                color: #fe642d;
            }
            .dropdown{
                width: 200px;
            }
            .dropdown .btn-dropdown {
                width: 160px;
                height: 26px;
                padding: 0;
                margin-right: -5px;
                /*border-left: 0;*/
                border-right: 0;
                border-radius: 0;
                border-top-left-radius: 4px;
                border-bottom-left-radius: 4px;
            }
            .dropdown .dropdown-toggle {
                height: 26px;
                width: 40px;
                border-bottom-left-radius: 0;
                border-top-left-radius: 0;
                color: #333;
                background-color: #d4d4d4;
                border-color: #8c8c8c;
            }
            .open>.dropdown-toggle.btn-default:focus, .open>.dropdown-toggle.btn-default:hover {
                color: #333;
                background-color: #d4d4d4;
                border-color: #8c8c8c;
            }
            .dropdown .dropdown-menu {
                padding: 0;
                width: 100%;
                left: 0;
            }
            .dropdown .dropdown-menu li {
                height: 30px;
                line-height: 30px;
                text-align: center;
            }
            .dropdown .dropdown-menu li :hover {
                background-color: #0096ff;
            }
            .dropdown .dropdown-menu li a {
                padding: 0;
                line-height: 30px;
            }
            .group, .user{
                display: flex;
                margin-top: 10px;
            }
        </style>
        <div>
            <label class="title">类别:</label>
            <a id="learningTrajectory"
               href="<?php echo esc_url(add_query_arg(array('type' => 'fre'), remove_query_arg(array('start', 'end', 'words', 'tags','memberID','separatePage')))); ?>">
                小组词频统计</a> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
            <a id="qaRecording"
               href="<?php echo esc_url(add_query_arg(array('type' => 'memberfre'), remove_query_arg(array('start', 'end', 'words', 'tags','memberID')))); ?>">成员词频统计</a>
        </div>
        <div class="user">
            <label class="title">成员:</label>
            <div class="dropdown">
                <button type="button" class="btn btn-default btn-dropdown">
                    <span>请选择成员</span></button>
                <button type="button" class="btn btn-default dropdown-toggle"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu">
                    <!--下拉框动态显示小组成员-->
                    <?php foreach ($group_member as$key => $value){?>
                        <li><a href="javascript:void(0)" data-id=<?php echo $value->user_id?>><?php echo $value->user_login?></a></li>
                    <?php }?>
                </ul>
            </div>
        </div>

        <div>
            <p class="time">
                <label class="title" for="">开始时间:</label><input type="text" class="datepicker" id="datepicker1"/>
                <label class="title" for="">结束时间:</label><input type="text" class="datepicker" id="datepicker2"/>
            </p>
            <p class="button clearfix">
                <a id="submit">提交</a>
                <a href="<?php echo esc_url(add_query_arg(array(), remove_query_arg(array('start', 'end', 'words','memberID')))); ?>">默认</a>
            </p>

            <p style="color: #fe642d;font-size: medium"><?php echo $chosenPerson[0]?>的统计记录:</p>

            <table class="table" id="view_table">
                <caption>浏览词条TOP10</caption>
                <tbody>
                <?php foreach ($viewTop10 as $key => $value) { ?>
                    <tr>
                        <td style="width: 70%"><?php echo $value->post_title; ?></td>
                        <td><?php echo $value->c; ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <table class="table" id="search_table">
                <caption>搜索词条TOP10</caption>
                <tbody>
                <?php foreach ($searchTop10 as $key => $value) { ?>
                    <tr>
                        <td><?php echo $value->words; ?></td>
                        <td><?php echo $value->c; ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <div style="width: 100%;clear: both;">
                <div class="chart_title">浏览词条TOP10</div>
                <div id="view_chart" style="width:60vw;height:30vw;right:100px;"></div>
                <br>
                <!-- 饼状图测试 -->
                <div class="chart_title">浏览词条TOP10比例</div>
                <div id="view_chart2" style="width:60vw;height:30vw;right:100px;"></div>
                <br>
                <!-- 饼状图测试结束 -->
                <div class="chart_title">搜索词条TOP10</div>
                <div id="search_chart" style="width:60vw;height:30vw;right:100px;"></div>
            </div>
        </div>

        <script>
            var memberID = '';
            var text;

            //下拉框
            $(".dropdown").delegate("ul li a","click",function(){
                text=$(this).text();
                memberID=$(this).attr("data-id");
                var parent=$(this).parents(".dropdown");
                parent.find("span").eq(0).text(text);
                parent.attr("data-id",memberID);
                console.log(memberID);
                $(this).parents(".form-group").nextAll(".prize_input_box").each(function(){
                    if($(this).index()<=parseInt(memberID)){
                        $(this).show();
                        console.log("v");
                    }else{
                        $(this).hide();
                    }
                });
            });

            $(function () {
                $("#submit").click(function () {
                    var start = $("#datepicker1").datepicker("getDate");
                    var end = $("#datepicker2").datepicker("getDate");

                    if(end==null && start == null){
                        alert("请选择一个时间段");
                    }
                    if (end == null && start != null) {
                        //end = new Date().toLocaleDateString()
                        end = new Date(Date.parse(start) + 3600 * 1000 * 24 * 6).toLocaleDateString();
                    } else {
                        end = end.toLocaleDateString();
                    }

                    if (start == null && end != null) {
                        start = new Date(Date.parse(end) - 3600 * 1000 * 24 * 6).toLocaleDateString();
                    } else {
                        start = start.toLocaleDateString();
                    }
                    var current_url = '<?php echo esc_url(add_query_arg(array(), remove_query_arg(array('start', 'end', 'words', 'type','memberID')))); ?>';
                    console.info(current_url);
                    var clearCurrent_url = current_url.replace(/#038;/g,'');
                    console.info(clearCurrent_url);
                    location.href = clearCurrent_url + '\&type=memberfre' + '\&start=' + start + '\&end=' + end + '\&memberID='+ memberID;

                })
                $("#datepicker1").datepicker({
                    maxDate: "+0D",
                    numberOfMonths: 2,
                    onSelect: function (startDate) {
                        var $startDate = $("#datepicker1");
                        var $endDate = $('#datepicker2');
                        $endDate.datepicker('option', 'maxDate', (new Date(Math.min(Date.parse(startDate) + 3600 * 1000 * 24 * 30, Date.parse(new Date())))));
                        $endDate.datepicker('option', 'minDate', startDate)
                    }
                });
                $("#datepicker2").datepicker({
                    maxDate: "+0D",
                    numberOfMonths: 2,
                    onSelect: function (endDate) {
                        var $startDate = $("#datepicker1");
                        var $endDate = $('#datepicker2');
                        $startDate.datepicker('option', 'minDate', new Date(Date.parse(endDate) - 3600 * 1000 * 24 * 30));
                        $startDate.datepicker('option', 'maxDate', endDate)
                    }
                })



                var item_view = [];

                var item_search = [];
                var search_datas = [];
                <?php foreach ($searchTop10 as $key=>$value){ ?>
                var da = [];
                <?php foreach ($results as $index=>$item){ ?>
                var num = '<?php echo $item[$value->words]; ?>';
                da.push(num == '' ? 0 : num)
                <?php } ?>
                item_search.push('<?php echo $value->words; ?>')
                search_datas.push(da);
                <?php } ?>


                var syData = [];
                for (var i = 0; i < item_search.length; i++) {
                    syData.push({
                        name: item_search[i],
                        type: 'line',
//                stack: '总量',
                        data: search_datas[i]
                    })
                }
                var view_datas = [];
                var viewCount=[];//储存饼状图计数数据
                <?php foreach ($viewTop10 as $key=>$value){ ?>
                var dav = [];
                <?php foreach ($vresults as $index=>$item){ ?>
                var num = '<?php echo $item[$value->post_title]; ?>';
                dav.push(num == '' ? 0 : num)
                <?php } ?>
                item_view.push('<?php echo $value->post_title; ?>')
                //饼状图计数测试
                viewCount.push('<?php echo $value->c; ?>')
                //饼状图计数测试
                view_datas.push(dav);
                <?php } ?>
                //console.log(view_datas);

                var vyData = [];
                for (var i = 0; i < view_datas.length; i++) {
                    vyData.push({
                        name: item_view[i],
                        type: 'line',
                        data: view_datas[i]
                    })
                }



                //饼状图数据存储
                var pieData = [];
                for(var i = 0; i < view_datas.length;i++){
                    pieData.push({
                            name:item_view[i],
                            value:viewCount[i]
                        }

                    )
                }







                var myChart1 = echarts.init(document.getElementById('view_chart'));
                var myChart2 = echarts.init(document.getElementById('search_chart'));
                var myChart3 = echarts.init(document.getElementById('view_chart2'));
                var xData = [];


                <!--测试饼状图 -->
                option = {
                    title : {
                        text: '',
                        subtext: '',
                        x:'center'
                    },
                    tooltip : {
                        trigger: 'item',
                        formatter: "{a} <br/>{b} : {c} ({d}%)"
                    },
                    legend: {
                        orient: 'vertical',
                        left: 'left',
                        data: item_view
                    },
                    series : [
                        {
                            name: '访问来源',
                            type: 'pie',
                            radius : '55%',
                            center: ['50%', '60%'],
                            data:pieData,
                            itemStyle: {
                                emphasis: {
                                    shadowBlur: 10,
                                    shadowOffsetX: 0,
                                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                                }
                            }
                        }
                    ]
                };
                ;myChart3.setOption(option, true);
                <!-- 测试饼状图结束 -->

                <?php foreach ($xData as $value){ ?>
                xData.push('<?php echo $value; ?>');
                <?php } ?>
                console.info(vyData);
                myChart1.setOption({
                    title: {
//                text: '浏览词条TOP10'
                    },
                    tooltip: {
                        trigger: 'axis'
                    },
                    legend: {
                        data: item_view
                    },
                    grid: {
                        left: '3%',
                        right: '4%',
                        bottom: '3%',
                        containLabel: true
                    },
                    xAxis: {
                        type: 'category',
                        boundaryGap: false,
                        data: xData
                    },
                    yAxis: {
                        type: 'value'
                    },
                    series: vyData
                });
                myChart2.setOption({
                    title: {
//                text: '搜索词条TOP10'
                    },
                    tooltip: {
                        trigger: 'axis'
                    },
                    legend: {
                        data: item_search
                    },
                    grid: {
                        left: '3%',
                        right: '4%',
                        bottom: '3%',
                        containLabel: true
                    },
                    xAxis: {
                        type: 'category',
                        boundaryGap: false,
                        data: xData
                    },
                    yAxis: {
                        type: 'value'
                    },
                    series: syData
                })

                console.log('--------');
                console.log(pieData);
                console.log('--------');


            });
        </script>
    <?php }?>
    <!--   成员词频统计结束   -->

    <!--    行为轨迹 开始-->
    <?php if ($type == 'tra' && $separatePage == null) { ?>
        <style>
            /*行为轨迹*/
            *, *:after, *:before {
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
            }

            .cd-timeline-content h2 {
                text-align: center;

            }

            .cd-timeline-content .cd-date {
                float: left;
                padding: .8em 0;
                opacity: .7;
                position: absolute;
                width: 100%;
                left: 150%;
                top: 5px;
                font-size: 1rem;
            }


            .dropdown{
                width: 200px;
            }
            .dropdown .btn-dropdown {
                width: 160px;
                height: 26px;
                padding: 0;
                margin-right: -5px;
                /*border-left: 0;*/
                border-right: 0;
                border-radius: 0;
                border-top-left-radius: 4px;
                border-bottom-left-radius: 4px;
            }
            .dropdown .dropdown-toggle {
                height: 26px;
                width: 40px;
                border-bottom-left-radius: 0;
                border-top-left-radius: 0;
                color: #333;
                background-color: #d4d4d4;
                border-color: #8c8c8c;
            }
            .open>.dropdown-toggle.btn-default:focus, .open>.dropdown-toggle.btn-default:hover {
                color: #333;
                background-color: #d4d4d4;
                border-color: #8c8c8c;
            }
            .dropdown .dropdown-menu {
                padding: 0;
                width: 100%;
                left: 0;
            }
            .dropdown .dropdown-menu li {
                height: 30px;
                line-height: 30px;
                text-align: center;
            }
            .dropdown .dropdown-menu li :hover {
                background-color: #0096ff;
            }
            .dropdown .dropdown-menu li a {
                padding: 0;
                line-height: 30px;
            }
            .group, .user{
                display: flex;
                margin-top: 10px;
            }

        </style>

        <div>
            <label class="title">类别:</label>
            <a id="learningTrajectory"
               href="<?php echo esc_url(add_query_arg(array('type' => 'tra'), remove_query_arg(array('start', 'end', 'words', 'tags','memberID','separatePage')))); ?>">
                学习轨迹（默认页面）</a> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
            <a id="qaRecording"
               href="<?php echo esc_url(add_query_arg(array('type' => 'tra','separatePage' => 'openRecord'), remove_query_arg(array('start', 'end', 'words', 'tags','memberID')))); ?>">问答记录</a>
        </div>
        <!--<div class="group">
            <label class="title">小组:</label>
            <div class="dropdown">
                <button type="button" class="btn btn-default btn-dropdown">
                    <span>请选择小组</span></button>
                <button type="button" class="btn btn-default dropdown-toggle"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="javascript:void(0)" data-id="1">1个等级</a></li>
                    <li><a href="javascript:void(0)" data-id="2">2个等级</a></li>
                    <li><a href="javascript:void(0)" data-id="3">3个等级</a></li>
                    <li><a href="javascript:void(0)" data-id="10">10个等级</a></li>
                </ul>
            </div>
            <input type="radio" name="group">全部小组
            <input type="radio" name="group">最活跃小组
            <input type="radio" name="group">最受挫小组
        </div>-->
        <div class="user">
            <label class="title">成员:</label>
            <div class="dropdown">
                <button type="button" class="btn btn-default btn-dropdown">
                    <span>请选择成员</span></button>
                <button type="button" class="btn btn-default dropdown-toggle"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu">
                    <!--下拉框动态显示小组成员-->
                    <?php foreach ($group_member as$key => $value){?>
                        <li><a href="javascript:void(0)" data-id=<?php echo $value->user_id?>><?php echo $value->user_login?></a></li>
                    <?php }?>
                </ul>
            </div>
        </div>
        <p class="time">
            <label class="title" for="">开始时间:</label><input type="text" class="datepicker" id="datepicker3"/>
            <label class="title" for="">结束时间:</label><input type="text" class="datepicker" id="datepicker4"/></p>
        <p class="button clearfix">
            <a id="submit">提交</a>
            <a href="<?php echo esc_url(add_query_arg(array(), remove_query_arg(array('start', 'end', 'words','tags','memberID')))); ?>">默认</a>
        </p>

        <div style="width: 100%;clear: both;">
            <div class="chart_title">小组学习轨迹</div>
            <div id="path_chart" style="width:60vw;height:30vw;right:85px;"></div>
        </div>

        <div style="width: 100%;clear: both;">
            <div class="chart_title"><?php echo $chosenPerson[0]?> 学习轨迹</div>
            <div id="personal_path_chart" style="width:60vw;height:30vw;right:85px;"></div>
        </div>




        <script>
            $(function () {

                var memberID = '';
                var text;



               //下拉框
               $(".dropdown").delegate("ul li a","click",function(){
                    text=$(this).text();
                    memberID=$(this).attr("data-id");
                    var parent=$(this).parents(".dropdown");
                    parent.find("span").eq(0).text(text);
                    parent.attr("data-id",memberID);
                    console.log(memberID);
                    $(this).parents(".form-group").nextAll(".prize_input_box").each(function(){
                        if($(this).index()<=parseInt(memberID)){
                            $(this).show();
                            console.log("v");
                        }else{
                            $(this).hide();
                        }
                    });
                });


                $("#submit").click(function () {
                    var start = $("#datepicker3").datepicker("getDate");
                    var end = $("#datepicker4").datepicker("getDate");

                    if(end==null && start == null){
                        alert("请选择一个时间段");
                    }

                    if (end == null && start != null) {
                        //end = new Date().toLocaleDateString()
                        end = new Date(Date.parse(start) + 3600 * 1000 * 24 * 6).toLocaleDateString();
                    } else {
                        end = end.toLocaleDateString();
                    }

                    if (start == null && end != null) {
                        start = new Date(Date.parse(end) - 3600 * 1000 * 24 * 6).toLocaleDateString();
                    } else {
                        start = start.toLocaleDateString();
                    }


                    console.log(end);
                    var current_url = '<?php echo esc_url(add_query_arg(array(), remove_query_arg(array('start', 'end', 'words', 'type')))); ?>';
                    console.info(current_url);
                    var clearCurrent_url = current_url.replace(/#038;/g,'');
                    console.info(clearCurrent_url);
                    location.href = clearCurrent_url + '\&type=tra' + '\&start=' + start + '\&end=' + end + '\&memberID='+ memberID;



                });



                $("#datepicker3").datepicker({
                    maxDate: "+0D",
                    numberOfMonths: 2,
                    onSelect: function (startDate) {
                        var $startDate = $("#datepicker3");
                        var $endDate = $('#datepicker4');
                        $endDate.datepicker('option', 'maxDate', (new Date(Math.min(Date.parse(startDate) + 3600 * 1000 * 24 * 30, Date.parse(new Date())))));
                        $endDate.datepicker('option', 'minDate', startDate)
                    }
                });
                $("#datepicker4").datepicker({
                    maxDate: "+0D",
                    numberOfMonths: 2,
                    onSelect: function (endDate) {
                        var $startDate = $("#datepicker3");
                        var $endDate = $('#datepicker4');
                        $startDate.datepicker('option', 'minDate', new Date(Date.parse(endDate) - 3600 * 1000 * 24 * 30));
                        $startDate.datepicker('option', 'maxDate', endDate)
                    }
                })


                var node_Name = [];
                var node_Value = [];

                <?php foreach ($trackResult as $key=>$item){?>
                <?php foreach ($item as $k => $value){?>
                node_Name.push('<?php echo $value->post_title; ?>');
                node_Value.push('<?php echo $value->c; ?>')
                <?php }?>
                <?php } ?>

                var personal_node_Name = [];
                var personal_node_Value = [];

                <?php foreach ($memberResult as $key=>$item){?>
                <?php foreach ($item as $k => $value){?>
                personal_node_Name.push('<?php echo $value->post_title; ?>');
                personal_node_Value.push('<?php echo $value->c; ?>')
                <?php }?>
                <?php } ?>



                var myChart5 = echarts.init(document.getElementById('path_chart'));
                var myChart6 = echarts.init(document.getElementById('personal_path_chart'));

                var axisData = node_Name;
                var data = node_Value;

                console.info(node_Name);
                console.info(node_Value);
                var links = data.map(function (item, i) {
                    return {
                        source: i,
                        target: i + 1
                    };
                });
                links.pop();


                option = {
                    title: {
                        text: ''
                    },
                    tooltip: {},
                    xAxis: {
                        type : 'category',
                        boundaryGap : false,
                        data : axisData
                    },
                    yAxis: {
                        type : 'value'
                    },
                    series: [
                        {
                            type: 'graph',
                            layout: 'none',
                            coordinateSystem: 'cartesian2d',
                            symbolSize: 40,
                            label: {
                                normal: {
                                    show: true
                                }
                            },
                            edgeSymbol: ['circle', 'arrow'],
                            edgeSymbolSize: [4, 10],
                            data: data,
                            links: links,
                            lineStyle: {
                                normal: {
                                    color: '#2f4554'
                                }
                            }
                        }
                    ]
                };;
                if (option && typeof option === "object") {
                    myChart5.setOption(option, true);
                }


                //个人学习轨迹
                var data1 = personal_node_Value;
                var axisData1 = personal_node_Name;

                var links = data.map(function (item, i) {
                    return {
                        source: i,
                        target: i + 1
                    };
                });
                links.pop();


                option = {
                    title: {
                        text: ''
                    },
                    tooltip: {},
                    xAxis: {
                        type : 'category',
                        boundaryGap : false,
                        data : axisData1
                    },
                    yAxis: {
                        type : 'value'
                    },
                    series: [
                        {
                            type: 'graph',
                            layout: 'none',
                            coordinateSystem: 'cartesian2d',
                            symbolSize: 40,
                            label: {
                                normal: {
                                    show: true
                                }
                            },
                            edgeSymbol: ['circle', 'arrow'],
                            edgeSymbolSize: [4, 10],
                            data: data1,
                            links: links,
                            lineStyle: {
                                normal: {
                                    color: '#2f4554'
                                }
                            }
                        }
                    ]
                };;
                if (option && typeof option === "object") {
                    myChart6.setOption(option, true);
                }
            })
        </script>

    <?php } ?>
    <!--    行为轨迹 结束-->


    <!--问答记录页面-->
    <?php if ($type == 'tra' && $separatePage == 'openRecord'){?>
        <div>
            <label class="title">类别:</label>
            <a id="learningTrajectory"
               href="<?php echo esc_url(add_query_arg(array('type' => 'tra'), remove_query_arg(array('start', 'end', 'words', 'tags','memberID','separatePage','pageNum','recordStart','recordEnd')))); ?>">
                学习轨迹（默认页面）</a> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
            <a id="qaRecording"
               href="<?php echo esc_url(add_query_arg(array('type' => 'tra','separatePage' => 'openRecord'), remove_query_arg(array('start', 'end', 'words', 'tags','memberID')))); ?>">问答记录</a>
        </div>
        <p class="time">
            <label class="title" for="">开始时间:</label><input type="text" class="datepicker" id="datepicker7"/>
            <label class="title" for="">结束时间:</label><input type="text" class="datepicker" id="datepicker8"/></p>
        <p class="button clearfix">
            <a id="submit">提交</a>
            <a href="<?php echo esc_url(add_query_arg(array(), remove_query_arg(array('start', 'end', 'words','tags','memberID','recordStart','recordEnd','pageNum')))); ?>">默认</a>
        </p>
        <br>
        <br>

        <div>
            <p style="color:#fe642d;font-size: 20px" >本组参与的问题：</p>
            <br><hr>
        </div>
        <div>
            <?php if(count($questionName)<10){?><?php for($i=0; $i<count($questionName);$i++){?>
            <?php $k = $i + 1;
            $p = $pageNum+1;?>
            <a href ="<?php echo $questionGuild[$i]?>"><p style="font-size: 16px"><?php echo $pageNum,$k,".","\r\r\r",$questionName[$i]?></p><a/>
                <br>
                <p style="text-align: right;">浏览次数：<?php echo $questionViewTimes[$i]?><!--&nbsp &nbsp&nbsp &nbsp最后浏览时间：--><?php /*echo $lastViewTime[$i]*/?></p>
                <hr>
                <?php }?><?php }?>
            <?php if(count($questionName)==10){?>
                <?php for($i=0; $i<count($questionName)-1;$i++){?>
                <?php $k = $i + 1;
                $p = $pageNum+1;?>
                <a href ="<?php echo $questionGuild[$i]?>"><p style="font-size: 16px"><?php echo $pageNum,$k,".","\r\r\r",$questionName[$i]?></p><a/>
                    <br>
                    <p style="text-align: right;">浏览次数：<?php echo $questionViewTimes[$i]?><!--&nbsp &nbsp&nbsp &nbsp最后浏览时间：--><?php /*echo $lastViewTime[$i]*/?></p>
                    <hr>
                    <?php }?>
                    <a href ="<?php echo $questionGuild[$i]?>"><p style="font-size: 16px"><?php echo $p,"0",".","\r\r\r",$questionName[$i]?></p><a/>
                        <br>
                        <p style="text-align: right;">浏览次数：<?php echo $questionViewTimes[$i]?><!--&nbsp &nbsp&nbsp &nbsp最后浏览时间：--><?php /*echo $lastViewTime[$i]*/?></p>
                        <hr>
           <?php }?>
        </div>
        <!-翻页->
        <div>
            <?php for($j = 0;$j<$pageCount;$j++){?>
                <a style="font-size: 18px" href="<?php echo esc_url(add_query_arg(array('type' => 'tra','separatePage' => 'openRecord', 'pageNum' => $j), remove_query_arg(array('start', 'end', 'words', 'tags','memberID')))); ?>">
                    <?php $k = $j + 1;
                    echo $k;?></a>
            <?php }?>
        </div>
        <!-翻页结束->


        <script>
            $("#submit").click(function () {
                var start = $("#datepicker7").datepicker("getDate");
                var end = $("#datepicker8").datepicker("getDate");

                if(end==null && start == null){
                    alert("请选择一个时间段");
                }

                if (end == null && start != null) {
                    //end = new Date().toLocaleDateString()
                    end = new Date(Date.parse(start) + 3600 * 1000 * 24 * 6).toLocaleDateString();
                } else {
                    end = end.toLocaleDateString();
                }

                if (start == null && end != null) {
                    start = new Date(Date.parse(end) - 3600 * 1000 * 24 * 6).toLocaleDateString();
                } else {
                    start = start.toLocaleDateString();
                }


                console.log(end);
                var current_url = '<?php echo esc_url(add_query_arg(array(), remove_query_arg(array('start', 'end', 'words', 'type','recordStart','recordEnd','separatePage','pageNum')))); ?>';
                console.info(current_url);
                var clearCurrent_url = current_url.replace(/#038;/g,'');
                console.info(clearCurrent_url);
                location.href = clearCurrent_url + '\&type=tra' + '\&separatePage=openRecord'+ '\&recordStart=' + start + '\&recordEnd=' + end;




            });



            $("#datepicker7").datepicker({
                maxDate: "+0D",
                numberOfMonths: 2,
                onSelect: function (startDate) {
                    var $startDate = $("#datepicker7");
                    var $endDate = $('#datepicker8');
                    $endDate.datepicker('option', 'maxDate', (new Date(Math.min(Date.parse(startDate) + 3600 * 1000 * 24 * 30, Date.parse(new Date())))));
                    $endDate.datepicker('option', 'minDate', startDate)
                }
            });
            $("#datepicker8").datepicker({
                maxDate: "+0D",
                numberOfMonths: 2,
                onSelect: function (endDate) {
                    var $startDate = $("#datepicker7");
                    var $endDate = $('#datepicker8');
                    $startDate.datepicker('option', 'minDate', new Date(Date.parse(endDate) - 3600 * 1000 * 24 * 30));
                    $startDate.datepicker('option', 'maxDate', endDate)
                }
            })


        </script>


    <?php }?>
    <!--问答记录页面页数-->

    <!--    兴趣分布 开始-->
    <?php if ($type == 'int') { ?>
        <style>
            /*兴趣分布*/
            .main1 {
                width: 700px;
                height: 500px;
                float: left;
            }

            .main2 {
                width: 700px;
                height: 500px;
                float: left;
            }
        </style>
        <div>
            <label class="title" for="">自选标签(小组用户参与的标签):</label>
            <div id="all_tags" style="word-wrap: break-word; word-break: keep-all;">
<!--                --><?php
//                foreach ($tag_name as $key =>$i){?>
<!--                    <input type="checkbox" name="tags" value="--><?//=$tag_id[$key]?><!--_--><?//=$i?><!--">--><?//=$i?><!--<span class="badge">(--><?//=$tag_count[$key]?><!--)</span>-->
<!--                --><?php //}
//                ?>
                <?php
                for ($i = 0; $i< count($clearTagID); $i++){?>
                <input type="checkbox" name="tags" value="<?=$clearTagID[$i]?>_<?=$clearTagName[$i]?>"><?=$clearTagName[$i]?>
                <?php }
                ?>
            </div>
        </div>
        <p class="time">
            <label class="title" for="">开始时间:</label><input type="text" class="datepicker" id="datepicker5"/>
            <label class="title" for="">结束时间:</label><input type="text" class="datepicker" id="datepicker6"/>
        </p>
        <p class="button clearfix">
            <a id="submit">提交</a>
            <a href="<?php echo esc_url(add_query_arg(array(), remove_query_arg(array('start', 'end', 'words','tags')))); ?>">默认</a>
        </p>
        <div style="width: 100%;clear: both;">
            <div class="chart_title">项目标签</div>
            <div id="project_tag" style="width:60vw;height:30vw;right: 100px;"></div>
            <br>
<!--            <div class="chart_title">问答标签</div>-->
<!--            <div id="qa_tag" style="width:60vw;height:30vw;"></div>-->
            <div class="chart_title">浏览项目TOP10比例</div>
            <div id="pie_chart" style="width:60vw;height:30vw;right: 50px"></div>
        </div>
        <script>
            $(function () {
                $("#submit").click(function () {
                    var chk_value =[];
                    $('input[name="tags"]:checked').each(function(){
                        chk_value.push($(this).val());
                    });
                    var start = $("#datepicker5").datepicker("getDate");
                    var end = $("#datepicker6").datepicker("getDate");
                    if(end==null && start == null){
                        alert("请选择一个时间段");
                    }

                    if (end == null && start != null) {
                        //end = new Date().toLocaleDateString()
                        end = new Date(Date.parse(start) + 3600 * 1000 * 24 * 6).toLocaleDateString();
                    } else {
                        end = end.toLocaleDateString();
                    }

                    if (start == null && end != null) {
                        start = new Date(Date.parse(end) - 3600 * 1000 * 24 * 6).toLocaleDateString();
                    } else {
                        start = start.toLocaleDateString();
                    }
                    $tags=chk_value.join(',');
                    var current_url = '<?php echo esc_url(add_query_arg(array(), remove_query_arg(array('start', 'end', 'tags', 'type')))); ?>';
                    var clearCurrent_url = current_url.replace(/#038;/g,'');
                    console.info(clearCurrent_url);
                    location.href = clearCurrent_url + '\&type=int' + '\&start=' + start + '\&end=' + end + '\&tags=' + $tags;
                })
                $("#datepicker5").datepicker({
                    maxDate: "+0D",
                    numberOfMonths: 2,
                    onSelect: function (startDate) {
                        var $startDate = $("#datepicker5");
                        var $endDate = $('#datepicker6');
                        $endDate.datepicker('option', 'maxDate', (new Date(Math.min(Date.parse(startDate) + 3600 * 1000 * 24 * 30, Date.parse(new Date())))));
                        $endDate.datepicker('option', 'minDate', startDate)
                    }
                });
                $("#datepicker6").datepicker({
                    maxDate: "+0D",
                    numberOfMonths: 2,
                    onSelect: function (endDate) {
                        var $startDate = $("#datepicker5");
                        var $endDate = $('#datepicker6');
                        $startDate.datepicker('option', 'minDate', new Date(Date.parse(endDate) - 3600 * 1000 * 24 * 30));
                        $startDate.datepicker('option', 'maxDate', endDate)
                    }
                })
                var legend = [];
                <?php foreach ($xData as $value){ ?>
                legend.push("<?php echo $value; ?>");
                <?php } ?>
                var xData = [];
                <?php foreach ($presults as $key => $value){ ?>
                xData.push("<?php echo $key; ?>");
                <?php } ?>
                console.info(legend);

                var pData = [];
                var pyData = [];
                <?php foreach ($xData as $key=>$val){ ?>
                var val=[];
                <?php foreach ($presults as $item){ ?>
                val.push(<?php echo $item[$key]; ?>)
                <?php } ?>
                pData.push(val);
                <?php } ?>
                for (var i = 0; i < legend.length; i++) {
                    pyData.push({
                        name: legend[i],
                        type: 'line',
                        data: pData[i]
                    })
                }
                console.info(pyData)


                var view_datas = [];
                var item_view = [];
                var viewCount=[];//储存饼状图计数数据
                <?php foreach ($viewTop10 as $key=>$value){ ?>
                var dav = [];
                <?php foreach ($vresults as $index=>$item){ ?>
                var num = '<?php echo $item[$value->post_title]; ?>';
                dav.push(num == '' ? 0 : num)
                <?php } ?>
                item_view.push('<?php echo $value->post_title; ?>')
                //饼状图计数测试
                viewCount.push('<?php echo $value->c; ?>')
                //饼状图计数测试
                view_datas.push(dav);
                <?php } ?>

                //饼状图数据存储
                var pieData = [];
                for(var i = 0; i < view_datas.length;i++){
                    pieData.push({
                            name:item_view[i],
                            value:viewCount[i]
                        }

                    )
                }

                var myChart3 = echarts.init(document.getElementById('project_tag'));
                // var myChart4 = echarts.init(document.getElementById('qa_tag'));
                var myChart5 = echarts.init(document.getElementById('pie_chart'));

                myChart3.setOption({
                    title: {
//                text: '浏览词条TOP10'
                    },
                    tooltip: {
                        trigger: 'axis'
                    },
                    legend: {
                        data: legend
                    },
                    grid: {
                        left: '3%',
                        right: '4%',
                        bottom: '3%',
                        containLabel: true
                    },
                    xAxis: {
                        type: 'category',
                        boundaryGap: false,
                        data: xData
                    },
                    yAxis: {
                        type: 'value'
                    },
                    series: pyData
                });


                <!--测试饼状图 -->
                option = {
                    title : {
                        text: '',
                        subtext: '',
                        x:'center'
                    },
                    tooltip : {
                        trigger: 'item',
                        formatter: "{a} <br/>{b} : {c} ({d}%)"
                    },
                    legend: {
                        orient: 'vertical',
                        left: 'left',
                        data: item_view
                    },
                    series : [
                        {
                            name: '访问来源',
                            type: 'pie',
                            radius : '55%',
                            center: ['50%', '60%'],
                            data:pieData,
                            itemStyle: {
                                emphasis: {
                                    shadowBlur: 10,
                                    shadowOffsetX: 0,
                                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                                }
                            }
                        }
                    ]
                };
                ;myChart5.setOption(option, true);
                <!-- 测试饼状图结束 -->
            })
        </script>
    <?php } ?>
    <!--    兴趣分布 结束-->

</div>
<!--页面内容 结束-->