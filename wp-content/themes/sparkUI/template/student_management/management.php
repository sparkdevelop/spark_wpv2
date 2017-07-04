<?php
/**
 * Created by PhpStorm.
 * User: yueer
 * Date: 2017/6/26
 * Time: 下午2:41
 */
global $wpdb;
//echo esc_url(add_query_arg(array('test'=>'hh')));
//$current_url = esc_url(add_query_arg(array(), remove_query_arg(array('start','words'))));
//echo $current_url;
$type = $_GET['type'];
$start = $_GET['start'];
$end = $_GET['end'];
date_default_timezone_set("Asia/Shanghai");
$words = $_GET['words'];
if ($start == '' && $end == '') {
    $start = date("Y-m-d", strtotime("-6 day"));
    $end = date("Y-m-d", strtotime("-0 day"));
} else if ($end == '') {
    $end = date("Y-m-d", strtotime("$start+6 day"));
} else if ($start == '') {
    $start = date("Y-m-d", strtotime("$end-6 day"));
}
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
?>
<style>
    .nav_bar span {
        font-size: 24px;
        margin-right: 15px;
    }

    .search_bar {
        width: 40%;
    }

    .time input {
        margin-left: 15px;
        margin-right: 15px;
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

    #datepicker1, #datepicker2, #tags {
        border-radius: 4px;
    }

    #submit {
        width: 50px;
        height: 25px;
        cursor: pointer;
    }

    .spark {
        width: 1500px;
        height: 600px;
    }

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


</style>
<link href="<?php bloginfo('stylesheet_directory') ?>/css/jquery-ui-1.9.2.custom.min.css" rel="stylesheet">
<script src="<?php bloginfo('stylesheet_directory') ?>/javascripts/jquery-1.8.3.js"></script>
<script src="<?php bloginfo('stylesheet_directory') ?>/javascripts/jquery-ui-1.9.2.custom.min.js"></script>
<script src="<?php bloginfo('stylesheet_directory') ?>/javascripts/datepicker-zh-CN.js"></script>
<div class="col-md-9 col-sm-9 col-xs-12">
    <div class="archive-nav">
        <ul id="leftTab" class="nav nav-pills" style="float: left;height: 42px;">
            <li class="" id="project"><a>所有</a></li>
            <li class="<?php echo $type == 'fre' ? 'active' : ''; ?>" id="project"><a
                    href="<?php echo esc_url(add_query_arg(array('type' => 'fre'), remove_query_arg(array('start', 'end', 'words')))); ?>">词条频度</a>
            </li>
            <li class="<?php echo $type == 'tra' ? 'active' : ''; ?>" id="project"><a
                    href="<?php echo esc_url(add_query_arg(array('type' => 'tra'), remove_query_arg(array('start', 'end', 'words')))); ?>">行为轨迹</a>
            </li>
            <li class="<?php echo $type == 'int' ? 'active' : ''; ?>" id="project"><a
                    href="<?php echo esc_url(add_query_arg(array('type' => 'int'), remove_query_arg(array('start', 'end', 'words')))); ?>">兴趣分布</a>
            </li>
        </ul>
    </div>
    <div style="height: 2px;background-color: lightgray"></div>
    <br>
    <?php if ($type == 'fre') { ?>
        <div>
            <div class="search_bar">
                <form>
                    <div class="ui-widget input-group">
                        <input id="tags" type="text" placeholder="请输入要搜索的词条"/>
                    </div>
                </form>
            </div>
            <br>
            <p class="time">开始时间:<input type="text" id="datepicker1"/>结束时间:<input type="text" id="datepicker2"/></p>
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

    <?php if ($type == 'tra') { ?>
        <div>
            <span>类别:</span>
            <input type="radio">问答标签
            <input type="radio">wiki分类
        </div>
        <div>
<!--            <div class="dropdown" data-id="3">-->
<!--                <button type="button" class="btn btn-default dropdown-toggle"-->
<!--                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
<!--                    <span class="caret"></span>-->
<!--                    <span class="sr-only">Toggle Dropdown</span>-->
<!--                </button>-->
<!--                <ul class="dropdown-menu">-->
<!--                    <li><a href="javascript:void(0)" data-id="1">1个等级</a></li>-->
<!--                    <li><a href="javascript:void(0)" data-id="2">2个等级</a></li>-->
<!--                    <li><a href="javascript:void(0)" data-id="3">3个等级</a></li>-->
<!--                    <li><a href="javascript:void(0)" data-id="4">4个等级</a></li>-->
<!--                    <li><a href="javascript:void(0)" data-id="5">5个等级</a></li>-->
<!--                    <li><a href="javascript:void(0)" data-id="6">6个等级</a></li>-->
<!--                    <li><a href="javascript:void(0)" data-id="7">7个等级</a></li>-->
<!--                    <li><a href="javascript:void(0)" data-id="8">8个等级</a></li>-->
<!--                    <li><a href="javascript:void(0)" data-id="9">9个等级</a></li>-->
<!--                    <li><a href="javascript:void(0)" data-id="10">10个等级</a></li>-->
<!--                </ul>-->
<!--            </div>-->
        </div>
        <br>
        <p class="time">开始时间:<input type="text" id="datepicker1"/>结束时间:<input type="text" id="datepicker2"/></p>
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

    <?php } ?>

    <?php if ($type == 'int') { ?>
        <div class="classify">
            <label for="">类别:</label>
            <input type="radio" value="">问答标签
            <input type="radio" value="">wiki分类
        </div>
        <div>
            自选标签(可选5个):<input type="radio">全选
            <br>
            <input type="checkbox">电子设计
            <input type="checkbox">红外
        </div>
        <br>
        <p class="time">开始时间:<input type="text" id="datepicker1"/>结束时间:<input type="text" id="datepicker2"/></p>
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
                var myChart3 = echarts.init(document.getElementById('main1'));
                var option3 = {
                    title: {
                        // 主标签为问答标签／wiki分类，副标签为Top5（默认的副标签）／自选／全部
                        text: '问答标签',
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
                        indicator: [
                            {text: '电子设计', max: 400},
                            {text: '红外', max: 400},
                            {text: '蓝牙', max: 400},
                            {text: '测距', max: 400},
                            {text: 'mcookie', max: 400}
                        ]
                    },
                    series: (function () {
                        var series = [];
                        for (var i = 1; i <= 28; i++) {
                            series.push({
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
                                data: [
                                    {
                                        value: [
                                            (40 - i) * 10,
                                            (38 - i) * 4 + 60,
                                            i * 5 + 10,
                                            i * 9,
                                            i * i / 2
                                        ],
                                        name: '2017年5月' + i + '日'
                                    }
                                ]
                            });
                        }
                        return series;
                    })()
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
                        indicator: [
                            {text: '导论实验课', max: 400},
                            {text: 'Arduino语法', max: 400},
                            {text: 'Web学习', max: 400},
                            {text: '计算机基础原理', max: 400},
                            {text: '电子电路基础课', max: 400}
                        ]
                    },
                    series: (function () {
                        var series = [];
                        for (var i = 1; i <= 28; i++) {
                            series.push({
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
                                data: [
                                    {
                                        value: [
                                            (40 - i) * 10,
                                            (38 - i) * 4 + 60,
                                            i * 5 + 10,
                                            i * 9,
                                            i * i / 2
                                        ],
                                        name: '2017年5月' + i + '日'
                                    }
                                ]
                            });
                        }
                        return series;
                    })()
                };
                myChart4.setOption(option4);
            })
        </script>
    <?php } ?>
</div>

