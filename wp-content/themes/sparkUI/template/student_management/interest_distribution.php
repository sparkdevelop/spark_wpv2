<?php
/**
 * 兴趣分布
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
    foreach ($tagArr as $tag){
        $xData[]=explode("_", $tag)[1];
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
?>
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
        <label class="title" for="">自选标签:</label>
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
        <a href="<?php echo esc_url(add_query_arg(array(), remove_query_arg(array('start', 'end', 'words','tags')))); ?>">默认</a>
    </p>
    <div style="width: 100%;clear: both;">
        <div class="chart_title">项目标签</div>
        <div id="project_tag" style="width:60vw;height:30vw;"></div>
        <br>
        <div class="chart_title">问答标签</div>
        <div id="qa_tag" style="width:60vw;height:30vw;"></div>
    </div>
    <script>
        $(function () {
            $("#submit").click(function () {
                var chk_value =[];
                $('input[name="tags"]:checked').each(function(){
                    chk_value.push($(this).val());
                });
                var start = $("#datepicker5").datetimepicker("getDate");
                var end = $("#datepicker6").datetimepicker("getDate");
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
            })
            $("#datepicker5").datetimepicker({
                maxDate: "+0D",
                numberOfMonths: 2,
                onSelect: function (startDate) {
                    var $startDate = $("#datepicker5");
                    var $endDate = $('#datepicker6');
                    $endDate.datetimepicker('option', 'maxDate', (new Date(Math.min(Date.parse(startDate) + 3600 * 1000 * 24 * 30, Date.parse(new Date())))));
                    $endDate.datetimepicker('option', 'minDate', startDate)
                }
            });
            $("#datepicker6").datetimepicker({
                maxDate: "+0D",
                numberOfMonths: 2,
                onSelect: function (endDate) {
                    var $startDate = $("#datepicker5");
                    var $endDate = $('#datepicker6');
                    $startDate.datetimepicker('option', 'minDate', new Date(Date.parse(endDate) - 3600 * 1000 * 24 * 30));
                    $startDate.datetimepicker('option', 'maxDate', endDate)
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
            console.info(legend)

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
            var qData = [];
            var qyData = [];
            <?php foreach ($xData as $key=>$value){ ?>
            var val=[];
            <?php foreach ($qresults as $item){ ?>
            val.push(<?php echo $item[$key]; ?>)
            <?php } ?>
            qData.push(val);
            <?php } ?>
            for (var i = 0; i < legend.length; i++) {
                qyData.push({
                    name: legend[i],
                    type: 'line',
                    data: qData[i]
                })
            }

            var myChart3 = echarts.init(document.getElementById('project_tag'));
            var myChart4 = echarts.init(document.getElementById('qa_tag'));

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
            myChart4.setOption({
                title: {
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
                series: qyData
            })
        })
    </script>