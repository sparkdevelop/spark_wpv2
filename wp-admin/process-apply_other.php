<?php
global $wpdb;
require_once(dirname(__FILE__) . '/admin.php');

//提交内容
$task_content = isset($_POST["task_other_editor"]) ? $_POST["task_other_editor"] : '';
//成员数组
$team_member = isset($_POST["team_member"]) ? $_POST["team_member"] : [];
//隐藏信息
$task_id = isset($_POST["task_id"]) ? $_POST["task_id"] : '';
//$id = isset($_POST["user_id"]) ? $_POST["user_id"] : '';

/* step0: 检查team_id是否为空;若不为空->step1;
 * step1: 插入成员团队表 (首先按顺序确定对应的小组id) 成员的名字要转化成为id?ajax判断??
 * step2: 插入成员任务表 (完成情况可以先写1,等老师评分后可以update,提交内容是内容,团队填写团队id)
 * step3: 跳转回任务页面
 * */


//step0:获取team_id
$sql_fun = "select team_id from wp_gp_member_team WHERE task_id = $task_id ORDER BY team_id DESC LIMIT 0,1";
$result = $wpdb->get_results($sql_fun);
$team_id = $result[0]->team_id + 1;
foreach ($team_member as $value) {
    $id = get_the_ID_by_name($value);
    $time = date('Y-m-d H:i:s', time() + 8 * 3600);
    $sql_insert_mt = "INSERT INTO wp_gp_member_team VALUES ('',$id,$task_id,$team_id)";
    $sql_insert_tm = "INSERT INTO wp_gp_task_member VALUES ('',$id,$task_id,0,'$time','$task_content',$team_id,'')";

    if ($id != "" && $task_id != "" && $team_id != "" && $task_content != "") {
        $wpdb->query($sql_insert_mt);
        $wpdb->query($sql_insert_tm);
    }
}

$url = site_url() . get_page_address('single_task') . '&id=' . $task_id;
?>
<script>
    location.replace("<?=$url?>");
</script>