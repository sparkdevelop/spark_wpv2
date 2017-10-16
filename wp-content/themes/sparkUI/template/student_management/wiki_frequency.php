<?php
/**
 * 词条频度页面
 */
?>
<style>
    .datepicker {
        border-radius: 4px;
        border: 1px solid #ccc;
        margin-left: 4px;
    }
    #tags{
        border-radius: 4px;
        border: 1px solid #ccc;
    }

    #submit {
        width: 60px;
        height: 25px;
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
    .time {
        margin-top: 10px;
    }
    .time input {
        border: 1px solid #ccc;
    }
    .title{
        line-height: 26px;
        margin-right: 10px;
        margin-left: 20px;
    }
    input[type=radio]{
        line-height: 26px;
        margin: 0 4px;
    }
    .chart_title {
        color: #fe642d;
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
    #word_search{
        margin: 20px 0 0 0px;
    }
</style>
<?php
global $wpdb;
$type = isset($_GET['type']) ? $_GET['type'] : 'fre';
$start = isset($_GET['start']) ? $_GET['start'] : '';
$end = isset($_GET['end']) ? $_GET['end'] : '';
$words = isset($_GET['words']) ? $_GET['words'] : '';
date_default_timezone_set("Asia/Shanghai");
if ($start == '' && $end == '') {
    $start = date("Y-m-d", strtotime("-6 day")); //默认为过去七天的数据
    $end = date("Y-m-d", strtotime("-0 day"));
} else if ($end == '') {
    $end = date("Y-m-d", strtotime("$start+6 day"));  //周期默认一周,如果起止有空的话
} else if ($start == '') {
    $start = date("Y-m-d", strtotime("$end-6 day"));
}
//----------词条频度--------------
$vresults = [];
$results = [];
$sql_view = 'SELECT `post_title`, COUNT(`post_title`) as c FROM `wp_user_history` 
                  LEFT JOIN `wp_posts` ON `wp_user_history`.`action_post_id` = `wp_posts`.`ID` 
                  WHERE `action_post_type`!="page" AND `post_title`!= "" 
                    AND `post_title` LIKE "%' . $words . '%" 
                    AND `action_time` >= "' . date("Y-m-d 00:00:00", strtotime($start)) . '" 
                    AND `action_time` <= "' . date("Y-m-d 23:59:59", strtotime($end)) . '" 
                  GROUP BY `post_title` ORDER BY c DESC LIMIT 10';
$viewTop10 = $wpdb->get_results($sql_view);

//print_r($viewTop10);

$sql_search = 'SELECT `words`,COUNT(`words`) as c FROM wp_search_datas 
               WHERE `words` LIKE "%' . $words . '%" AND `date` >= "' . date("Y-m-d 00:00:00", strtotime($start)) . '" 
               AND `date` <= "' . date("Y-m-d 23:59:59", strtotime($end)) . '" 
               GROUP BY `words` ORDER BY c DESC LIMIT 10';

$searchTop10 = $wpdb->get_results($sql_search);
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
} ?>
<div id="wiki_frequency">
    <div id="word_search">
        <label class="title" for="">词条检索:</label>
        <input id="tags" type="text" placeholder=""/>
    </div>
    <p class="time">
        <label class="title" for="">开始时间:</label>
            <input type="text" class="datepicker" id="datepicker1" value="<?= date("Y-m-d", time() - 3600 * 24 *7) ?>"/>
        <label class="title" for="">结束时间:</label>
            <input type="text" class="datepicker" id="datepicker2" value="<?= date("Y-m-d", time()) ?>"/></p>
    <p class="button clearfix" style="margin-left: 20px;">
        <a id="submit" class="btn-green">提交</a>
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
        <div id="view_chart" style="width:60vw;height:30vw;"></div>
        <br>
        <div class="chart_title">搜索词条TOP10</div>
        <div id="search_chart" style="width:60vw;height:30vw;"></div>
    </div>
</div>

<script>
    $(function () {
        $("#submit").click(function () {
            var start = $("#datepicker1").val();
            var end = $("#datepicker2").val();
            var current_url = '<?php echo remove_query_arg(array('start', 'end', 'words', 'type')); ?>';
            var words = $('#tags').val();
            if(words!=null){
                location.href = current_url + '&type=fre' + '&start=' + start + '&end=' + end + '&words=' + words;
            }else{
                location.href = current_url + '&type=fre' + '&start=' + start + '&end=' + end;
            }
        });
        jQuery('#datepicker1').datetimepicker({
            format: "yyyy-mm-dd",
            weekStart: 7,
            endDate: new Date(),
            autoclose: 1,
            startView: 2,
            minView: 2,         //日期时间选择器所能够提供的最精确的时间选择视图。
            todayBtn: 1,
            todayHighlight: 1,
            forceParse: 0,      //默认值
            showMeridian: 0,
            pickerPosition: "top-left"

//            onSelect: function (startDate) {
//                var $startDate = $("#datepicker1");
//                var $endDate = $('#datepicker2');
//                $endDate.datetimepicker('option', 'maxDate', (new Date(Math.min(Date.parse(startDate) + 3600 * 1000 * 24 * 30, Date.parse(new Date())))));
//                $endDate.datetimepicker('option', 'minDate', startDate)
//            }
        });
        jQuery('#datepicker2').datetimepicker({
            format: "yyyy-mm-dd",
            weekStart: 7,
            endDate: new Date(),
            autoclose: 1,
            startView: 2,
            minView: 2,         //日期时间选择器所能够提供的最精确的时间选择视图。
            todayBtn: 1,
            todayHighlight: 1,
            forceParse: 0,      //默认值
            showMeridian: 0,
            pickerPosition: "top-left"
//            autoclose: 1,
//            minView: 2,
//            pickerPosition: "top-left",
//            maxDate: "+0D",
//            numberOfMonths: 2,
//            onSelect: function (endDate) {
//                var $startDate = $("#datepicker1");
//                var $endDate = $('#datepicker2');
//                $startDate.datetimepicker('option', 'minDate', new Date(Date.parse(endDate) - 3600 * 1000 * 24 * 30));
//                $startDate.datetimepicker('option', 'maxDate', endDate)
//            }
        });

        var item_view = [];

        var item_search = [];
        var search_datas = [];
        <?php foreach ($searchTop10 as $key=>$value){ ?>
        var da = [];
        <?php foreach ($results as $index=>$item){ ?>
        var num = '<?php echo $item[$value->words]; ?>';
        da.push(num == '' ? 0 : num);
        <?php } ?>
        item_search.push('<?php echo $value->words; ?>');
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
        dav.push(num == '' ? 0 : num);
        <?php } ?>
        item_view.push('<?php echo $value->post_title; ?>');
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