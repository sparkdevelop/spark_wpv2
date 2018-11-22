<?php
global $wpdb;
$rows_day_keyword_arr=array();
$rows_day=array();
$arr_sort_day = array();
$rows_week_keyword_arr=array();
$rows_week=array();
$arr_sort_week = array();
$to=date('Y-m-d', time());
$from_day = date('Y-m-d', strtotime("-1 day")+8*3600);
$from_week = date('Y-m-d',strtotime("-1 week")+8*3600);
//======================================
//日
//===========选出所有keyword=============
$rows_day_keyword_obj= $wpdb->get_results("SELECT DISTINCT keywords FROM " . SS_TABLE . " WHERE  STR_TO_DATE(`query_date`,'%Y%m%d') BETWEEN '" . $from_day . "' AND '" . $to . "'");
foreach ($rows_day_keyword_obj as $keyword){
    $rows_day_keyword_arr[]=$keyword->keywords;
}
//===========选出所有keyword的总repeat_count,并将其对应===========
foreach ($rows_day_keyword_arr as $key => $temp){
    $sql_rows_day = "SELECT SUM(repeat_count) as repeat_count FROM ". SS_TABLE." WHERE keywords='$temp' and STR_TO_DATE(`query_date`,'%Y%m%d') BETWEEN '$from_day' AND '$to'";
    $rows_day_counts=$wpdb->get_results($sql_rows_day);
    // $rows_day_counts=$wpdb->get_results("SELECT SUM(repeat_count) as repeat_count FROM ". SS_TABLE . " WHERE keywords='".$temp."'");
    $rows_day[]=array('keyword'=>$temp,'repeat_count'=>$rows_day_counts[0]->repeat_count);
}
//===========对rows_day中的repeat_count排序,选出10个即可。========
foreach($rows_day as $key =>$value){
    foreach($value as $i =>$count){
        $arr_sort_day[$i][$key] = $count;
    }
}
array_multisort($arr_sort_day['repeat_count'],SORT_DESC,$rows_day);
//=====================================
//周
//===========选出所有keyword=============
$rows_week_keyword_obj= $wpdb->get_results("SELECT DISTINCT keywords FROM " . SS_TABLE . " WHERE  STR_TO_DATE(`query_date`,'%Y%m%d') BETWEEN '" . $from_week . "' AND '" . $to . "'");
foreach ($rows_week_keyword_obj as $keyword){
    $rows_week_keyword_arr[]=$keyword->keywords;
}
//===========选出所有keyword的总repeat_count,并将其对应===========
foreach ($rows_week_keyword_arr as $key => $temp){
    $sql_rows_week = "SELECT SUM(repeat_count) as repeat_count FROM ". SS_TABLE." WHERE keywords='$temp' and STR_TO_DATE(`query_date`,'%Y%m%d') BETWEEN '$from_week' AND '$to'";
    $rows_week_counts=$wpdb->get_results($sql_rows_week);
    // $rows_week_counts=$wpdb->get_results("SELECT SUM(repeat_count) as repeat_count FROM ". SS_TABLE . " WHERE keywords='".$temp."'");
    $rows_week[]=array('keyword'=>$temp,'repeat_count'=>$rows_week_counts[0]->repeat_count);
}
//===========对rows_day中的repeat_count排序,选出10个即可。========
foreach($rows_week as $key =>$value){
    foreach($value as $i =>$count){
        $arr_sort_week[$i][$key] = $count;
    }
}
array_multisort($arr_sort_week['repeat_count'],SORT_DESC,$rows_week);

?>

<div class="col-md-3 col-sm-3 col-xs-3 right" id="col3">
    <div class="sidebar_list">
        <div class="sidebar_list_header">
            <p>大家都在搜</p>
            <!--列表头-->
            <ul id="sidebar_list_choose" class="nav nav-pills" style="float: right">
                <li><a href="#searchday" data-toggle="tab" style="width: 20px;margin-top: 5px;">日</a></li>
                <li class="active"><a href="#searchweek" data-toggle="tab" style="width: 20px;margin-top: 5px;">周</a></li>
            </ul>
        </div>
        <!--分割线-->
        <div class="sidebar_divline"></div><!--下面的是列表!-->

        <!--列表内容 需要填写的都用php提取出来就行-->
        <div id="askerTabContent" class="tab-content">
            <div class="tab-pane fade" id="searchday">
                <ul class="list-group">
                    <?php
                    for($i=0;$i<10;$i++){
                        ?>
                        <li class="list-group-item">
                            <img src="<?php bloginfo("template_url")?>/img/n<?php echo $i+1;?>.png" style="display: inline-block;margin-right: 10px;">
                            <?php echo $rows_day[$i]['keyword'];?>
                            <p style="display: inline-block;float: right"><?php echo $rows_day[$i]['repeat_count'];?>次</p>
                        </li>
                        <?php } ?>
                </ul>
            </div>
            <div class="tab-pane fade in active" id="searchweek">
                <ul class="list-group">
                    <?php
                    for($i=0;$i<10;$i++){
                        ?>
                        <li class="list-group-item">
                            <img src="<?php bloginfo("template_url")?>/img/n<?php echo $i+1;?>.png" style="display: inline-block;margin-right: 10px;">
                            <?php echo $rows_week[$i]['keyword'];?>
                            <p style="display: inline-block;float: right"><?php echo $rows_week[$i]['repeat_count'];?>次</p>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div><!--asker-->
</div>