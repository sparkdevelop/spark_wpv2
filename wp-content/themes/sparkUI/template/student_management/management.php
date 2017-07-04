<?php
/**
 * Created by PhpStorm.
 * User: yueer
 * Date: 2017/6/26
 * Time: 下午2:41
 */
global $wpdb;
$type = $_GET['type'];
$start = $_GET['start'];
$end = $_GET['end'];
$words = $_GET['words'];
$tagss = $_GET['tags'];
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
if ($type == 'fre') {
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

//-----------行为轨迹--------------


//-----------兴趣分布--------------
if($type == 'int'){
    $tag_id = array();
    $tag_name = array();//存储每个链接的名字;
//    $link = array(); // 存储每个标签的链接;
    $tag_count = array();
//==============获取所有tag的id信息===============
    $tags = get_terms( 'dwqa-question_tag', array_merge( array( 'orderby' => 'count', 'order' => 'DESC' )));
//=============================
    foreach($tags as $key => $temp){
        $tag_id[]=$temp->term_id;
        $tag_name[]=$temp->name;
        $tag_count[]=$temp->count;
    }
    $tagArr =[];
    if($tagss == ''){
        for($i=0;$i<5;$i++){
            $tagArr[$i]=$tag_id[$i].'_'.$tag_name[$i];
        }
    }else{
        $tagArr=explode(",", $tagss);
    }
    $xData = [];
    $xDataId = [];
    foreach ($tagArr as $tag){
        $xData[]=explode("_", $tag)[1];
        $xDataId[]=explode("_", $tag)[0];
    }
    function getTagInfo($start,$end,$wpdb,$type,$xData){
        $results=[];
        for ($i = 0; $i < ((strtotime($end) - strtotime($start)) / 86400 + 1); $i++) {
            $currentDate = date("Y-m-d", strtotime("$start +" . $i . " day"));
            $startTime = date("Y-m-d 00:00:00", strtotime($currentDate));
            $endTime = date("Y-m-d 23:59:59", strtotime($currentDate));
            $presult = $wpdb->get_results('SELECT `wp_posts`.`ID`, COUNT(`wp_posts`.`ID`) as c FROM `wp_user_history` LEFT JOIN `wp_posts` ON `wp_user_history`.`action_post_id` = `wp_posts`.`ID` WHERE `action_post_type`="'.$type.'" AND `action_time` >= "' . $startTime . '" AND `action_time` <= "' . $endTime . '" GROUP BY `wp_posts`.`ID`');
            $newPresult=[];
            foreach ($presult as $value) {
                $info = get_the_terms($value->ID,$type.'_tag');
                foreach ($info as $in){
                    $newPresult[$in->name] += $value->c;
//                    echo $in->term_id;
//                    echo $in->name;
                }
            }
            $newPresult2=[];
            foreach ($xData as $xd){
                $newPresult2[] = $newPresult[$xd]?$newPresult[$xd]:0;
            }
            $results[$currentDate]=$newPresult2;
        }
        return $results;

    }
    $presults = getTagInfo($start,$end,$wpdb,'post',$xData);
    $qresults = getTagInfo($start,$end,$wpdb,'dwqa-question',$xData);
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
        margin-left: 15px;
        margin-right: 15px;
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
</style>
<link href="<?php bloginfo('stylesheet_directory') ?>/css/jquery-ui-1.9.2.custom.min.css" rel="stylesheet">
<script src="<?php bloginfo('stylesheet_directory') ?>/javascripts/jquery-1.8.3.js"></script>
<script src="<?php bloginfo('stylesheet_directory') ?>/javascripts/jquery-ui-1.9.2.custom.min.js"></script>
<script src="<?php bloginfo('stylesheet_directory') ?>/javascripts/datepicker-zh-CN.js"></script>
<!--页面内容 开始-->
<div class="col-md-9 col-sm-9 col-xs-12">
    <!--    学生管理导航栏 开始-->
    <div class="archive-nav">
        <ul id="leftTab" class="nav nav-pills" style="float: left;height: 42px;">
            <li class="" id="project"><a>所有</a></li>
            <li class="<?php echo $type == 'fre' ? 'active' : ''; ?>" id="project"><a
                    href="<?php echo esc_url(add_query_arg(array('type' => 'fre'), remove_query_arg(array('start', 'end', 'words', 'tags')))); ?>">词条频度</a>
            </li>
            <li class="<?php echo $type == 'tra' ? 'active' : ''; ?>" id="project"><a
                    href="<?php echo esc_url(add_query_arg(array('type' => 'tra'), remove_query_arg(array('start', 'end', 'words', 'tags')))); ?>">行为轨迹</a>
            </li>
            <li class="<?php echo $type == 'int' ? 'active' : ''; ?>" id="project"><a
                    href="<?php echo esc_url(add_query_arg(array('type' => 'int'), remove_query_arg(array('start', 'end', 'words', 'tags')))); ?>">兴趣分布</a>
            </li>
        </ul>
    </div>
    <div style="height: 2px;background-color: lightgray"></div>
    <br>
    <!--    学生管理导航栏 结束-->

    <!--    词条频度 开始-->
    <?php if ($type == 'fre') { ?>
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

            .chart_title {
                color: #fe642d;
            }
        </style>
        <div>
            <div class="search_bar">
                <form>
                    <div class="ui-widget input-group">
                        <input id="tags" type="text" placeholder="请输入要搜索的词条"/>
                    </div>
                </form>
            </div>
            <p class="time">
                <label class="title" for="">开始时间:</label><input type="text" class="datepicker" id="datepicker1"/>
                <label class="title" for="">结束时间:</label><input type="text" class="datepicker" id="datepicker2"/></p>
            <p class="button clearfix">
                <a id="submit">提交</a>
                <a href="<?php echo esc_url(add_query_arg(array(), remove_query_arg(array('start', 'end', 'words')))); ?>">默认</a>
            </p>
            <table class="table" id="view_table">
                <caption>浏览词条TOP10</caption>
                <tbody>
                <?php foreach ($viewTop10 as $key => $value) { ?>
                    <tr>
                        <td><?php echo $value->post_title; ?></td>
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
                <div id="search_chart" style="width:60vw;height:30vw;"></div>
                <br>
                <div class="chart_title">搜索词条TOP10</div>
                <div id="view_chart" style="width:60vw;height:30vw;"></div>
            </div>
        </div>

        <script>
            $(function () {
                $("#submit").click(function () {
                    var start = $("#datepicker1").datepicker("getDate");
                    var end = $("#datepicker2").datepicker("getDate");
                    if (end == null) {
                        end = new Date().toLocaleDateString()
                    } else {
                        end = end.toLocaleDateString();
                    }
                    if (start == null) {
                        start = new Date(Date.parse(end) - 3600 * 1000 * 24 * 6).toLocaleDateString();
                    } else {
                        start = start.toLocaleDateString();
                    }
                    var current_url = '<?php echo esc_url(add_query_arg(array(), remove_query_arg(array('start', 'end', 'words', 'type')))); ?>';
                    var words = $('#tags').val();
                    console.info(current_url)
                    location.href = current_url + '&type=fre' + '&start=' + start + '&end=' + end + '&words=' + words;
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
                <?php foreach ($viewTop10 as $key=>$value){ ?>
                var dav = [];
                <?php foreach ($vresults as $index=>$item){ ?>
                var num = '<?php echo $item[$value->post_title]; ?>';
                dav.push(num == '' ? 0 : num)
                <?php } ?>
                item_view.push('<?php echo $value->post_title; ?>')
                view_datas.push(dav);
                <?php } ?>

                var vyData = [];
                for (var i = 0; i < view_datas.length; i++) {
                    vyData.push({
                        name: item_view[i],
                        type: 'line',
                        data: view_datas[i]
                    })
                }

                var myChart1 = echarts.init(document.getElementById('view_chart'));
                var myChart2 = echarts.init(document.getElementById('search_chart'));
                var xData = [];
                <?php foreach ($xData as $value){ ?>
                xData.push('<?php echo $value; ?>');
                <?php } ?>
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


            });
        </script>
    <?php } ?>
    <!--    词条频度 结束-->

    <!--    行为轨迹 开始-->
    <?php if ($type == 'tra') { ?>
        <style>
            /*行为轨迹*/
            *, *:after, *:before {
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
            }

            .trail {
                width: 500px;
                color: black;
            }

            .top_title {
                text-align: center;
                font-size: 20px;
                font-weight: bold;
            }

            .cd-container {
                width: 90%;
                max-width: 800px;
                margin: 0 auto;
            }

            #cd-timeline {
                position: relative;
                padding: 2em 0;
                margin-top: 3em;
                margin-bottom: 3em;
            }

            /*垂直时间线*/
            #cd-timeline::before {
                content: '';
                position: absolute;
                top: 0;
                height: 100%;
                width: 4px;
                background: #d7e4ed;
                left: 50%;
                margin-left: -2px;
            }

            /*每个时间点及内容*/
            .cd-timeline-block {
                position: relative;
                margin: 4em 0;
            }

            .cd-timeline-block:after {
                content: "";
                display: table;
                clear: both;
            }

            .cd-timeline-block:first-child {
                margin-top: 0;
            }

            .cd-timeline-block:last-child {
                margin-bottom: 0;
            }

            /*圆形节点*/
            .cd-timeline-img {
                position: absolute;
                width: 30px;
                height: 30px;
                left: 53%;
                margin-left: -30px;
                border-radius: 50%;
                box-shadow: 0 0 0 4px white, inset 0 2px 0 rgba(0, 0, 0, 0.08), 0 3px 0 4px rgba(0, 0, 0, 0.05);
                -webkit-transform: translateZ(0);
                -webkit-backface-visibility: hidden;
            }

            .cd-timeline-img.cd-picture {
                background: #75ce66;
            }

            .cd-timeline-img.cd-movie {
                background: #c03b44;
            }

            .cd-timeline-img.cd-location {
                background: #f0ca45;
            }

            /*节点内容*/
            .cd-timeline-content {
                position: relative;
                background: #d7e4ed;
                border-radius: 0.25em;
                margin-left: 0;
                padding: 1.6em;
                width: 40%;
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

            /*偶数节点的位置*/
            .cd-timeline-block:nth-child(even) .cd-timeline-content {
                float: right;
            }

            .cd-timeline-block:nth-child(even) .cd-timeline-content .cd-date {
                left: auto;
                right: 150%;
                text-align: right;
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
            <input type="radio" name="ctype">问答标签
            <input type="radio" name="ctype">wiki分类
        </div>
        <div class="group">
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
                    <li><a href="javascript:void(0)" data-id="1">1个等级</a></li>
                    <li><a href="javascript:void(0)" data-id="2">2个等级</a></li>
                    <li><a href="javascript:void(0)" data-id="3">3个等级</a></li>
                    <li><a href="javascript:void(0)" data-id="10">10个等级</a></li>
                </ul>
            </div>
            <input type="radio" name="user">全部成员
            <input type="radio" name="user">最活跃成员
            <input type="radio" name="user">最受挫成员
        </div>
        <p class="time">
            <label class="title" for="">开始时间:</label><input type="text" class="datepicker" id="datepicker3"/>
            <label class="title" for="">结束时间:</label><input type="text" class="datepicker" id="datepicker4"/></p>
        <p class="button clearfix">
            <a id="submit">提交</a>
            <a href="<?php echo esc_url(add_query_arg(array(), remove_query_arg(array('start', 'end', 'words')))); ?>">默认</a>
        </p>
        <!--行为轨迹（均7个节点）-->
        <div class="trail">
            <h2 class="top_title">全部小组</h2>
            <section id="cd-timeline" class="cd-container">
                <div class="cd-timeline-block">
                    <div class="cd-timeline-img cd-picture"></div>
                    <div class="cd-timeline-content">
                        <!--最多三个标签，换行显示-->
                        <h2>电子设计</br>mcookie</br>Arduino</h2>
                        <span class="cd-date">2017-05-06</span>
                    </div>
                </div>

                <div class="cd-timeline-block">
                    <div class="cd-timeline-img cd-movie"></div>
                    <div class="cd-timeline-content">
                        <h2>红外</br>测距</h2>
                        <span class="cd-date">2017-05-07</span>
                    </div>
                </div>

                <div class="cd-timeline-block">
                    <div class="cd-timeline-img cd-location"></div>
                    <div class="cd-timeline-content">
                        <h2>蓝牙</h2>
                        <span class="cd-date">2017-05-08</span>
                    </div>
                </div>

                <div class="cd-timeline-block">
                    <div class="cd-timeline-img cd-picture"></div>
                    <div class="cd-timeline-content">
                        <h2>电子设计</br>mcookie</br>Arduino</h2>
                        <span class="cd-date">2017-05-09</span>
                    </div>
                </div>

                <div class="cd-timeline-block">
                    <div class="cd-timeline-img cd-movie"></div>
                    <div class="cd-timeline-content">
                        <h2>红外</br>测距</h2>
                        <span class="cd-date">2017-05-10</span>
                    </div>
                </div>

                <div class="cd-timeline-block">
                    <div class="cd-timeline-img cd-location"></div>
                    <div class="cd-timeline-content">
                        <h2>蓝牙</h2>
                        <span class="cd-date">2017-05-11</span>
                    </div>
                </div>

                <div class="cd-timeline-block">
                    <div class="cd-timeline-img cd-picture"></div>
                    <div class="cd-timeline-content">
                        <h2>电子设计</br>mcookie</br>Arduino</h2>
                        <span class="cd-date">2017-05-12</span>
                    </div>
                </div>

            </section>
        </div>
        <script>
            $(function () {
                $(".dropdown").delegate("ul li a","click",function(){
                    var text=$(this).text();
                    var level=$(this).attr("data-id");
                    var parent=$(this).parents(".dropdown");
                    parent.find("span").eq(0).text(text);
                    parent.attr("data-id",level);
                    $(this).parents(".form-group").nextAll(".prize_input_box").each(function(){
                        if($(this).index()<=parseInt(level)){
                            $(this).show();
                            console.log("v");
                        }else{
                            $(this).hide();
                        }
                    });
                });
            })
        </script>

    <?php } ?>
    <!--    行为轨迹 结束-->

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
<!--        <div class="classify">-->
<!--            <label class="title" for="">类别:</label>-->
<!--            <input type="radio" name="ctype">问答标签-->
<!--            <input type="radio" name="ctype">wiki分类-->
<!--        </div>-->
        <div>
            <label class="title" for="">自选标签(可选5个):</label>
            <div id="all_tags" style="word-wrap: break-word; word-break: keep-all;">
                <?php
                foreach ($tag_name as $key =>$i){?>
                    <input type="checkbox" name="tags" value="<?=$tag_id[$key]?>_<?=$i?>"><?=$i?><span class="badge">(<?=$tag_count[$key]?>)</span>
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
            <a href="<?php echo esc_url(add_query_arg(array(), remove_query_arg(array('start', 'end', 'words')))); ?>">默认</a>
        </p>
        <div class="interest">
            <div id="main1" class="main1"></div>
            <div id="main2" class="main2"></div>
        </div>
        <script>
            $(function () {
                $("#submit").click(function () {
                    var chk_value =[];
                    $('input[name="tags"]:checked').each(function(){
                        chk_value.push($(this).val());
                    });
                    if(chk_value.length!=5){
                        alert('请选择5个标签!')
                    }else{
                        var start = $("#datepicker5").datepicker("getDate");
                        var end = $("#datepicker6").datepicker("getDate");
                        if (end == null) {
                            end = new Date().toLocaleDateString()
                        } else {
                            end = end.toLocaleDateString();
                        }
                        if (start == null) {
                            start = new Date(Date.parse(end) - 3600 * 1000 * 24 * 6).toLocaleDateString();
                        } else {
                            start = start.toLocaleDateString();
                        }
                        $tags=chk_value.join(',');
                        var current_url = '<?php echo esc_url(add_query_arg(array(), remove_query_arg(array('start', 'end', 'tags', 'type')))); ?>';
                        location.href = current_url + '&type=int' + '&start=' + start + '&end=' + end + '&tags=' + $tags;

                    }
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
                var xData = [];
                <?php foreach ($xData as $value){ ?>
                xData.push({text:'<?php echo $value; ?>'});
                <?php } ?>

                var pData = [];
                var qData = [];
                <?php foreach ($presults as $key=>$presult){ ?>
                var val=[];
                <?php foreach ($presult as $item){ ?>
                val.push(<?php echo $item; ?>)
                <?php } ?>
                pData.push({
                    value: val,
                    name: '<?php echo $key; ?>'
                });
                <?php } ?>
                <?php foreach ($qresults as $key=>$qresult){ ?>
                var val=[];
                <?php foreach ($qresult as $item){ ?>
                val.push(<?php echo $item; ?>)
                <?php } ?>
                qData.push({
                    value: val,
                    name: '<?php echo $key; ?>'
                });
                <?php } ?>
                console.info(qData)
                console.info(qData[0])
                var myChart3 = echarts.init(document.getElementById('main1'));

                var option3 = {
                    title: {
                        // 主标签为问答标签／wiki分类，副标签为Top5（默认的副标签）／自选／全部
                        text: '项目标签',
                        subtext: '自选',
                        x: 'left',
                        y: 'top'
                    },
                    tooltip: {
                        trigger: 'item',
                        backgroundColor: 'rgba(0,0,250,0.2)'
                    },
                    visualMap: {
                        color: ['red', 'yellow']
                    },
                    radar: {
                        indicator: xData
                    },
                    series: [{
                        type: 'radar',
                        symbol: 'none',
                        itemStyle: {
                            normal: {
                                lineStyle: {
                                    width: 1
                                }
                            },
                            emphasis: {
                                areaStyle: {color: 'rgba(0,250,0,0.3)'}
                            }
                        },
                        data: pData}]
                };
                myChart3.setOption(option3);

                var myChart4 = echarts.init(document.getElementById('main2'));
                var option4 = {
                    title: {
                        text: 'wiki分类',
                        subtext: 'Top5',
                        x: 'left',
                        y: 'top'
                    },
                    tooltip: {
                        trigger: 'item',
                        backgroundColor: 'rgba(0,0,250,0.2)'
                    },
                    visualMap: {
                        color: ['red', 'yellow']
                    },
                    radar: {
                        indicator: xData
                    },
                    series: [{
                        type: 'radar',
                        symbol: 'none',
                        itemStyle: {
                            normal: {
                                lineStyle: {
                                    width: 1
                                }
                            },
                            emphasis: {
                                areaStyle: {color: 'rgba(0,250,0,0.3)'}
                            }
                        },
                        data: qData}]
                };
                myChart4.setOption(option4);
            })
        </script>
    <?php } ?>
    <!--    兴趣分布 结束-->

</div>
<!--页面内容 结束-->


